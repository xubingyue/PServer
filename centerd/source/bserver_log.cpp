#include "bserver_log.hpp"
#include "bserver_config.hpp"
#include "bserver_errno.hpp"

#include "log4cpp/Category.hh"
#include "log4cpp/PropertyConfigurator.hh"


log4cpp::Category *root_log_instance;

log4cpp::Category *cs_log_instance;


int bserver_log_init()
{
	try
    {
        log4cpp::PropertyConfigurator::configure(g_bserver_config.log4cpp);		
		root_log_instance = &log4cpp::Category::getRoot();		
		cs_log_instance = &log4cpp::Category::getInstance(std::string("custom_service"));
    }
    catch (log4cpp::ConfigureFailure& f)
    {
		goto ERROR_RET;
    }

	return E_BS_NOERROR;
ERROR_RET:
   	ERROR_LOG("log4cpp Configure Problem.");
	return E_BS_ERROR;
}

