#include "operator/login_op.hpp"
#include "bserver.hpp"
#include "bserver_log.hpp"
#include "bserver_db.hpp"

#include "async.h"


using namespace BGame::BServer;
using namespace BGame::BServer::Protocol;


void LoginOP::on_get_password_cb(const redisReply *reply)
{
	if((reply != NULL) &&(reply->type == REDIS_REPLY_STRING) && (std::string(reply->str) == req.password))
	{
		LoginRsp res;
		res.result = true;
		res.session_id = req.name;
		cob(res);
		INFO_CSLOG("account : %s login success!", req.name.c_str());
	}
	else
	{
		LoginRsp res;
		res.result = false;
		cob(res);
		INFO_CSLOG("account : %s login failed!", req.name.c_str());
	}

	
//处理结束后不要忘记删除自己
	delete this;
}

LoginOP* LoginOP::NewOp(tcxx::function<void(LoginRsp const& _return)> cob, const LoginReq &req)
{
	return new LoginOP(cob, req);
}

void LoginOP::execute()
{
	bserver_db_cmd<LoginOP, &LoginOP::on_get_password_cb>(this, BSD_GET_ACCOUNT_PASSWORD, req.name.c_str());
}

