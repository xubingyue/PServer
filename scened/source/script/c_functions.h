//////////////////////////////////////////////
//	COPYRIGHT NOTICE
//	Copyright (c) 2014, 小星星	(版权声明)
//	All rights reserved.
//
//  C提供给Script调用的函数
//
//	@author liuxing
//
//////////////////////////////////////////////
#ifndef _H_C_FUNCTIONS_H
#define _H_C_FUNCTIONS_H

#ifdef  __cplusplus
extern "C" {
#endif

#include "lua.h"

void cf_init(lua_State *ls);

int cf_error(lua_State *ls);

#ifdef  __cplusplus
}
#endif

#endif//_H_C_FUNCTIONS_H
