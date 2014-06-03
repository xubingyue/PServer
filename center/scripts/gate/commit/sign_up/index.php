<?php
    require_once CORE_DIR . '/user/user_manager.php';
    
    echo USER_MANAGER::local_sign_up($_POST['username'], $_POST['password'], $_POST['email']);
?>
