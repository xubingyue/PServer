#include "centerd.hpp"
#include "centerd_service_handler.hpp"
#include "perrno.hpp"

#include <thrift/protocol/TBinaryProtocol.h>
#include <thrift/concurrency/PosixThreadFactory.h>
#include <thrift/server/TThreadPoolServer.h>
#include <thrift/transport/TServerSocket.h>
#include <thrift/transport/TBufferTransports.h>

#include <signal.h>


using namespace ::apache::thrift;
using namespace ::apache::thrift::protocol;
using namespace ::apache::thrift::transport;
using namespace ::apache::thrift::server;
using namespace ::apache::thrift::concurrency;

using boost::shared_ptr;
using namespace BGame::BServer;

static TThreadPoolServer *g_server = NULL;

/*
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
*/

static void sig_on_sigterm(int iSig)
{
	switch(iSig)
	{
	case SIGTERM:
		g_server->stop();
		break;
	default:
		break;
	}
}

static int sig_init()
{
	struct sigaction stAct;
	memset(&stAct, 0, sizeof(stAct));
	stAct.sa_handler = sig_on_sigterm;

	
	sigaction(SIGTERM, &stAct, NULL);
	return E_BS_NOERROR;
}


static void bserver_work(int port, int workerCount)
{
	shared_ptr<centerp_services_handler> handler(new centerp_services_handler());
	shared_ptr<TProcessor> processor(new centerp_servicesProcessor(handler));
	shared_ptr<TServerTransport> serverTransport(new TServerSocket(port));
	shared_ptr<TTransportFactory> transportFactory(new TBufferedTransportFactory());
	shared_ptr<TProtocolFactory> protocolFactory(new TBinaryProtocolFactory());
	shared_ptr<ThreadManager> threadManager = ThreadManager::newSimpleThreadManager(workerCount);
	shared_ptr<PosixThreadFactory> threadFactory = shared_ptr<PosixThreadFactory>(new PosixThreadFactory());
	threadManager->threadFactory(threadFactory);
	threadManager->start();
	g_server = new TThreadPoolServer(processor,
                           serverTransport,
                           transportFactory,
                           protocolFactory,
                           threadManager);
  
	g_server->serve();
}

int main(int argc, char **argv)
{
	if(sig_init() != E_BS_NOERROR)
	{
		goto ERROR_RET;
	}
	
	bserver_work(80, 10);

	return 0;	
ERROR_RET:
	return 1;
}

