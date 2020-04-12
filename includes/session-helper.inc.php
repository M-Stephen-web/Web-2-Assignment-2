<?php
	session_start();

	require_once('class-helper.inc.php');
    require_once('config.inc.php');
	
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
	
	function LoginUser($email, $password, $connection)
	{
		if($email != null && $password != null)
		{
			$User = getUser($email, $connection);
			
			//https://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
			if($User != null && password_verify($password, $User->password))
			{
				//https://stackoverflow.com/questions/44887880/store-object-in-php-session/44888019 For seralize user object
				$_SESSION['User'] = serialize($User);
				
				return true;
			}
		}
		
		return false;
	}
	
	function RegisterUser($newUser, $connection)
	{
		if(insertUser($newUser, $connection))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function GetSessionUser()
	{
		if(isset($_SESSION['User']))
		{
			//https://stackoverflow.com/questions/44887880/store-object-in-php-session/44888019 For unseralize user object
			return unserialize($_SESSION['User']);
		}
		else
		{
			return false;
		}
	}

	function LogoutUser()
	{
		if(isset($_SESSION['User']))
		{
			$_SESSION['User'] = null;
			return true;
		}
		else
		{
			return false;
		}
	}
?>