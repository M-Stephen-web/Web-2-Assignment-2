<?php
	//This page's purpose is to deal with anything session related

	// session_start();

	// require_once('class-helper.inc.php'); //To handle User classes
    // require_once('config.inc.php'); //To have access to the connection variable
	
	
	/*
	Function to check if the user is currently logged in

	Returns true if there is a User session variable, false otherwise 
	*/
	function IsLoggedIn()
	{
		
		if(isset($_SESSION['User']) && $_SESSION['User'] != null)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	Function to login a user

	Takes in an email of the user
	Takes in a password of the user

	Returns true if succesfully saved the user to the session
	*/
	function LoginUser($email, $password, $connection)
	{
		if($email != null && $password != null) //Makes sure all variables are not null
		{
			$User = getUser($email, $connection); //Gets the user from database
			
			//https://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
			if($User != null && password_verify($password, $User->password)) //Checks if the user is not null and compares the passwords
			{
				//https://stackoverflow.com/questions/44887880/store-object-in-php-session/44888019 For seralize user object
				$_SESSION['User'] = serialize($User); //Seralizes the User object and save it to the session
				
				return true; //Return true if successfully saved the user to session
			}
		}
		
		return false; //Return false if failed to save the user to session
	}
	
	
	/*
	Function to register a new user

	Takes in a user object

	Returns true if succesfully saved the user to the database
	*/
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
	
	/*
	Function to get the user saved to the session

	Returns the user object
	*/
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

	/*
	Function to logout the current user

	Returns true if successfully removed the user object from session
	*/
	function LogoutUser()
	{
		if(isset($_SESSION['User']))
		{
			$_SESSION['User'] = null; //Set the user variable to null
			return true; //Return true is sucessful in logout
		}
		else
		{
			return false; //Return false is failed to logout
		}
	}
?>