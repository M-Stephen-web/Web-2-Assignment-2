<?php
	//This page's purpose is to connect the database to the rest of the php pages

	/*
	Base run query function that runs query strings to the database.
	
	Takes in connection variable to connect to the provided database.
	Takes in the SQL string to be excuted.
	Takes in values to be replaced in the SQL string.
	
	Returns the results of running the SQL string to the given database.
	*/
	function runQuery($connection, $sql, $values) {
	
		//
		$statement = null;
		
		if($values != null) //If there are provided values, then the statement needs to bind the values
		{
			$statement = $connection->prepare($sql); //Prepare the SQL query
			
			foreach($values as $key => $value) //Replace each placeholder with the correct value
			{
				$statement->bindValue($key,$value);
			}
			
			$statement->execute(); //Excute the statement
			
			if (!$statement) { //Catch if there is an issue
				throw new PDOException;
			}
		}
		else  //If there is no provided values, simply run the query
		{
			$statement = $connection->query($sql); 
			
			if (!$statement) {
				throw new PDOException;
			}
		}
		
		return $statement; //Return the result
	}  
	
	
	
	function getAllMoviesSQL() { //SQL query to get all movies but with only basic values
		
		$sql = 'SELECT id, release_date, title, vote_average, poster_path FROM movie';
		$sql .= " ORDER BY title";

		return $sql;
	}
	
	/*
	Function to get all the movies in a database with only basic values

	Take in connection string to run the query to a specified database

	Returns an array of movies with the basic values
	*/
	function getAllMovies($connection)
	{
		$movies = []; //Initalize movies array
		
		try{
			$sqlResult = runQuery($connection, getAllMoviesSQL(), null);  //Execute the SQL query which is called upon and executed with the given connection variable
	
			foreach($sqlResult as $row) //Go through the results of the query and transform each row into a movie object to be place inside the movies array
			{
				$movies[] = new Movie($row);
			}
		}
		catch(PDOException $e){} //Catch if error occurs
		
		return $movies; //Returns the array of movies
	}
	
	
	function getMovieDetailSQL()  //SQL query to get all of a movie's info by a specified id
	{
	
		$sql = 'SELECT * FROM movie';
		$sql .= " WHERE id = :id";

		return $sql;
		
	}
	
	/*
	Function to get a movies in a database with all its data

	Take in an Id to find the specified movie
	Take in connection string to run the query to a specified database

	Returns an array of movies with the basic values
	*/
	function getMovieDetail($Id, $connection)
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[':id'] = $Id;

		//Initalize the movie variable
		$movie = null;
		
		try{

			$sqlResult = runQuery($connection, getMovieDetailSQL($Id), $values);  //Execute the SQL query which is called upon and executed with the given connection variable
		
			foreach($sqlResult as $row) //Go though the result and transform the result into a movie object
			{
				$movie = new Movie($row);
			}
			
		}
		catch(PDOException $e){}

		return $movie; //Return the movie object
	}
	
	
	function getUserSQL()  //SQL query to get a specific user by email
	{
	
		$sql = 'SELECT * FROM users';
		$sql .= " WHERE email = :email";

		return $sql;
		
	}
	
	/*
	Function to get a user in a database by an email

	Take in an email to find the specific user
	Take in connection string to run the query to a specified database

	Returns the user
	*/
	function getUser($Email, $connection)
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[':email'] = $Email;
		
		//Initalize the user variable
		$user = null;
		
		try{
			$sqlResult = runQuery($connection, getUserSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable
			
			
			foreach($sqlResult as $row) //Go though the result and transform the result into a user object
			{
				$user = new User($row);
			}
			
		}
		catch(PDOException $e)
		{
			return null;
		}
		
		return $user; //Return the user object
	}
	
	
	function insertUserSQL($User)   //SQL query to insert a new user with all the given data
	{
		
		$sql = 'INSERT INTO users (firstname, lastname, city, country, email, password)';
		$sql .= 'VALUES (:firstname, :lastname, :city, :country, :email, :password);';

		return $sql;
		
	}
	
	/*
	Function to insert a new user

	Take in a user object to pass to the database
	Take in connection string to run the query to a specified database

	Returns true if successfully inserted the user
	*/
	function insertUser($User, $connection)
	{
		$ExistUser = getUser($User->email, $connection); //Attempts to get a user in the database

		if($ExistUser == null) //If attempted retrieval of a user is null, then continue to insert the new user
		{
			//Create the values array to be passed on when the query is prepared
			$values = array();
			
			$values[":firstname"] = $User->firstname;
			$values[":lastname"] = $User->lastname;
			$values[":city"] = $User->city;
			$values[":country"] = $User->country;
			$values[":email"] = $User->email;
			$values[":password"] = $User->password;
			
			try{
				runQuery($connection, insertUserSQL($User), $values); //Execute the SQL query which is called upon and executed with the given connection variable
	
				return true;  //Return true if the user have been successfully inserted
			}
			catch(PDOException $e){
				return false;  //Return false if an error occured in the database
			}
		}
		else
		{
			return false;  //Return false if the user already exists
		}
	}
	
	
	function insertFavoriteSQL()  //SQL query to insert a new favorite for a user
	{
		
		$sql = 'INSERT INTO favorites (userId, movieId)';
		$sql .= 'VALUES (:userId, :movieId);';

		return $sql;
	}
	
	/*
	Function to insert a new favorite

	Take in a Favorite object to pass to the database
	Take in connection string to run the query to a specified database

	Returns true if successfully inserted the favorite
	*/
	function insertFavorite($Favorite, $connection)
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[":userId"] = $Favorite->userId;
		$values[":movieId"] = $Favorite->movieId;

		
		try{
			runQuery($connection, insertFavoriteSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable

			return true;  //Return true if successfully inserting a new favorite to the database
		}
		catch(PDOException $e){
			return false; //Return false if failed to insert a new favorite to the database
		}

	}


	function checkFavoriteExistSQL()  //SQL query to select a favorite with userId and movieId
	{
		$sql = 'SELECT * FROM favorites';
		$sql .= ' WHERE userId = :userId AND movieId = :movieId;';

		return $sql;
	}

	/*
	Function to check a favorite is in the database

	Take in a Favorite object to check in the database
	Take in connection string to run the query to a specified database

	Returns true if provided favorite is found in the database
	*/
	function checkFavoriteExist($Favorite, $connection)
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[":userId"] = $Favorite->userId;
		$values[":movieId"] = $Favorite->movieId;
		
		try{
			$sqlResult = runQuery($connection, checkFavoriteExistSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable

			$favoriteSQL = null;

			foreach($sqlResult as $row)  //Go though the result and have the favoriteSQL variable point to it
			{
				$favoriteSQL = $row;
			}

			if($favoriteSQL != null)
			{
				return true; //Return true if the specified favorite already exists
			}
			else
			{
				return false; //Return false if the specified favorite does not exist
			}
		}
		catch(PDOException $e){
			return true;  //Return true as a precaution because an error occured on the database
		}

	}
	
	
	function getMoviesByIdsSQL($ids)   //SQL query to get movies with a provided array of movie ids
	{
	
		$sql = 'SELECT id, title, vote_average, release_date, poster_path FROM movie';
		$sql .= " WHERE";
		
		//https://www.geeksforgeeks.org/php-end-function/ To find the last element in an array
		$lastId = end($ids);
		
		$count = 0;
		
		//Goes through each id and sets up placeholders to be used for when binding values for executing the query
		foreach($ids as $id)
		{
			if($id != $lastId)
			{
				$sql .= " id = :id" . $count . " OR ";
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
	
	/*
	Function to get an array of movies with certain ids

	Take in an array of movie ids
	Take in connection string to run the query to a specified database

	Returns the array of movies 
	*/
	function getMoviesByIds($movieIds, $connection) //Returning all movies that are favorited by the user
	{
		//Initalize the movie array variable
		$favoriteMovies = [];
		
		//Create the values array to be passed on when the query is prepared
		$values = array();

		$count = 0;

		foreach($movieIds as $id)
		{
			$values[':id' . $count] = $id;
			$count++;
		}
		
		try{
			$sqlResult = runQuery($connection, getMoviesByIdsSQL($movieIds), $values); //Execute the SQL query which is called upon and executed with the given connection variable

			foreach($sqlResult as $row)  //Go though the result and transform each row into a movie object
			{
				$favoriteMovies[] = new Movie($row);
			}
		}
		catch(PDOException $e)
		{}
		
		return $favoriteMovies;  //Return array of movies
	}
	
	
	
	
	function getFavoriteMovieIdsSQL()  //SQL query to get all favorites for a specified user through userId
	{
	
		$sql = 'SELECT * FROM favorites';
		$sql .= " WHERE userId = :userId ;";

		return $sql;
		
	}
	
	/*
	Function to get an array of movie ids which the user has favorited

	Take in a user
	Take in connection string to run the query to a specified database

	Returns the array of movie ids
	*/
	function getFavoriteMovieIds($User, $connection) //Get all the movie ids where the user has favorited movies
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[':userId'] = $User->id;
		
		//Initalize the movie ids array variable
		$movieIds = [];
		
		try{
			$sqlResult = runQuery($connection, getFavoriteMovieIdsSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable
			
			
			foreach($sqlResult as $row)  //Go though the result and obtain the movieId and have it placed in the movieIds array
			{
				$movieIds[] = $row['movieId'];
			}
			
		}
		catch(PDOException $e)
		{
			echo "Exception occured";
		}
		
		return $movieIds;  //Return array of movie ids
	}
	
	
	function deleteAllFavoriteMovieSQL()  //SQL query to delete all favorites for a user through the use of their userId
	{
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE userId = :userId;";

		return $sql;
	}
	
	/*
	Function to delete all favorites for a user

	Take in a user
	Take in connection string to run the query to a specified database

	Returns true if successfully deleted all favorites
	*/
	function deleteAllFavoriteMovie($User, $connection) //To delete all favorites for a user
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[':userId'] = $User->id;
		
		try{
			runQuery($connection, deleteAllFavoriteMovieSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable
			
			return true;  //Return true if successfully delete all favorites for a specific user
		}
		catch(PDOException $e)
		{
			return false;   //Return false if failed delete all favorites for a specific user
		}
		
		return false; //Return false if failed delete all favorites for a specific user
	}
	
	
	function deleteFavoriteMovieIdSQL()  //SQL query to delete a specific favorite by using userId and movieId
	{
	
		$sql = 'DELETE FROM favorites';
		$sql .= " WHERE userId = :userId AND movieId = :movieId";

		return $sql;
		
	}
	
	/*
	Function to delete a favorites for a specific user and movie

	Take in a movie id
	Take in a user id
	Take in connection string to run the query to a specified database

	Returns true if successfully deleted the favorite
	*/
	function deleteFavoriteMovieId($movieId, $userId, $connection) //To delete a favorite by movie id and user id
	{
		//Create the values array to be passed on when the query is prepared
		$values = array();
		
		$values[':userId'] = $userId;
		$values[':movieId'] = $movieId;
		
		try{
			runQuery($connection, deleteFavoriteMovieIdSQL(), $values); //Execute the SQL query which is called upon and executed with the given connection variable
			
			return true; //Return true if successfully deleted a specific favorites for a user
		}
		catch(PDOException $e)
		{
			return false; //Return false if failed to delete a specific favorites for a user
		}
		
		return false; //Return false if failed to delete a specific favorites for a user
	}

	function getTopRecommendedMoviesSQL()  //SQL query to get all top recommended movies by sorting them by year and then vote_average,ut only take 15
	{
		$sql = "SELECT id, title, release_date, vote_average, poster_path FROM movie ORDER BY  SUBSTRING(release_date,1,4) DESC, vote_average DESC LIMIT 15;";

		return $sql;
	}

	
	/*
	Function to get 15 recommended movied

	Recommended movies are determined by the latest year and highest vote_average

	Take in connection string to run the query to a specified database

	Returns true if successfully deleted all favorites
	*/
	function getTopRecommendedMovies($connection)
	{
		//Initalize the recommended movies array variable
		$recommendedMovies = [];
		
		try{
			$sqlResult = runQuery($connection, getTopRecommendedMoviesSQL(), null); //Execute the SQL query which is called upon and executed with the given connection variable
	
			foreach($sqlResult as $row)  //Go though the result and transform each row into a movie object
			{
				$recommendedMovies[] = new Movie($row);
			}
		}
		catch(PDOException $e){}
		
		return $recommendedMovies;  //Return array of recommended movies
	}
?>
