#include <stdio.h>

extern "C"
{
#include "tapp.h"
#include "scened_config_reader.h"
#include "scened_config_types.h"
}

scened_config_t g_config;

int main(int argc, char *argv[])
{
	tapp_load_config(&g_config, argc, argv, (tapp_xml_reader_t)tlibc_read_scened_config);

    return 0;
}

