<?php
	require_once 'config.inc.php';
	
	function runQuery($connection, $sql, $values) {
    
		$statement = null;
		
		if($values != null)
		{
			$statement = $connection->prepare($sql);
			
			foreach($values as $key => $value)
			{
				$statement->bindValue($key,$value);
			}
			
			$statement->execute();
			
			if (!$statement) {
				throw new PDOException;
			}
		}
		else  
		{
			$statement = $connection->query($sql); 
			
			if (!$statement) {
				throw new PDOException;
			}
		}
		
		return $statement;
	}  
	
	
	
	function getAllMoviesSQL() {
		
		$sql = 'SELECT * FROM movie';
		$sql .= " ORDER BY title";

		return $sql;
	}
	
	function getAllMovies($connection)
	{
		$movies = [];
		
		try{
			$sqlResult = runQuery($connection, getAllMoviesSQL(), null);
	
			foreach($sqlResult as $row)
			{
				$movies[] = new Movie($row);
			}
		}
		catch(PDOException $e){}
		
		return $movies;
	}
	
	
	function getMovieDetailSQL($Id) 
	{
	
		$sql = 'SELECT * FROM movie';
		$sql .= " WHERE id = :id";

		return $sql;
		
	}
	
	function getMovieDetail($Id, $connection)
	{
		$values = array();
		
		$values[':id'] = $Id;

		$movie = null;
		
		try{

			$sqlResult = runQuery($connection, getMovieDetailSQL($Id), $values);
		
			foreach($sqlResult as $row)
			{
				$movie = new Movie($row);
			}
			
		}
		catch(PDOException $e){}

		return $movie;
	}
	
	
	function getUserSQL()
	{
	
		$sql = 'SELECT * FROM users';
		$sql .= " WHERE email = :email";

		return $sql;
		
	}
	
	function getUser($Email, $connection)
	{
		$values = array();
		
		$values[':email'] = $Email;
		
		$user = null;
		
		try{
			$sqlResult = runQuery($connection, getUserSQL(), $values);
			
			
			foreach($sqlResult as $row)
			{
				$user = new User($row);
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured";
		}
		
		return $user;
	}
	
	
	function insertUserSQL($User)
	{
		
		$sql = 'INSERT INTO Users (firstname, lastname, city, country, email, password)';
		$sql .= 'VALUES (:firstname, :lastname, :city, :country, :email, :password);';

		return $sql;
		
	}
	
	function insertUser($User, $connection)
	{
		$values = array();
		
		$values[":firstname"] = $User->getFirstname();
		$values[":lastname"] = $User->getLastname();
		$values[":city"] = $User->getCity();
		$values[":country"] = $User->getCountry();
		$values[":email"] = $User->getEmail();
		$values[":password"] = $User->getPassword();
		
		try{
			runQuery($connection, insertUserSQL($User), $values);

			return true;
		}
		catch(PDOException $e){
			return false;
		}

	}

?>