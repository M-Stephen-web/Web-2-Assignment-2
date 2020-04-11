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
  //Elements in the home page
  const movieSearchInput = document.querySelector("#searchBox"); //The input where the user can search by title

  //Event listener for when the user wants to search for a movie without signing in
  movieSearchInput.addEventListener("keypress", (e) => {
    if (e.key == "Enter") {
      showDefaultPage();
    }
  });
  function showDefaultPage() {
    fetch("default.php?pls=doit", {
      method: "GET",
    }).then((response) => {
      if (response.ok) {
        return response.json();
      } else {
        return Promise.reject({
          status: response.status,
          statusText: response.statusText,
        });
      }
    });
  }
});
