<?php

	class User
	{
		function __construct($userData)
		{
			//$this->id = $userData['id'];
			$this->firstname = $userData['firstname'];
			$this->lastname = $userData['lastname'];
			$this->city = $userData['city'];
			$this->country = $userData['country'];
			$this->email = $userData['email'];
			$this->password = $userData['password'];
		}
		
		//public $id;
		public $firstname;
		public $lastname;
		public $city;
		public $country;
		public $email;
		public $password;
		//public $salt;
		//public $password_sha256;
		
		function getId(){return $this->id;}
		function getFirstname(){return $this->firstname;}
		function getLastname(){return $this->lastname;}
		function getCity(){return $this->city;}
		function getCountry(){return $this->country;}
		function getEmail(){return $this->email;}
		function getPassword(){return $this->password;}
		function getSalt(){return $this->salt;}
		function getPassword_Sha256(){return $this->password_sha256;}
		
		
		//function setId($id){$this->id=$id;}
		function setFirstname($firstname){$this->firstname=$firstname;}
		function setLastname($lastname){$this->lastname=$lastname;}
		function setCity($city){$this->city=$city;}
		function setCountry($country){$this->country=$country;}
		function setEmail($email){$this->email=$email;}
		function setPassword($password){$this->password=$password;}
		function setSalt($salt){$this->salt=$salt;}
		function setPassword_Sha256($password_sha256){$this->password_sha256=$password_sha256;}
		
	}
	
	class Movie
	{
		function __construct($sqlResult)
		{
			$this->id = $sqlResult['id'];
			$this->tmdb_id = $sqlResult['tmdb_id'];
			$this->imdb_id = $sqlResult['imdb_id'];
			$this->release_date = $sqlResult['release_date'];
			$this->title = $sqlResult['title'];
			$this->vote_average = $sqlResult['vote_average'];
			$this->vote_count = $sqlResult['vote_count'];
			$this->runtime = $sqlResult['runtime'];
			$this->popularity = $sqlResult['popularity'];
			$this->revenue = $sqlResult['revenue'];
			$this->poster_path = $sqlResult['poster_path'];
			$this->tagline = $sqlResult['tagline'];
			$this->overview = $sqlResult['overview'];
			$this->production_companies = $sqlResult['production_companies'];
			$this->production_countries = $sqlResult['production_countries'];
			$this->genres = $sqlResult['genres'];
			$this->keywords = $sqlResult['keywords'];
			$this->cast = $sqlResult['cast'];
			$this->crew = $sqlResult['crew'];
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
		
		function getId() {return $this->id;}
		function getTmdbId() {return $this->tmdb_id;}
		function getImdbId() {return $this->imdb_id;}
		function getRelease_Date() {return $this->release_date;}
		function getVoteAverage() {return $this->vote_average;}
		function getVoteCount() {return $this->vote_count;}
		function getRuntime() {return $this->runtime;}
		function getPopularity() {return $this->popularity;}
		function getRevenue() {return $this->revenue;}
		function getPosterPath() {return $this->poster_path;}
		function getTagline() {return $this->tagline;}
		function getOverview() {return $this->overview;}
		function getProductionCompanies() {return $this->production_companies;}
		function getProductionCountries() {return $this->production_countries;}
		function getGenres() {return $this->genres;}
		function getKeywords() {return $this->keywords;}
		function getCast() {return $this->cast;}
		function getCrew() {return $this->crew;}
		function getTitle() {return $this->title;}
	}

	class Payload
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

?>