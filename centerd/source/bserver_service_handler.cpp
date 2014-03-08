#include "bserver_service_handler.hpp"
#include "centerp_services.h"

#include "operator/login_op.hpp"


using namespace ::BGame::BServer;
using namespace ::BGame::BServer::Protocol;


centerp_servicesHandler::centerp_servicesHandler()
{
}

void centerp_servicesHandler::Login(tcxx::function<void(LoginRsp const& _return)> cob, const LoginReq& account)
{
	LoginOP *login_op = LoginOP::NewOp(cob, account);
	login_op->execute();
	return;
}

