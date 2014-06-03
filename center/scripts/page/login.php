<?php
    function page_login($data)
    {
?>
<form action="/commit/login/" method="post">
	<input type="text" placeholder="Pick a username" autofocus="autofocus" name ='username'>
        <br/>
        <input type="text" placeholder="Your email" name ='password'>
        <br/>
        <button type="submit">login</button>
</form>
<?php 
    }
?>
 
