<?php
    // require_once('includes/db-helper.inc.php');
    // require_once('includes/session-helper.inc.php');
    // require_once('includes/config.inc.php');
	
	$attemptLoginFailed = false;
	
	if(isset($_POST['password']) && isset($_POST['email']))
	{
		if(LoginUser($_POST['email'], $_POST['password'], $connection))
		{
			header("location:index.php");
		}
		else
		{
			$attemptLoginFailed = true;
		}
	}
?>
<!DOCTYPE html>
<html lang = en>
<head>
    <meta charset = "UTF-8">
    <meta name = "description" content = "Login page for assignment">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <link rel = "stylesheet" type = "text/css" href = "css/login.css">
</head>
<body>
    <div class = "box">
        <form method = "post" action = "login.php">
            <h2>Sign In</h2>
            <?php if ($attemptLoginFailed == true){ echo '<p>Either the usernmane or password is incorrect</p>';}?>
            <input type = "text" name = "email" placeholder = "Enter Email" required>
            <input type = "password" name = "password" placeholder = "Enter Password" required>
            <input type = "submit" name = "Login" value = "Sign in">
        </form>
        <a href = "registration.php">Don't have an account? Register Here!</a>
    </div>
</body>
<footer></footer>
</html>