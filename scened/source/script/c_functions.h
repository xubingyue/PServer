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

/**
* @brief 初始化函数
* @param ls 脚本虚拟机句柄
* @return 无返回值
*/
void cf_init(lua_State *ls);

/**
* @brief 输出错误字符串
* @param ls 脚本虚拟机句柄
* @return 返回参数个数
*/
int cf_error(lua_State *ls);

#ifdef  __cplusplus
}
#endif

#endif//_H_C_FUNCTIONS_H
