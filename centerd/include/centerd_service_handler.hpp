#ifndef _H__BSERVER_SERVICE_HANDLER__
#define _H__BSERVER_SERVICE_HANDLER__

#include "centerp_services.h"

class centerp_services_handler : public BGame::BServer::centerp_servicesIf
{
public:
	centerp_services_handler()
	{
	}

	virtual ~centerp_services_handler()
	{
	}


	void login( ::BGame::BServer::Protocol::login_rsp_t& _return, const  ::BGame::BServer::Protocol::login_req_t& account);
};

#endif //_H__BSERVER_SERVICE_HANDLER__

