<?php
    require_once SCRIPTS_DIR . '/config.php';
    require_once CORE_DIR . '/user/user.php';
    require_once CORE_DIR . '/db/table_user.php';
    require_once CORE_DIR . '/db/db_conn.php';
    
    class LOCAL_USER extends USER
    {
        protected $id;
        protected $auth;
        protected $name;
        protected $email;
        
        public function get_id()
        {
            return self::id;
        }
        
        function get_auth()
        {
            return self::auth;
        }
        
        function get_name()
        {
            return self::name;
        }
        
        function get_email()
        {
            return self::email;
        }
        
        public function login($username, $password)
        {
            $db_conn = new DB_CONN();
            $db = $db_conn->db;
            $u = $db->users->findOne(array("type" => DB_TABLE_USERS::U_TYPE_LOCAL, "name" => $username));
            if($u == null)
            {
                    goto ERROR_RET;		
            }
            if($u['password'] != $password)
            {
                    goto ERROR_RET;
            }
            
            return true;
        ERROR_RET:
            return false;
        }
        
        static public function check_password_valid($password)
        {
            $ret = array();
            if(!isset($password))
            {
                $ret['error'] = "密码不能为空";
                goto ERROR_RET;
            }
            if(!isset($password) || (strlen($password) < 4))
            {
                $ret['error'] = "密码长度不足4位";
                goto ERROR_RET;
            }

            $ret['result'] = true;
            return $ret;
        ERROR_RET:
            $ret['result'] = false;
            return $ret;
        }
        
        
        static public function check_email_valid($email)
        {
            $ret = array();

            if(!isset($email))
            {
                    $ret['error'] = "邮箱地址错误";
                    goto ERROR_RET;					
            }

            //用这玩意ajax就木有了~~
            //$e_ret = preg_match("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]$",$email);                    
            $e_ret = strstr($email, "@");
            if ($e_ret == false)
            {
                    $ret['error'] = "邮箱地址错误";
                    goto ERROR_RET;
            }

            $ret['result'] = true;
            return $ret;
        ERROR_RET:
            $ret['result'] = false;
            return $ret;
        }
        
        function sign_up($username, $password, $email)
        {
            $db_conn = new DB_CONN();
            $db = $db_conn->db;
            $ret = array();

            if(!isset($username) || (strlen($username) < 4))
            {
                    $ret['error'] = "用户名长度不足4位";
                    goto ERROR_RET;			
            }

            $cpr = self::check_password_valid($password);
            if(!$cpr['result'])
            {
                $ret['error'] = $cpr['error'];
                goto ERROR_RET;
            }

            $cer = self::check_email_valid($email);
            if(!$cer['result'])
            {
                $ret['error'] = $cer['error'];
                goto ERROR_RET;
            }

            $user = DB_TABLE_USERS::create_user(DB_TABLE_USERS::U_TYPE_LOCAL, $username, $password, $email);

            try
            {
                    //由于具有唯一索引， 所以这里在可能会插入失败
                    $db->users->insert($user, true);	
            }
            catch(MongoCursorException $e)
            {
                    if($e->getCode() == 11000)
                    {
                        $ret['error'] = "用户已存在";
                        goto ERROR_RET;
                    }
                    else
                    {
                        $ret['error'] = "数据库错误";
                        goto ERROR_RET;
                    }
            }			

            $ret['result'] = true;
            return $ret;
    ERROR_RET:
            $ret['result'] = false;
            return $ret;	
        }
    }
?>
