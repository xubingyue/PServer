<?php
    require_once CORE_DIR . '/process_manager.php';
    
    echo process_manager::start($_REQUEST['proc']);
?>

