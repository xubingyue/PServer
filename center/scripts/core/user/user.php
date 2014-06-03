<?php
	abstract class USER
	{
		//获得这个用户的id
		abstract function get_id();		
		//获得这个用户的权限
		abstract function get_auth();
		//用户名
		abstract function get_name();
                
                abstract function get_email();
	}	
?>
