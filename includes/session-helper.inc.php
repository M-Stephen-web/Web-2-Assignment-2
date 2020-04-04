<?php
	session_start();

	require_once('./class-helper.inc.php');
	require_once('./config.inc.php');
	
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
	
	function LoginUser($email, $password)
	{
		if($email != null && $password != null)
		{
			$User = getUser($email, connection);
			
			if($User->getPassword() == password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]))
			{
				$_SESSION['User'] = $User;
				
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	function RegisterUser($newUser)
	{
		if(insertUser($newUser, connection))
		{
			return true;
		}
		else
		{
			return false;
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