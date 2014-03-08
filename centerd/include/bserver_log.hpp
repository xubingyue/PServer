#ifndef _H__BSERVER_LOG__
#define _H__BSERVER_LOG__

int bserver_log_init();

#include "log4cpp/Category.hh"


extern log4cpp::Category *root_log_instance;
#define DEBUG_LOG(fmt, args...) (root_log_instance->debug(fmt, ##args))
#define ERROR_LOG(fmt, args...) (root_log_instance->error(fmt, ##args))
#define FATAL_LOG(fmt, args...) (root_log_instance->fatal(fmt, ##args))



extern log4cpp::Category *cs_log_instance;
#define INFO_CSLOG(fmt, args...) (cs_log_instance->info(fmt, ##args))

#endif//_H__BSERVER_LOG__

