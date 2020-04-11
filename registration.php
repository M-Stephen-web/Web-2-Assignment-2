<?php

require_once('includes/db-helper.inc.php');
require_once('includes/session-helper.inc.php');
require_once('includes/config.inc.php');
require_once('includes/class-helper.inc.php');

$incompleteForm = false;
$passwordMatch = true;

if (isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['city']) || isset($_POST['country']) || isset($_POST['email']) || isset($_POST['password'])) {
	if (
		isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['city']) && isset($_POST['country']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword']) &&
		$_POST['confirmpassword'] == $_POST['password']
	) {
		$userData = array();

		$userData['firstname'] = $_POST['firstname'];
		$userData['lastname'] = $_POST['lastname'];
		$userData['city'] = $_POST['city'];
		$userData['country'] = $_POST['country'];
		$userData['email'] = $_POST['email'];
		$userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);

		$user = new User($userData);

		if (RegisterUser($user, $connection)) {
			header("location:index.php");
		}
	} else if (isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != $_POST['password']) {
		$passwordMatch = false;
	}
} else {
	$incompleteForm = true;
}

?>
<!DOCTYPE html>
<html lang=en>

<head>
	<meta charset="UTF-8">
	<meta name="description" content="Registration page for assignment">
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
	<div class="box">
		<form method="post" action="registration.php" onsubmit="return validate()">
			<h2>Register</h2>
			<input type="text" name="firstname" placeholder="John (Required)" required>
			<input type="text" name="lastname" placeholder="Doe (Required)" required>
			<input type="text" name="city" placeholder="Los Angeles (Required)" required>
			<input type="text" name="country" placeholder="United States of America (Required)" required>
			<input type="email" name="email" id="email" placeholder="jdoe@mail.com (Required)" required>
			<input type="password" name="password" id="password" placeholder="Password (Required)" minlength="8" required>
			<input type="password" name="confirmpassword" id="confPass" placeholder="Confirm Password (Required)" minlength="8" required>
			<input type="submit" name="Register" value="Register">
		</form>
	</div>
</body>

</html>