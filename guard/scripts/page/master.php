<?php
require_once (dirname(__FILE__)) . '/manage.php';
require_once (dirname(__FILE__)) . '/service.php';
require_once (dirname(__FILE__)) . '/setup.php';
require_once (dirname(__FILE__)) . '/install.php';
require_once (dirname(__FILE__)) . '/coverage.php';
require_once (dirname(__FILE__)) . '/help.php';

function page_master($title, $hi, $content)
{
	$info = array();
	$num = 0;

	$info['menu'][$num]['content'] = "管理";
	$info['menu'][$num]['href'] = "/manage";
	$info['menu'][$num]['highlight'] = false;
	++$num;

	$info['menu'][$num]['content'] = "服务";
	$info['menu'][$num]['href'] = "/service";
	$info['menu'][$num]['highlight'] = false;
	++$num;

	$info['menu'][$num]['content'] = "设置";
	$info['menu'][$num]['href'] = "/setup";
	$info['menu'][$num]['highlight'] = false;
	++$num;

	$info['menu'][$num]['content'] = "安装";
	$info['menu'][$num]['href'] = "/install";
	$info['menu'][$num]['highlight'] = false;
	++$num;

	$info['menu'][$num]['content'] = "帮助";
	$info['menu'][$num]['href'] = "/help";
	$info['menu'][$num]['highlight'] = false;
	++$num;

	if(ADMIN)
	{
		$info['menu'][$num]['content'] = "代码覆盖率";
		$info['menu'][$num]['href'] = "/coverage";
		$info['menu'][$num]['highlight'] = false;
		++$num;
	}

	$info['menu'][$hi]['highlight'] = true;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Guard-<?php echo $title ?></title>
		<link rel="stylesheet" href="/css/frame.css" type="text/css" media="all" />

        <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/js/jquery.json-2.4.min.js"></script>
        <script type="text/javascript" src="/js/md5-min.js"></script>
        <script type="text/javascript" src="/js/ajaxfileupload.js"></script>


		<link rel="stylesheet" href="/css/install.css" type="text/css" media="all" />
        <script type="text/javascript" src="/js/install.js"></script>

		<link rel="stylesheet" href="/css/coverage.css" type="text/css" media="all" />
        <script type="text/javascript" src="/js/coverage.js"></script>
</head>
<body>
    <div id="container">
    		    	

		<div id="head">
			<div id = "head_top">
				<a href = "/"><img src = "/images/logo.png" style = "border:none;margin-top:10px" /></a>
			</div>
			<div class = "head_line"></div>	
			<div class = "head_bottom" >	
				<ul id = "head_nav">
<?php
				foreach($info['menu'] as $menu)
				{
?>
        	    	<li <?php if ($menu['highlight']) { ?> class = "highlight" <?php } ?> onclick = "window.location = '<?php echo $menu['href']; ?>'" >
				    	<span><?php echo $menu['content']; ?></span>
				    </li>
<?php
				}
?>
				</ul>
			</div>
		</div>



		<div id="main">
			<div id="content">
				<?php
					switch ($content)
					{
						case 'manage':
							page_manage(null);
							break;
						case 'service':
							page_service(null);
							break;
						case 'install':
							page_install(null);
							break;
						case 'setup':
							page_setup(null);
							break;
						case 'coverage':
							page_coverage(null);
							break;
						case 'help':
							page_help(null);
							break;
					}                                
				?>
			</div>			 
		</div>



		<div id = "footer">
			© 2014 <a href = "https://github.com/randyliu">小星星</a> 版权所有
		</div>
	</div>
</body>
</html>
<?php
}
?>

