<?php
    function page_sign_up($data)
    {
?>
<form action="/commit/sign_up/" method="post">
	<input type="text" placeholder="Pick a username" autofocus="autofocus" name ='username'>
        <br/>
        <input type="text" placeholder="Your email" name ='email'>
        <br/>
        <input type="text" placeholder="Create a password" name ='password'>
        <br/>
        <button type="submit">Sign up for free</button>
</form>
<?php 
    }
?>
 
