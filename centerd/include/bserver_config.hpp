#ifndef _H__CONFIG__
#define _H__CONFIG__

#include <string>

struct BSERVER_CONFIG
{
	int port;							//监听端口
	std::string log4cpp;				//log4cpp的配置文件
	std::string redis_host;				//redis服务器的地址
	int redis_port;						//redis服务器的端口
	bool daemonize;						//是否后台运行
	std::string chdir;					//后台运行时候的进程工作目录
	std::string pidfile;				//后台运行时候的pid文件
};

extern BSERVER_CONFIG g_bserver_config;

int bserver_load_config(std::string file);

void bserver_reload_config(std::string file);

#endif//_H__CONFIG__

