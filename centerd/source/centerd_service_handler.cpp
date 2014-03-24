#include "centerd_service_handler.hpp"
#include "centerp_services.h"


using namespace ::BGame::BServer;
using namespace ::BGame::BServer::Protocol;


void centerp_services_handler::login( ::BGame::BServer::Protocol::login_rsp_t& _return, const  ::BGame::BServer::Protocol::login_req_t& account)
{
	_return.result = true;
	_return.session_id = std::string("123456789");
	printf("login user:[%s], password[%s]\n", account.name.c_str(), account.password.c_str());
	return;
}

