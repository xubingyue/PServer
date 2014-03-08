namespace csharp BGame.BServer
namespace cpp BGame.BServer

include "auth.thrift"

service centerp_services
{
	auth.LoginRsp Login(1: auth.LoginReq account);
}

