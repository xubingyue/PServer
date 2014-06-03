<?php
    require_once CORE_DIR . '/user/local_user.php';
    
    final class USER_MANAGER
    {
        static public function is_signin()
        {
                return isset($_SESSION['user']);			
        }
        
        static public function get_user()
        {
            if(self::is_signin())
            {
                return $_SESSION['user'];
            }
            else
            {
                return null;
            }
        }
        
        static public function local_login($name, $password)
        {
            if (self::is_signin())
            {
                goto ERROR_RET;
            }
            
            $user = new LOCAL_USER();
            if(!$user->login($name, $password))
            {
                goto ERROR_RET;
            }
            
            $_SESSION['user'] = $user;
            
            return true;
        ERROR_RET:
            return false;
        }
        
        static public function local_sign_up($name, $password, $email)
        {
            if(self::is_signin())
            {
                goto ERROR_RET;
            }
            $user = new LOCAL_USER();
            if(!$user->sign_up($name, $password, $email))
            {
                goto ERROR_RET;
            }
            $_SESSION['user'] = $user;
            
            
            return true;
        ERROR_RET:
            return false;            
        }
    }
?>
