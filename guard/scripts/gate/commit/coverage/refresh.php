<?php
	$ret = array();
	$ret['result'] = true;

	$cmd = 'cd ' . SOURCE_DIR . '/' . $_REQUEST['project'] . '; make lcov;';
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "命令执行错误(" . $return . "): " . $cmd;
		goto done;
	}		
	
done:
	echo json_encode($ret);
?>

