<?php

	class User
	{
		

		function __construct($sqlResult)
		{
			$this->id = $sqlResult['id'];
			$this->firstname = $sqlResult['firstname'];
			$this->lastname = $sqlResult['lastname'];
			$this->city = $sqlResult['city'];
			$this->country = $sqlResult['country'];
			$this->email = $sqlResult['email'];
			$this->password = $sqlResult['password'];
			$this->salt = $sqlResult['salt'];
			$this->password_sha256 = $sqlResult['password_sha256'];
		}
		
		private $id;
		private $firstname;
		private $lastname;
		private $city;
		private $country;
		private $email;
		private $password;
		private $salt;
		private $password_sha256;
		
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
		
		private $id;
		private $tmdb_id;
		private $imdb_id;
		private $release_date;
		private $title;
		private $vote_average;
		private $vote_count;
		private $runtime;
		private $popularity;
		private $revenue;
		private $poster_path;
		private $tagline;
		private $overview;
		private $production_companies;
		private $production_countries;
		private $genres;
		private $keywords;
		private $cast;
		private $crew;
		
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

?>