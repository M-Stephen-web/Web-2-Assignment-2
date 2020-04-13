<?php

// require_once('includes/db-helper.inc.php');
// require_once('includes/session-helper.inc.php');
// require_once('includes/config.inc.php');

//Variables for specific errors
// $incompleteForm = false; 
// $passwordMatch = true;
// $userAlreadyExists = false;

// //Checks if any of the information is given
// if (isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['city']) || isset($_POST['country']) || isset($_POST['email']) || isset($_POST['password'])) 
// {
// 	//Checks if all the information is given and the passwords are the same
// 	if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['city']) && isset($_POST['country']) && isset($_POST['email']) && isset($_POST['password']) && 
// 		isset($_POST['confirmpassword']) && $_POST['confirmpassword'] == $_POST['password']) 
// 	{
// 		$existedUser = getUser($_POST['email'], $connection); //Attempts to get a user with the provided email

// 		if ($existedUser == null) //If the attempt to get the user failed, then create the new user
// 		{
// 			//Create the new user object
// 			$userData = array();

// 			$userData['firstname'] = $_POST['firstname'];
// 			$userData['lastname'] = $_POST['lastname'];
// 			$userData['city'] = $_POST['city'];
// 			$userData['country'] = $_POST['country'];
// 			$userData['email'] = $_POST['email'];
// 			$userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);

// 			$user = new User($userData);

// 			if (RegisterUser($user, $connection)) { //Attemot to create the user
// 				header("location:login.php"); //if successul, prompt them to login
// 			}
// 		} 
// 		else //Else there already exists a user, turn userAlreadyExists to true
// 		{
// 			$userAlreadyExists = true;
// 		}
// 	}
// 	//If the password and confirm password do exist, but do not match then turn passwordMatch variable to false
// 	else if (isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != $_POST['password']) 
// 	{
// 		$passwordMatch = false;
// 	}
// } 
// else 
// {
// 	$incompleteForm = true;
// }
?>

<!DOCTYPE html>
<html lang=en>

<head>
	<meta charset="UTF-8">
	<meta name="description" content="Registration Page">
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">

	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/registration.css">
	<script type = "text/javascript" src="js/registration.js"></script>
</head>

<body>
	
	<div class="box">
		<h2>Register</h2>
		
		<!--All php within form is for checking if value is set and then keeping that value in the form if it is-->
		<form action="registration.php" method="post">
			<ul>
				<li><p id="firsterror">!</p>
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" placeholder="Required" <?php //if (isset($_POST['firstname'])) {
																				//	echo 'value = "' . $_POST['firstname'] . '"';
																				//} ?> id="first" required>
				</li>
				<li><p id="lasterror">!</p>
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" placeholder="Required" <?php // if (isset($_POST['lastname'])) {
																				//	echo 'value = "' . $_POST['lastname'] . '"';
																				//} ?> id="lname" required>
				</li>
				<li><p id="cityerror">!</p>
					<label for="city">City</label>
					<input type="text" name="city" placeholder="Required" <?php // if (isset($_POST['city'])) {
																			//	echo 'value = "' . $_POST['city'] . '"';
																			//} ?> id="city" required>
				</li>
				<li><p id="countryerror">!</p>
					<label for="country">Country</label>
					<input type="text" name="country" placeholder="Required" <?php //if (isset($_POST['country'])) {
																				//	echo 'value = "' . $_POST['country'] . '"';
																				//} ?> id="country" required>
				</li>
				<li><p id="emailerror">!</p>
					<label for="email" id="eid">Email</label>
					<input type="email" name="email" placeholder="Required" <?php //if (isset($_POST['email'])) {
																			//	echo 'value = "' . $_POST['email'] . '"';
																			//} ?>id="email" required>
				</li>
				<li><p id="passerror">!</p>
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Required" <?php //if (isset($_POST['password'])) {
																						//echo 'value = "' . $_POST['password'] . '"';
																					//} ?>id="password" required>
				</li>
				<li><p id="confirmerror">!</p>
					<label for="confirmpassword">Confirm Password</label>
					<input type="password" name="confirmpassword" placeholder="Required" <?php //if (isset($_POST['confirmpassword'])) {
																								//echo 'value = "' . $_POST['confirmpassword'] . '"';
																							//} ?>id="confirm" required>
					<?php //if ($passwordMatch == false){
						//echo '<p id="confirmerror"></p>';}
					?>
					<input type="submit" name="register" value="register" id="submit">
			</ul>
		</form>
	</div>
</body>
<footer></footer>

</html>