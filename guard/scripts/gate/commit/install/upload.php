<?php
	$ret = array();
	$ret['result'] = true;

	if(!move_uploaded_file($_FILES['install_file']['tmp_name'], PUBLISH_DIR . '/' . $_FILES['install_file']['name']))
	{
		$ret['result'] = false;
		$ret['error'] = '无法移动文件';
		goto done;
	}
	
	exec("cd " . PUBLISH_DIR. "; tar -xf " . $_FILES['install_file']['name'], $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "无法解压缩文件";
		goto done;
	}		
	
done:
	echo json_encode($ret);
?>

