#include "bserver_db.hpp"
#include "bserver_log.hpp"
#include "bserver.hpp"
#include "bserver_config.hpp"
#include "bserver_errno.hpp"

#include <stdlib.h>
#include "async.h"
#include "adapters/libevent.h"


redisAsyncContext *g_dbconn;

static void bserver_db_connect_callback(const redisAsyncContext *c, int status)
{
    if (status != REDIS_OK)
	{
    	ERROR_LOG("Redis Connected failed [%s]", c->errstr);
		g_dbconn = NULL;
		bserver_terminate();
    }
	else
	{
    	DEBUG_LOG("Redis Connected");
	}
}

static void bserver_db_disconnect_callback(const redisAsyncContext *c, int status)
{
    if (status != REDIS_OK)
	{
    	ERROR_LOG("Redis disconnected [%s]", c->errstr);
		g_dbconn = NULL;
		bserver_terminate();
    }
	else
	{
    	DEBUG_LOG("Redis disconnected.");
	}
}

int bserver_db_init()
{
	g_dbconn = redisAsyncConnect(g_bserver_config.redis_host.c_str(), g_bserver_config.redis_port);
	
	redisLibeventAttach(g_dbconn, g_event_base);	
	redisAsyncSetConnectCallback(g_dbconn, bserver_db_connect_callback);
	redisAsyncSetDisconnectCallback(g_dbconn, bserver_db_disconnect_callback);

	return E_BS_NOERROR;
}

void bserver_db_fini()
{
	if(g_dbconn != NULL)
	{
		redisAsyncDisconnect(g_dbconn);
	}
}

