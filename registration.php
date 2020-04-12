<?php
    // require_once('includes/db-helper.inc.php');
    // require_once('includes/session-helper.inc.php');
    // require_once('includes/config.inc.php');
	
	$incompleteForm = false;
	$passwordMatch = true;
	$userAlreadyExists = false;
	
	if(isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['city']) || isset($_POST['country']) || isset($_POST['email']) || isset($_POST['password']))
	{
		if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['city']) && isset($_POST['country']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword']) &&
			$_POST['confirmpassword'] == $_POST['password'])
		{
			$existedUser = getUser($_POST['email'], $connection);

			if($existedUser == null)
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
			else
			{
				$userAlreadyExists = true;
			}
		}
		else if(isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != $_POST['password'])
		{
			$passwordMatch = false;
		}
	} else if (isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != $_POST['password']) {
		$passwordMatch = false;
	}
	else
	{
		$incompleteForm = true;
	}	
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset = "UTF-8">
    <meta name = "description" content = "Registration Page">
	<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
	
	<title>Registration</title>
    <link rel = "stylesheet" type = "text/css" href = "css/registration.css"> 
	<script src = "js/registration.js"></script>
</head>

<body>
    <div class = "box">
        <h2>Register</h2>
		<form method = "post" action = "registration.php">
            <ul>
				<li><label for = "firstname">First Name</label>
				<input type = "text" name = "firstname" placeholder = "Required"<?php if (isset($_POST['firstname'])){ echo 'value = "' . $_POST['firstname'] . '"';}?> id = "first" required>
				<p id = "firsterror">!</p></li> 
				<li><label for = "lastname">Last Name</label>
				<input type = "text" name = "lastname" placeholder = "Required" <?php if (isset($_POST['lastname'])){ echo 'value = "' . $_POST['lastname'] . '"';}?> id = "lname" required>
				<p id = "lasterror">!</p></li> 
				<li><label for = "city">City</label>
				<input type = "text" name = "city" placeholder = "Required" <?php if (isset($_POST['city'])){ echo 'value = "' . $_POST['city'] . '"';}?> id = "city" required>
				<p id = "cityerror">!</p></li> 
				<li><label for = "country">Country</label>
				<input type = "text" name = "country" placeholder = "Required" <?php if (isset($_POST['country'])){ echo 'value = "' . $_POST['country'] . '"';}?> id = "country" required>
				<p id = "countryerror">!</p></li>
				<li><label for = "email" id = "eid">Email</label>
				<input type = "email" name = "email" placeholder = "Required" <?php if (isset($_POST['email'])){ echo 'value = "' . $_POST['email'] . '"';}?>id = "email" required>
				<p id = "emailerror">!</p></li>
				<li><label for = "password">Password</label>
				<input type = "password" name = "password" placeholder = "Required" <?php if (isset($_POST['password'])){ echo 'value = "' . $_POST['password'] . '"';}?>id = "password" required>
				<p id = "passerror">!</p></li>
				<li><label for = "confirmpassword">Confirm Password</label>
				<input type = "password" name = "confirmpassword" placeholder = "Required" <?php if (isset($_POST['confirmpassword'])){ echo 'value = "' . $_POST['confirmpassword'] . '"';}?>id = "confirm" required>
				<p id = "confirmerror">!</p></li>
				<input type = "submit" name = "register" value = "register" id = "submit">  
			</ul>
        </form>
	</div>
</body>
<footer></footer>
</html>