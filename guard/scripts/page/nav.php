<?php

function page_nav($data)
	{
?>	
	<div id="head">
		<div id = "head_container">
			<div style = "width:620px">
				<div id = "head_left" >
                                    <font size="30" face="Times"><a href ='/logo' ><?php echo $data['title']; ?></a></font>
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
if($data['menu_enable'])
{
    foreach($data['menu'] as $menu)
    {
?>
            <li>
			    <span><?php echo $menu;?></span>					    	
		    </li>
<?php
    }
}
?>
		</ul>
	</div>
<?php
	}
?>
