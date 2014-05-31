<?php
	//脚本的根目录
	define('SCRIPTS_DIR', (dirname(__FILE__)));
	define('PAGE_DIR', SCRIPTS_DIR . '/page' );
    define('CORE_DIR', SCRIPTS_DIR . '/core' );
    define('GATE_DIR', SCRIPTS_DIR . '/gate' );
        
	//之前要包含session中所需要用到的类
	require_once SCRIPTS_DIR . '/config.php';
	session_start();

	try
	{
		main();
	}
	catch(Exception $e)
	{
		echo $e;
		return 0;
	}
	
	function main()
	{
		$uri = $_SERVER['SCRIPT_NAME'];
		if(substr($uri, 0, 7)=="/commit")
		{
			$uri = substr($uri, 7);
			$index_file = GATE_DIR . '/commit/' . $uri;
		}
		else
		{
			$len = strlen($uri);
			if(($len < 4) || (substr($uri, $len - 4, 4) != '.php'))
			{
				$uri .= '/index.php';		
			}
			$index_file = GATE_DIR . '/browse' . $uri;
		}

	
		if(!file_exists($index_file))
		{
			return 0;
		}
	
		require_once $index_file;	
	}
?>

