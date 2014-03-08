#include "bserver_config.hpp"
#include "bserver_errno.hpp"

#include "boost/property_tree/ptree.hpp"
#include "boost/property_tree/xml_parser.hpp"
#include "boost/foreach.hpp"
#include "exception"


BSERVER_CONFIG g_bserver_config;

static BSERVER_CONFIG g_bserver_config_;



static int load_config(std::string file)
{
	using boost::property_tree::ptree;
	ptree pt;
	ptree root;
	try
	{
		read_xml(file, pt);
		root = pt.get_child("BSERVER_CONFIG");
		
		g_bserver_config_.port = root.get<int>("port");
		g_bserver_config_.log4cpp = root.get<std::string>("log4cpp");
		g_bserver_config_.redis_host = root.get<std::string>("redis_host");
		g_bserver_config_.redis_port = root.get<int>("redis_port");

		g_bserver_config_.daemonize = root.get<bool>("daemonize");
		g_bserver_config_.chdir = root.get<std::string>("chdir");
		g_bserver_config_.pidfile = root.get<std::string>("pidfile");
	}
	catch (std::exception& e)
	{
		goto ERROR_RET;
	}

	return E_BS_NOERROR;
ERROR_RET:
	return E_BS_ERROR;	
}

int bserver_load_config(std::string file)
{
	if(load_config(file) != 0)
	{
		goto ERROR_RET;
	}
	g_bserver_config = g_bserver_config_;

	return E_BS_NOERROR;
ERROR_RET:
	return E_BS_ERROR;
	
}

void bserver_reload_config(std::string file)
{
	if(load_config(file) != 0)
	{
		goto ERROR_RET;
	}
//有些值不可以被reload
	if(g_bserver_config_.port != g_bserver_config.port)
	{
		goto ERROR_RET;
	}
	
	if(g_bserver_config_.log4cpp!= g_bserver_config.log4cpp)
	{
		goto ERROR_RET;
	}

	g_bserver_config = g_bserver_config_;
	return;
ERROR_RET:
	//need log?
	return;
}

