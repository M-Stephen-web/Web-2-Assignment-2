<?php

    require_once('includes/db-helper.inc.php');
    require_once('includes/session-helper.inc.php');
    require_once('includes/config.inc.php');
	
	$incompleteForm = false;
	$passwordMatch = true;
	
	if(isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['city']) || isset($_POST['country']) || isset($_POST['email']) || isset($_POST['password']))
	{
		if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['city']) && isset($_POST['country']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword']) &&
			$_POST['confirmpassword'] == $_POST['password'])
		{
			$userData = array();
			
			$userData['firstname'] = $_POST['firstname'];
			$userData['lastname'] = $_POST['lastname'];
			$userData['city'] = $_POST['city'];
			$userData['country'] = $_POST['country'];
			$userData['email'] = $_POST['email'];
			$userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
			
			$user = new User($userData);
			
			if(RegisterUser($user, $connection))
			{
				header("location:index.php");
			}
		}
		else if(isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != $_POST['password'])
		{
			$passwordMatch = false;
		}
	}
	else
	{
		$incompleteForm = true;
	}

?>
<!DOCTYPE html>
<html lang = en>
<head>
    <meta charset = "UTF-8">
    <meta name = "description" content = "Registration page for assignment">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <link rel = "stylesheet" type = "text/css" href = "style/login.css"> 
	<script src = "js/registration.js"></script>
</head>
<body>
    <div class = "box">
        <h2>Register</h2>
		<form method = "post" action = "registration.php">
            <ul>
				<li><label for = "firstname">First Name:</label></li>
				<li><input type = "text" name = "firstname" placeholder = "John (Required)"<?php if (isset($_POST['firstname'])){ echo 'value = "' . $_POST['firstname'] . '"';}?> id = "first" required></li> 
				<li><p id = "firsterror">!</p></li> 
				<li><label for = "lastname">Last Name</label></li>
				<li><input type = "text" name = "lastname" placeholder = "Doe (Required)" <?php if (isset($_POST['lastname'])){ echo 'value = "' . $_POST['lastname'] . '"';}?> id = "lname" required></li>
				<li><p id = "lasterror">!</p></li> 
				<li><label for = "city">City:</label><li>
				<li><input type = "text" name = "city" placeholder = "Los Angeles (Required)" <?php if (isset($_POST['city'])){ echo 'value = "' . $_POST['city'] . '"';}?> id = "city" required></li>
				<li><p id = "cityerror">!</p></li> 
				<li><select name = "country" id = "country">
						<option value = "default">Select Country</option>
						<option value = "Canada" <?php if(isset($_POST['country']) && $_POST['country'] == "Canada"){ echo 'selected';}?>>Canada</option>
						<option value = "USA">United States of America</option>
						<option value = "Mexico">Mexico</option>
				</select></li>
				<li><p id = "countryerror">!</p></li>
				<li><label for = "email" id = "eid">Email:</label></li>
				<li><input type = "email" name = "email" placeholder = "jdoe@mail.com (Required)" <?php if (isset($_POST['email'])){ echo 'value = "' . $_POST['email'] . '"';}?>id = "email" required></li>
				<li><p id = "emailerror">!</p></li>
				<li><label for = "password">Password:</label></li>
				<li><input type = "password" name = "password" placeholder = "Password (Required)" <?php if (isset($_POST['password'])){ echo 'value = "' . $_POST['password'] . '"';}?>id = "password" required></li>
				<li><p id = "passerror">!</p></li>
				<li><label for = "confirmpassword">Confrim Password:</label></li>
				<li><input type = "password" name = "confirmpassword" placeholder = "Confirm Password (Required)" <?php if (isset($_POST['confirmpassword'])){ echo 'value = "' . $_POST['confirmpassword'] . '"';}?>id = "confirm" required></li>
				<li><p id = "confirmerror">!</p></li>
				<input type = "submit" name = "register" value = "register" id = "submit">  
			</ul>
        </form>
    </div>
</body>
</html>