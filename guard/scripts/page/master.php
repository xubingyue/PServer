<?php
require_once (dirname(__FILE__)) . '/process.php';
require_once (dirname(__FILE__)) . '/help.php';

function page_master($title, $hi, $content)
{
	$info = array();

	$info['menu'][0]['content'] = "进程管理";
	$info['menu'][0]['href'] = "/process";
	$info['menu'][0]['highlight'] = false;

	$info['menu'][1]['content'] = "帮助";
	$info['menu'][1]['href'] = "/help";
	$info['menu'][1]['highlight'] = false;

	$info['menu'][$hi]['highlight'] = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="/css/nav.css" type="text/css" media="all" />
		<link rel="stylesheet" href="/css/template_page.css" type="text/css" media="all" />
        <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/js/jquery.json-2.4.min.js"></script>
        <script type="text/javascript" src="/js/md5-min.js"></script>
</head>
<body>
    <div id="container">
    		    	
		<div id="head">
			<div id = "head_container">
				<div style = "width:620px">
					<div id = "head_left" >
						<a href = "/"><img src = "/images/logo.png" sytle = "border:none;margin-top:10px" /></a>
					</div>
					<div id = "head_right">
					</div>
				</div>
			</div>
		</div>
		<div class = "head_line"></div>	

		<div class = "head_nav" >	
			<ul id = "nav">
<?php
			foreach($info['menu'] as $menu)
			{
?>
        	    <li <?php if ($menu['highlight']) { ?> class = "highlight" <?php } ?> onclick = "window.location = '<?php echo $menu['href']; ?>'" />
				    <span><?php echo $menu['content']; ?></span>
			    </li>
<?php
			}
?>
			</ul>
		</div>

		<div id="main">
			<div id="content">
                            <?php
                                switch ($content)
                                {
                                    case 'process':
                                        page_process(null);
                                        break;
                                    case 'help':
                                        page_help(null);
                                        break;
                                }                                
                            ?>
			</div>			 
		</div>
		<div id = "footer">
			
		</div>
	</div>
</body>
</html>
<?php
}
?>

