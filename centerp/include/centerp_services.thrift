namespace csharp BGame.BServer
namespace cpp BGame.BServer

include "auth.thrift"

service centerp_services
{
	auth.login_rsp_t login(1: auth.login_req_t account);
}

