#ifndef _H__BSERVER_DB__
#define _H__BSERVER_DB__

#include "async.h"
#include <stdarg.h>


extern redisAsyncContext *g_dbconn;


template <class T, void (T::*FUN)(const redisReply *reply)>
void bserver_db_callback(redisAsyncContext *c __attribute__((unused)), void *r, void *privdata)
{
	T *self = (T*)privdata;
	if(self != NULL)
	{
		(self->*FUN)((const redisReply*)r);
	}
}

#define BSD_CMD_LENGTH 1024
template <class T, void (T::*FUN)(const redisReply *reply)>
void bserver_db_cmd(T *self, const char *fmt, ...)
{
	char cmd[BSD_CMD_LENGTH];	

	va_list argptr;
	va_start(argptr, fmt);
	vsnprintf(cmd, BSD_CMD_LENGTH, fmt, argptr);
	va_end(argptr);

	redisAsyncCommand(g_dbconn, bserver_db_callback<T, FUN>, self, cmd);
}

int bserver_db_init();

void bserver_db_fini();


//这里定义数据库
#define BSD_GET_ACCOUNT_PASSWORD "GET account:[%s]:password"


#endif//_H__BSERVER_DB__
