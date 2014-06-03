<?php
    require_once CORE_DIR . '/user/user_manager.php';
    
    echo USER_MANAGER::local_login($_POST['username'], $_POST['password']);
?>
