<?php
	require_once('config.inc.php');
	
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
		
		$sql = 'SELECT id, release_date, title, vote_average, poster_path FROM movie';
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
			return null;
		}
		
		return $user;
	}
	
	
	function insertUserSQL($User)
	{
		
		$sql = 'INSERT INTO users (firstname, lastname, city, country, email, password)';
		$sql .= 'VALUES (:firstname, :lastname, :city, :country, :email, :password);';

		return $sql;
		
	}
	
	function insertUser($User, $connection)
	{
		$ExistUser = getUser($User->email, $connection);

		if($ExistUser == null)
		{
			$values = array();
			
			$values[":firstname"] = $User->firstname();
			$values[":lastname"] = $User->lastname();
			$values[":city"] = $User->city();
			$values[":country"] = $User->country();
			$values[":email"] = $User->email();
			$values[":password"] = $User->password();
			
			try{
				runQuery($connection, insertUserSQL($User), $values);
	
				return true;
			}
			catch(PDOException $e){
				return false;
			}
		}
		else
		{
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


	function checkFavoriteExistSQL()
	{
		$sql = 'SELECT * FROM favorites';
		$sql .= ' WHERE userId = :userId AND movieId = :movieId;';

		return $sql;
	}

	function checkFavoriteExist($Favorite, $connection)
	{
		$values = array();
		
		$values[":userId"] = $Favorite->userId;
		$values[":movieId"] = $Favorite->movieId;
		
		try{
			$sqlResult = runQuery($connection, checkFavoriteExistSQL(), $values);

			$favoriteSQL = null;

			foreach($sqlResult as $row)
			{
				$favoriteSQL = $row;
			}

			if($favoriteSQL != null)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e){
			return true;
		}

	}
	
	
	function getFavoriteMoviesSQL($ids) //Return SQL query of getting all the movies with the ids matching the ids passed in
	{
	
		$sql = 'SELECT id, title, poster_path FROM movie';
		$sql .= " WHERE";
		
		//https://www.geeksforgeeks.org/php-end-function/
		$lastId = end($ids);
		
		$count = 0;
		
		foreach($ids as $id)
		{
			if($id != $lastId)
			{
				$sql .= " id = :id" . $count . "AND";
			}
			else
			{
				$sql .= " id = :id" . $count;
			}
			
			$count++;
		}
		
		$sql .= " ORDER BY title;";

		return $sql;
		
	}
	
	function getFavoriteMovies($User, $connection) //Returning all movies that are favorited by the user
	{
		$values = array();
		
		$favoriteMovies = [];
		
		$movieIds = getFavoriteMovieIds($User, $connection); //Get all the movie ids the user has favorited
		
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
				$favoriteMovies[] = new Movie($row);
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured at getFavoriteMovies";
		}
		
		return $favoriteMovies;
	}
	
	
	
	
	function getFavoriteMovieIdsSQL() //SQL query of returning all the favorite objects for a user
	{
	
		$sql = 'SELECT * FROM favorites';
		$sql .= " WHERE userId = :userId;";

		return $sql;
		
	}
	
	function getFavoriteMovieIds($User, $connection) //Get all the movie ids where the user has favorited movies
	{
		$values = array();
		
		$values[':userId'] = $User->id;
		
		$movieIds = [];
		
		try{
			$sqlResult = runQuery($connection, getFavoriteMovieIdsSQL(), $values);
			
			
			foreach($sqlResult as $row)
			{
				$movieIds[] = $row['movieId'];
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured";
		}
		
		return $movieIds;
	}
	
	
	function deleteAllFavoriteMovieSQL() //SQL query to delete all favorites for a user by userId
	{
	
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE userId = :userId;";

		return $sql;
		
	}
	
	function deleteAllFavoriteMovie($User, $connection) //To delete all favorites for a user
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
	
	
	function deleteFavoriteMovieIdSQL() //SQL query to delete a favorite by favorite primary key: id
	{
	
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE userId = :userId AND movieId = :movieId";

		return $sql;
		
	}
	
	function deleteFavoriteMovieId($movieId, $userId, $connection) //To delete a favorite by movie id and user id
	{
		$values = array();
		
		$values[':userId'] = $userId;
		$values[':movieId'] = $movieId;
		
		try{
			$sqlResult = runQuery($connection, deleteFavoriteMovieIdSQL(), $values);
			
			return true;
		}
		catch(PDOException $e)
		{
			return false;
		}
		
		return false;
	}

?>
















