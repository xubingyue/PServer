#include <stdio.h>

#include "tapp.h"
#include "mysql_proxyd_config_reader.h"
#include "mysql_proxyd_config_types.h"

mysql_proxyd_config_t g_config;

int main(int argc, char *argv[])
{
	tapp_load_config(&g_config, argc, argv, (tapp_xml_reader_t)tlibc_read_mysql_proxyd_config);

    return 0;
}

