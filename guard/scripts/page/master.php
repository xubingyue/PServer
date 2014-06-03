<?php
require_once (dirname(__FILE__)) . '/nav.php';
require_once (dirname(__FILE__)) . '/footer.php';
require_once (dirname(__FILE__)) . '/garmin_upload.php';
require_once (dirname(__FILE__)) . '/features.php';
require_once (dirname(__FILE__)) . '/login.php';
require_once (dirname(__FILE__)) . '/activity_list.php';

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

        <script type="text/javascript" src="/js/prototype/prototype.js" ></script>
        <script type="text/javascript" src="/js/garmin/device/GarminDeviceDisplay.js" ></script>
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D63dbbc1093a0443d24958e0fa4d834c"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
	    var $j = jQuery.noConflict();
	</script>
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
                                    case 'garmin_upload':
                                        page_garmin_up(null);
                                        break;
                                    case 'sign_up':
                                        page_sign_up(null);
                                        break;
                                    case 'features':
                                        page_features(null);
                                        break;
                                    case 'login':
                                        page_login(null);
                                        break;
                                    case 'activity_list':
                                        page_activity_list(null);
                                        break;
                                }                                
                            ?>
			</div>			 
		</div>
		<div id = "footer">
				<?php
                                    page_footer($data['footer']);
				?>
		</div>
	</div>
</body>
</html>
<?php
}
?>
