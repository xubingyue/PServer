<?php
	$ret = array();
	$ret['result'] = true;
	$project =  SOURCE_DIR . '/' . $_REQUEST['project'];

	$cmd = "find " . $project . " -name \"*.gcda\" | xargs rm -rf";
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "删除gcda文件出错";
		$ret['return'] = $return;
		$ret['cmd'] = $cmd;
		goto done;
	}		

	$cmd = "rm -rf " . HTDOCS_DIR . "/coverage/" . $_REQUEST['project'];
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "删除html文件出错";
		$ret['return'] = $return;
		$ret['cmd'] = $cmd;
		goto done;
	}		
	
done:
	echo json_encode($ret);
?>

