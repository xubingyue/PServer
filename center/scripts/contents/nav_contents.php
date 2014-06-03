<?php

    function get_nav_contents()
    {
        $ret = array();
        
        $ret['menu_enable'] = false;
        $ret['title'] = "xxx";
        $ret['user']['logged'] = false;
        $ret['title_menu'][0]['text'] = '特性';
        $ret['title_menu'][0]['url'] = '/features';
        $ret['title_menu'][1]['text'] = '注册';
        $ret['title_menu'][1]['url'] = '/sign_up';
        $ret['title_menu'][2]['text'] = '登录';
        $ret['title_menu'][2]['url'] = '/login';
        
        return $ret;
    }
?>
