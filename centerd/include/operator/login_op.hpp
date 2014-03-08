#ifndef _H__LOGIN_OP__
#define _H__LOGIN_OP__

#include "auth_types.h"

#include "async.h"

//每一个远程调用方法对应一个操作对象
class LoginOP
{
protected:
	//返回句柄
	tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob;
	
	//参数列表
	BGame::BServer::Protocol::LoginReq req;

	//保护的构造函数表明只能由自己分配内存
	LoginOP(tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob, const BGame::BServer::Protocol::LoginReq &req)
		: cob(cob), req(req)
	{
	}


	
public:
	virtual ~LoginOP()
	{
	}

	static LoginOP* NewOp(tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob, const BGame::BServer::Protocol::LoginReq &req);

	//处理请求
	void execute();


	void on_get_password_cb(const redisReply *reply);
};

#endif//_H__LOGIN_OP__

