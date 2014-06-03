<?php
	$ret = array();
	$ret['result'] = true;
	$project =  SOURCE_DIR . '/' . $_REQUEST['project'];

	$file = "/tmp/coverage" . rand(0,1000). ".info";
	$cmd = "lcov --capture --directory " . $project . " --output-file " . $file;
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "lcov执行失败";
		$ret['return'] = $return;
		$ret['cmd'] = $cmd;
		goto done;
	}		

	$cmd = "genhtml " . $file . " --output-directory " . HTDOCS_DIR . "/coverage/" . $_REQUEST['project'] . " --show-details --legend";
	exec($cmd, $output, $return);
	if($return != 0)
	{
		$ret['result'] = false;
		$ret['error'] = "genhtml执行失败";
		$ret['return'] = $return;
		$ret['cmd'] = $cmd;
		goto done;
	}		
	
	exec("rm -rf " . $file, $output, $return);

done:
	echo json_encode($ret);
?>

