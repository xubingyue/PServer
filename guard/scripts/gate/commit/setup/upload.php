<?php
    require_once CORE_DIR . '/process_manager.php';
	$ret = array();

	if(move_uploaded_file($_FILES['setup_file']['tmp_name'], PUBLISH_DIR . '/' . $_FILES['setup_file']['name']))
	{
		$ret['result'] = true;
	}
	else
	{
		$ret['result'] = false;
		$ret['error'] = '无法移动文件';
	}
	echo json_encode($ret);
?>

