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
	
	
	function insertFavoriteSQL()
	{
		
		$sql = 'INSERT INTO favorites (userId, movieId)';
		$sql .= 'VALUES (:userId, :movieId);';

		return $sql;
	}
	
	function insertFavorite($Favorite, $connection)
	{
		$values = array();
		
		$values[":userId"] = $Favorite->userId;
		$values[":movieId"] = $Favorite->movieId;
		
		try{
			runQuery($connection, insertFavoriteSQL(), $values);

			return true;
		}
		catch(PDOException $e){
			return false;
		}
	}
	
	
	function getFavoriteMoviesSQL($ids)
	{
	
		$sql = 'SELECT * FROM movie';
		$sql .= " WHERE";
		
		$lastId = end($ids)['id'];
		
		$count = 0;
		
		foreach($ids as $id)
		{
			if($id['id'] != $lastId)
			{
				$sql .= " id" . $count . " = ? AND";
			}
			else
			{
				$sql .= " id" . $count . " = ?";
			}
			
			$count++;
		}
		
		$sql .= " ORDER BY title;";

		return $sql;
		
	}
	
	function getFavoriteMovies($User, $connection)
	{
		$values = array();
		
		$favoriteMovies = [];
		
		$movieIds = getFavoriteMovieIds($User, $connection);
		
		$count = 0;
		
		foreach($movieIds as $id)
		{
			$values[':id' . $count] = $id;
			$count++;
		}
		
		try{
			$sqlResult = runQuery($connection, getFavoriteMoviesSQL($movieIds), $values);
			
			
			foreach($sqlResult as $row)
			{
				$favoriteMovies[] = new FavoriteMovie($row);
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured";
		}
		
		return $favoriteMovies;
	}
	
	
	
	
	function getFavoriteMovieIdsSQL()
	{
	
		$sql = 'SELECT * FROM favorites';
		$sql .= " WHERE userId = :userId;";

		return $sql;
		
	}
	
	function getFavoriteMovieIds($User, $connection)
	{
		$values = array();
		
		$values[':userId'] = $User->id;
		
		$movieIds = [];
		
		try{
			$sqlResult = runQuery($connection, getFavoriteMovieIdsSQL(), $values);
			
			
			foreach($sqlResult as $row)
			{
				$movieIds = $row['movieId'];
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured";
		}
		
		return $movieIds;
	}
	
	
	
	
	function deleteAllFavoriteMovieSQL()
	{
	
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE userId = :userId;";

		return $sql;
		
	}
	
	function deleteAllFavoriteMovie($User, $connection)
	{
		$values = array();
		
		$values[':userId'] = $User->id;
		
		$movieIds = [];
		
		try{
			$sqlResult = runQuery($connection, deleteAllFavoriteMovieSQL(), $values);
			
			return true;
		}
		catch(PDOException $e)
		{
			return false;
		}
		
		return false;
	}
	
	
	
	
	function deleteFavoriteMovieIdSQL()
	{
	
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE id = :id";

		return $sql;
		
	}
	
	function deleteFavoriteMovieId($id, $connection)
	{
		$values = array();
		
		$values[':id'] = $id;
		
		try{
			$sqlResult = runQuery($connection, deleteFavoriteMovieIdSQL($movieIds), $values);
			
			return true;
		}
		catch(PDOException $e)
		{
			return false;
		}
		
		return false;
	}

?>
















