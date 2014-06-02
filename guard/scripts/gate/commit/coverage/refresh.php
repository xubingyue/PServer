<?php
	$ret = array();
	$ret['result'] = true;
	if(!ADMIN)
	{
		$ret['result'] = false;
		$ret['error'] = '没有查看代码的权限';
		goto done;
	}

	$cmd = 'cd ' . SOURCE_DIR . '/' . $_REQUEST['project'] . '; make lcov;';
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "命令执行错误";
		$ret['return'] = $return;
		$ret['cmd'] = $cmd;
		goto done;
	}		
	
done:
	echo json_encode($ret);
?>

