#ifndef _H__CONFIG__
#define _H__CONFIG__

#include <string>

struct BSERVER_CONFIG
{
	int port;							//�����˿�
	std::string log4cpp;				//log4cpp�������ļ�
	std::string redis_host;				//redis�������ĵ�ַ
	int redis_port;						//redis�������Ķ˿�
	bool daemonize;						//�Ƿ��̨����
	std::string chdir;					//��̨����ʱ��Ľ��̹���Ŀ¼
	std::string pidfile;				//��̨����ʱ���pid�ļ�
};

extern BSERVER_CONFIG g_bserver_config;

int bserver_load_config(std::string file);

void bserver_reload_config(std::string file);

#endif//_H__CONFIG__

