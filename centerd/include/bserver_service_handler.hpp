#ifndef _H__BSERVER_SERVICE_HANDLER__
#define _H__BSERVER_SERVICE_HANDLER__

#include "centerp_services.h"

class centerp_servicesHandler : public BGame::BServer::centerp_servicesCobSvIf
{
public:
	centerp_servicesHandler();
	virtual ~centerp_servicesHandler()
	{
	}

	void Login(tcxx::function<void(BGame::BServer::Protocol::LoginRsp const& _return)> cob, const BGame::BServer::Protocol::LoginReq& account);
};

#endif //_H__BSERVER_SERVICE_HANDLER__

