#include "script/script_functions.h"

#include "lua.h"
#include "lualib.h"
#include "lauxlib.h"

#include "script/script.h"


void sf_on_test(const char* str)
{
	lua_getglobal(g_ls, "on_test");
	lua_pushstring(g_ls, str);
	lua_call(g_ls, 1, 0);
}

