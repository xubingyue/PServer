<?php
        require_once PAGE_DIR . '/master.php';
        require_once PAGE_DIR . '/sign_up.php';        
        require_once CONTENTS_DIR . '/nav_contents.php';
        require_once CONTENTS_DIR . '/footer_contents.php';
	


        $data['title'] = "xxx";
        $data['nav'] = get_nav_contents();
        $data['content'] = 'sign_up';
        $data["footer"] = get_footer_contents();

	page_master($data);
?>
