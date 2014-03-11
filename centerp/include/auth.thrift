namespace csharp BGame.BServer.Protocol
namespace cpp BGame.BServer.Protocol

struct login_req_t
{
1:	string name;
2:	string password;
}

struct login_rsp_t
{
1:	bool result;
2:	string session_id;
}
