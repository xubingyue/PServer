<?php
    final class DB_TABLE_USERS
    {
        const U_TYPE_LOCAL = 0;
	const U_TYPE_QQ = 1;
        const U_TYPE_SINA = 2;
                
                
        const U_AUTH_ADMIN = 0;
        const U_AUTH_USER = 1;
	
        static public function create_user($type, $name, $password, $email)
        {
                $data = array();
                $data['type'] = $type;
                $data['name'] = $name;
                $data['password'] = $password;
                $data['email'] = $email;
                $data['auth'] = self::U_AUTH_USER;
                $data['register_time'] = new MongoDate(time());
                

                return $data;
        }
    }
?>
