#ifndef _H_SCRIPT_H
#define _H_SCRIPT_H

#ifdef  __cplusplus
extern "C" {
#endif

#include "lua.h"

extern lua_State* g_ls;

int script_init(const char* script);

void script_fini();

#ifdef  __cplusplus
}
#endif

#endif//_H_SCRIPT_H
