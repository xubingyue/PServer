#include "script/c_functions.h"
#include "script/script.h"
#include <stdlib.h>

#include "lua.h"
#include "lualib.h"
#include "lauxlib.h"




void cf_init(lua_State *ls)
{
	lua_register(ls, "error", cf_error);
}

int cf_error(lua_State *ls)
{
	const char* error = luaL_checkstring(ls,1);
	fprintf(stderr, error);
	return 0;
}
