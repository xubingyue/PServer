#ifndef _H_C_FUNCTIONS_H
#define _H_C_FUNCTIONS_H
/*
 * C提供给Script调用的函数
*/

#include "lua.h"

void cf_init(lua_State *ls);

int cf_error(lua_State *ls);

#endif//_H_C_FUNCTIONS_H
