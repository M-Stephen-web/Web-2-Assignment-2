<?php
	
	require_once 'config.inc.php';
	
	function runQuery($connection, $sql, $values) {
    
		$statement = null;
		
		if($values != null)
		{
			$statement = $connection->prepare($sql);
			
			foreach($row as $key => $value)
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
		
		$sql = 'SELECT id, title, vote_average, release_date, poster_path FROM movie';
		$sql .= " ORDER BY title";

		return $sql;
	}
	
	function getAllMovies($connection)
	{
		$sqlResult = runQuery($connection, getAllMoviesSQL(), null);
		
		$movies = [];
		
		foreach($sqlResult as $row)
		{
			$movies[] = new Movie($row);
		}
		
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
		
		$sqlResult = runQuery($connection, getMovieDetailSQL($Id), $values);
		
		$movie = null;
		
		foreach($sqlResult as $row)
		{
			$movie = new Movie($row);
		}
		
		return $movie;
	}
	
	
	function getUserSQL($Email)
	{
	
		$sql = 'SELECT * FROM Users';
		$sql .= " WHERE email = :email";

		return $sql;
		
	}
	
	function getUser($Email, $connection)
	{
		$values = array();
		
		$values[':email'] = $Email;
		
		$sqlResult = runQuery($connection, getUserSQL($Email), $values);
		
		$user = null;
		
		foreach($sqlResult as $row)
		{
			$user = new User($row);
		}
		
		return $user;
	}
	
	
	function insertUserSQL($User)
	{
		
		$sql = 'INSERT INTO Users (firstname, lastname, city, country, email, password, salt, password_sha256)';
		$sql .= 'VALUES (:firstname, :lastname, :city, :country, :email, :password, :salt, :password_sha256);';

		return $sql;
		
	}
	
	function insertUser($User, $connection)
	{
		$values = array();
		
		$values[":firstname"] = $User->getFirstname();
		$values["lastname:"] = $User->getLastname();
		$values[":city"] = $User->getCity();
		$values[":country"] = $User->getCountry();
		$values[":email"] = $User->getEmail();
		$values[":password"] = $User->getPassword();
		$values[":salt"] = $User->getSalt();
		$values[":password_sha256"] = $User->getPassword_Sha256();
		
		return runQuery($connection, insertUserSQL($User), $values);
	}

?>