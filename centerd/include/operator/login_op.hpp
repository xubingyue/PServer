#ifndef _H__LOGIN_OP__
#define _H__LOGIN_OP__

#include "auth_types.h"

#include "async.h"

//ÿһ��Զ�̵��÷�����Ӧһ����������
class LoginOP
{
protected:
	//���ؾ��
	tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob;
	
	//�����б�
	BGame::BServer::Protocol::LoginReq req;

	//�����Ĺ��캯������ֻ�����Լ������ڴ�
	LoginOP(tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob, const BGame::BServer::Protocol::LoginReq &req)
		: cob(cob), req(req)
	{
	}


	
public:
	virtual ~LoginOP()
	{
	}

	static LoginOP* NewOp(tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob, const BGame::BServer::Protocol::LoginReq &req);

	//��������
	void execute();


	void on_get_password_cb(const redisReply *reply);
};

#endif//_H__LOGIN_OP__

