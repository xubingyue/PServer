namespace csharp BGame.BServer.Protocol
namespace cpp BGame.BServer.Protocol

struct LoginReq
{
1:	string name;
2:	string password;
}

struct LoginRsp
{
1:	bool result;
2:	string session_id;
}
