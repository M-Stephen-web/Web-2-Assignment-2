<?php
	//This page's purpose is to define all the classes to be used for this website

	class User //Class to represent the user table
	{
		function __construct($userData)
		{
			if($userData['id'] != null) //Will not always have Id, such as when creating a new user
			{
				$this->id = $userData['id'];
			}
			$this->firstname = $userData['firstname'];
			$this->lastname = $userData['lastname'];
			$this->city = $userData['city'];
			$this->country = $userData['country'];
			$this->email = $userData['email'];
			$this->password = $userData['password'];
		}
		
		public $id;
		public $firstname;
		public $lastname;
		public $city;
		public $country;
		public $email;
		public $password;
		
	}
	
	class Movie //Class to represen the movies table
	{
		function __construct($sqlResult)
		{
			$this->id = $sqlResult['id'];
			//Will not always have the rest of the data below
			if(isset($sqlResult['tmdb_id']))
			{
				$this->tmdb_id = $sqlResult['tmdb_id'];
			}
			if(isset($sqlResult['imdb_id']))
			{
				$this->imdb_id = $sqlResult['imdb_id'];
			}
			if(isset($sqlResult['release_date']))
			{
				$this->release_date = $sqlResult['release_date'];
			}
			if(isset($sqlResult['title']))
			{
				$this->title = $sqlResult['title'];
			}
			if(isset($sqlResult['vote_average']))
			{
				$this->vote_average = $sqlResult['vote_average'];
			}
			if(isset($sqlResult['vote_count']))
			{
				$this->vote_count = $sqlResult['vote_count'];
			}
			if(isset($sqlResult['runtime']))
			{
				$this->runtime = $sqlResult['runtime'];
			}
			if(isset($sqlResult['revenue']))
			{
				$this->revenue = $sqlResult['revenue'];
			}
			if(isset($sqlResult['popularity']))
			{
				$this->popularity = $sqlResult['popularity'];
			}
			if(isset($sqlResult['poster_path']))
			{
				$this->poster_path = $sqlResult['poster_path'];
			}
			if(isset($sqlResult['tagline']))
			{
				$this->tagline = $sqlResult['tagline'];
			}
			if(isset($sqlResult['overview']))
			{
				$this->overview = $sqlResult['overview'];
			}
			if(isset($sqlResult['production_companies']))
			{
				$this->production_companies = $sqlResult['production_companies'];
			}
			if(isset($sqlResult['production_countries']))
			{
				$this->production_countries = $sqlResult['production_countries'];
			}
			if(isset($sqlResult['genres']))
			{
				$this->genres = $sqlResult['genres'];
			}
			if(isset($sqlResult['keywords']))
			{
				$this->keywords = $sqlResult['keywords'];
			}
			if(isset($sqlResult['cast']))
			{
				$this->cast = $sqlResult['cast'];
			}
			if(isset($sqlResult['crew']))
			{
				$this->crew = $sqlResult['crew'];
			}
		}
		
		public $id;
		public $tmdb_id;
		public $imdb_id;
		public $release_date;
		public $title;
		public $vote_average;
		public $vote_count;
		public $runtime;
		public $popularity;
		public $revenue;
		public $poster_path;
		public $tagline;
		public $overview;
		public $production_companies;
		public $production_countries;
		public $genres;
		public $keywords;
		public $cast;
		public $crew;
	}

	class Payload //Class to represent the way information is sent through APIs
	{
		function __construct($isSuccessful, $data, $errorMessage)
		{
			$this->isSuccessful = $isSuccessful;
			$this->data = $data;
			$this->errorMessage = $errorMessage;
		}

		public $isSuccessful;
		public $data;
		public $errorMessage;

	}
	
	class Favorite //Class to represent the favorites table
	{
		function __construct($userId, $movieId)
		{
			$this->userId = $userId;
			$this->movieId = $movieId;
		}
		
		public $userId;
		public $movieId;
	}

?>