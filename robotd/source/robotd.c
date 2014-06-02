#include <stdio.h>


#include "tapp.h"
#include "robotd_config_reader.h"
#include "robotd_config_types.h"

robotd_config_t g_config;

int main(int argc, char *argv[])
{
	tapp_load_config(&g_config, argc, argv, (tapp_xml_reader_t)tlibc_read_robotd_config);

    return 0;
}

