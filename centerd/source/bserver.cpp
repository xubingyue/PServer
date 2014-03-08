#include "bserver.hpp"

#include "centerp_services.h"
#include "bserver_service_handler.hpp"

#include <signal.h>
#include <sys/stat.h>

#include "event2/event.h"
#include "event2/event_struct.h"


#include "thrift/protocol/TBinaryProtocol.h"
#include "thrift/server/TThreadedServer.h"
#include "thrift/transport/TServerSocket.h"
#include "thrift/transport/TBufferTransports.h"
#include "thrift/async/TAsyncProtocolProcessor.h"
#include "thrift/async/TEvhttpServer.h"
#include "thrift/async/TEvhttpClientChannel.h"

#include "bserver_config.hpp"
#include "bserver_db.hpp"
#include "bserver_log.hpp"
#include "bserver_errno.hpp"


#define BSERVER_VERSION "0.0.1"

using namespace BGame::BServer;
using boost::shared_ptr;

using namespace ::apache::thrift;
using namespace ::apache::thrift::server;
using apache::thrift::async::TEvhttpServer;
using apache::thrift::async::TAsyncProcessor;
using apache::thrift::async::TAsyncBufferProcessor;
using apache::thrift::async::TAsyncProtocolProcessor;
using apache::thrift::async::TAsyncChannel;

struct event_base* g_event_base;



static TEvhttpServer *bserver = NULL;
static std::string config_file;

static void usage()
{
	fprintf(stderr, "Usage: bserver [options] bserver.conf\n\n");
	fprintf(stderr, "Use bserver -help for a list of options\n");
	exit(1);
}

static void help()
{
	fprintf(stderr, "Usage: bserver [options] bserver.conf\n");
	fprintf(stderr, "Options:\n");
	fprintf(stderr, "  -version\n");
	exit(1);
}

static void version()
{
	printf("BServer version %s\n", BSERVER_VERSION);
	exit(1);
}


static int g_sig_cmd;//信号指令

#define SIG_CMD_NOP 			1000							//空指令
#define SIG_CMD_FINISH 			1001							//结束程序
#define SIG_CMD_RELOAD 			1002							//重新加载配置文件



static void sig_process(int fd __attribute__((unused))
				, short event __attribute__((unused))
				, void *argc __attribute__((unused)))
{
	switch(g_sig_cmd)
	{
	case SIG_CMD_FINISH:
		bserver_terminate();
		DEBUG_LOG("BServer terminated.");
		break;
	case SIG_CMD_RELOAD:
		bserver_reload_config(config_file);
		DEBUG_LOG("BServer reload.");
		break;
	}
	g_sig_cmd = SIG_CMD_NOP;
}


//很多函数不可以在这里调用， 所以改为异步处理
static void sig_on_sigterm(int iSig)
{
	if(bserver == NULL)
	{
		goto done;
	}
	
	switch(iSig)
	{
	case SIGTERM:
		g_sig_cmd = SIG_CMD_FINISH;
		break;
	case SIGUSR1:
		g_sig_cmd = SIG_CMD_RELOAD;
		break;
	default:
		goto done;
	}


	struct timeval sig_tv;
	evutil_timerclear(&sig_tv);
	sig_tv.tv_sec=0;
	sig_tv.tv_usec=1;

	
	struct event sig_event;
	event_assign(&sig_event, bserver->getEventBase(), -1, 0, sig_process, NULL);


	event_add(&sig_event, &sig_tv);
	
done:
	return;
}

static int sig_init()
{
	struct sigaction stAct;
	memset(&stAct, 0, sizeof(stAct));
	stAct.sa_handler = sig_on_sigterm;

	
	sigaction(SIGTERM, &stAct, NULL);
	sigaction(SIGUSR1, &stAct, NULL);
	return E_BS_NOERROR;
}

static int write_pid(const char* pf_path)
{
	FILE *pf_out;
	pf_out = fopen(pf_path, "w");

	if (pf_out == NULL)
	{
		goto ERROR_RET;
	}
	fprintf(pf_out,"%d", getpid());
	fclose(pf_out);
	return E_BS_NOERROR;
ERROR_RET:
   	ERROR_LOG("can not open pid file %s.", pf_path);
	return E_BS_ERROR;
}

static int daemon_init()
{
	int fd;
	
	// shield some signals
	signal(SIGALRM, SIG_IGN);
	signal(SIGINT,  SIG_IGN);
	signal(SIGHUP,  SIG_IGN);
	signal(SIGQUIT, SIG_IGN);
	signal(SIGPIPE, SIG_IGN);
	signal(SIGTTOU, SIG_IGN);
	signal(SIGTTIN, SIG_IGN);
	signal(SIGCHLD, SIG_IGN);
	signal(SIGTERM, SIG_IGN);

	// fork child process
	if (fork())
	{
		exit(0);
	}

	// creates  a new session
	if (setsid() == -1)
	{
		exit(1);
	}


	for(fd = 0 ;fd < NOFILE; ++fd)
	{
		close(fd);
	}
	chdir(g_bserver_config.chdir.c_str());
	umask(0);


	return E_BS_NOERROR;
}



void bserver_terminate()
{
	if(bserver != NULL)
	{
		event_base_loopexit(bserver->getEventBase(), NULL);
	}   	
}

static int bserver_work(int port)
{
	shared_ptr<centerp_servicesHandler> handler(new centerp_servicesHandler());
	shared_ptr<TAsyncProcessor> proc(new centerp_servicesAsyncProcessor(handler));
	shared_ptr<TProtocolFactory> pfact(new TBinaryProtocolFactory());
	shared_ptr<TAsyncBufferProcessor> bufproc(new TAsyncProtocolProcessor(proc, pfact));
	bserver = new TEvhttpServer(bufproc, port);	
	g_event_base = bserver->getEventBase();
	DEBUG_LOG("BServer started.");
	
	if(bserver_db_init() != E_BS_NOERROR)
	{
		goto ERROR_RET;
	}	
	bserver->serve();

	
	bserver_db_fini();
	delete bserver;
	return E_BS_NOERROR;
ERROR_RET:
	return E_BS_ERROR;
}

int main(int argc, char **argv)
{
	int i;
    char* arg;
	if (argc < 2)
	{
		usage();
	}
	for (i = 1; i < argc; i++)
	{
		arg = strtok(argv[i], " ");
		while (arg != NULL)
		{
			if(arg[0] == '-' && arg[1] == '-')
			{
				++arg;
			}

			if(strcmp(arg, "-help") == 0)
			{
				help();
			}
			else if(strcmp(arg, "-version") == 0) 
			{
				version();
			}
			else
			{
				if(i == argc - 1)
				{
					//try to load config file
					break;
				}
		        fprintf(stderr, "Unrecognized option: %s\n", arg);
				usage();
			}
			arg = strtok(NULL, " ");
		}
	}

	config_file = argv[argc - 1];

	if(bserver_load_config(config_file) != E_BS_NOERROR)
	{
        fprintf(stderr, "load config file [%s] failed.\n", config_file.c_str());
		exit(1);
	}

	
	if(g_bserver_config.daemonize)
	{
		if(daemon_init() != E_BS_NOERROR)
		{
			goto ERROR_RET;
		}
	}
	
	chdir(g_bserver_config.chdir.c_str());
	
	
	if(bserver_log_init() != E_BS_NOERROR)
	{
		goto ERROR_RET;
	}

	if(sig_init() != E_BS_NOERROR)
	{
		goto ERROR_RET;
	}
	
	if(write_pid(g_bserver_config.pidfile.c_str()) != E_BS_NOERROR)
	{
		goto FREE_PIDFILE;
	}

	if(bserver_work(g_bserver_config.port) != E_BS_NOERROR)
	{
		goto ERROR_RET;
	}

	remove(g_bserver_config.pidfile.c_str());

	return 0;
	
FREE_PIDFILE:
	remove(g_bserver_config.pidfile.c_str());

ERROR_RET:
	exit(1);
}

