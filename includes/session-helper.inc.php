<?php
	session_start();
	
	function IsLoggedIn(){
		
		if(isset($_SESSION['User']) && $_SESSION['User'] != null)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function LoginUser()
	{
		$email = null;
		$password = null;
			
		if(isset($_POST['email']))
		{
			$email = $_POST['email'];
		}
			
		if(isset($_POST['password']))
		{
			$password = $_POST['password'];
		}
		
		if($email != null && $password != null)
		{
			$User = getUser($email);
			
			if($User->getPassword() == password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]))
			{
				$_SESSION['User'] = $User;
				
				$header("Location: " . $_SERVER["HTTP_REFERER"]);
			}
		}
		else
		{
			
		}
	}
	
	function RegisterUser()
	{
		$firstname = null;
		$lastname = null;
		$city = null;
		$country = null;
		$email = null;
		$password = null;
		
		if(isset($_POST['firstname'])) {$firstname = $_POST['firstname'];}
		if(isset($_POST['lastname'])) {$lastname = $_POST['lastname'];}
		if(isset($_POST['city'])) {$city = $_POST['city'];}
		if(isset($_POST['country'])) {$country = $_POST['country'];}
		if(isset($_POST['email'])) {$email = $_POST['email'];}
		if(isset($_POST['password'])) {$password = $_POST['password'];}

		$digest = null;

		if($password != null)
		{
			$digest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
		}
		
		if($firstname != null && $lastname != null && $city != null && $country != null && $email != null && $digest != null)
		{
			$NewUser = new User();
			
			$NewUser->setFirstname($firstname);
			$NewUser->setLastname($lastname);
			$NewUser->setCity($city);
			$NewUser->setCountry($country);
			$NewUser->setEmail($email);
			$NewUser->setPassword($digest);
			
			insertUser($NewUser, $connection);
		}
	}
	
	function GetUser ()
	{
		if(isset($_SESSION['User']))
		{
			return $_SESSION['User'];
		}
	}
?>