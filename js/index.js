//All URLS needed
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";
const addFavUrl = "http://phseguin.ca/apis/favorite-create.php?movieId=";
const movieDetailURL = "http://phseguin.ca/apis/movies-brief.php";
const loginURL = "http://phseguin.ca/apis/login-user.php";
const registerURL = "http://phseguin.ca/apis/register-user.php";
const imdbURL = "https://www.imdb.com/title/";
const tmdbURL = "https://www.themoviedb.org/movie/";
const loadingSymbolURL = "./images/loadingSymbol.gif";
let movieId = "";

//Global variables to hold data
let movies = []; //To hold all movies that are sorted by title
let showingMovies = []; //To hold all movies that are currently being displayed

document.addEventListener("DOMContentLoaded", function () {
  //Elements to represent the different pages
  const homeSection = document.querySelector("#homeSection");
  const defaultSection = document.querySelector("#defaultSection");
  const detailSection = document.querySelector("#detailSection");

  //To hide all the pages
  function hideAllPages() {
    homeSection.style.display = "none";
    detailSection.style.display = "none";
    defaultSection.style.display = "none";
  }

  //Shows default page
  function showDefaultPage() {
    hideAllPages();

    matchesRowsBlock.style.display = "none";
    loadingSymbolDefaultView.style.display = "block";

    let storage = retieveStorage();

    //Checks if movies were saved to storage
    if (localStorage.getItem("movies")) {
      movies = storage;

      movies = sortMovies(movies); //Sort the stored movies

      showingMovies = movies.slice();

      populateDefaultView();
    } //If movies are not saved to storage, then fetch them
    else {
      fetchMovies();
    }

    defaultSection.style.display = "grid";
  }

  function showDetailPage() {
    hideAllPages();
    detailSection.style.display = "grid";
  }

  //To be used when in detail view to go back to the default page
  function closeDetailPage() {
    detailSection.style.display = "none";
    defaultSection.style.display = "grid";
  }

  function showHomePage() {
    hideAllPages();
    homeSection.style.display = "grid";
  }

  //Elements in the home page
  const signInButton = document.querySelector("#login"); //Button to show all the movies
  const newAcctButton = document.querySelector("#join"); //Button to show movies with title matching partially matching the input
  const movieSearchInput = document.querySelector("#searchBox"); //The input where the user can search by title

  //Event listener for when the user wants to search for a movie without signing in
  movieSearchInput.addEventListener("keypress", (e) => {
    if (e.key == "Enter") {
      titleFilterInput.value = movieSearchInput.value; //changes the filter input title to have the value inputted at home page
      showDefaultPage();
    }
  });

  
  //Function to close the detail page
  const closeDetailPageButton = document.querySelector(
    "#closeDetailPageButton"
  );

  closeDetailPageButton.addEventListener("click", function () {
    closeDetailPage();
  });
});
