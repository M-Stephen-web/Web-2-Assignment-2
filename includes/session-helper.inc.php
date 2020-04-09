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
			if($User != null && password_verify($password, $User->getPassword()))
			{
				$_SESSION['User'] = $User;
				
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
	
	function GetSessionUser ()
	{
		if(isset($_SESSION['User']))
		{
			return $_SESSION['User'];
		}
	}
?>