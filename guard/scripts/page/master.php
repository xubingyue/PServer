<?php
require_once (dirname(__FILE__)) . '/nav.php';

function page_master($data = null)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $data['title'] ?></title>
        <link rel="stylesheet" href="/css/nav.css" type="text/css" media="all" />
		<link rel="stylesheet" href="/css/template_page.css" type="text/css" media="all" />
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div id="container">
    		    	
		<?php
                            page_nav($data['nav']);
		?>		
				
		<div id="main">
			<div id="content">
                            <?php
                                switch ($data['content'])
                                {
                                    case 'features':
                                        page_features(null);
                                        break;
                                    case 'login':
                                        page_login(null);
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

