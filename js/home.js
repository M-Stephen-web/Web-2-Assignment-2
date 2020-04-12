//urls
const favMoviesURL = "http://phseguin.ca/apis/movies-favorite.php";
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";
const recommendationsURL = "http://phseguin.ca/apis/get-recommended.php";

let favorites = [];
let recommendations = [];

document.addEventListener("DOMContentLoaded", (e) => {
  //declarations for page elements
  const userInfo = document.querySelector("#userInfoBox");
  const recommendationsBox = document.querySelector("#recommendations");
  const favoritesBox = document.querySelector("#favoriteMoviesBox");
  const searchBox = document.querySelector("#searchBox");

  getFavorites();
  getRecommendations();

  function addRecommendedMovieBlock(movie) {
    let div = document.createElement("div");
    div.classList.add("favoriteMovieBlock");
    div.setAttribute("id", "favoriteBlock" + movie.id);

    let removeButton = document.createElement("a");
    removeButton.classList.add("removeFavoriteButton");
    removeButton.textContent = "X";

    removeButton.addEventListener("click", function (e) {
      removeFavorite(movie.id);
    });

    div.appendChild(removeButton);

    let a = document.createElement("a");
    a.setAttribute("href", "index.php");

    let img = document.createElement("img");
    img.classList.add("favoriteMovieImage");
    img.setAttribute("src", posterURL + "w185" + movie.poster_path);
    a.appendChild(img);

    let title = document.createElement("div");
    title.classList.add("favoriteMovieTitle");
    title.textContent = movie.title;
    a.appendChild(title);

    div.appendChild(a);

    recommendationsBox.appendChild(div);
  }

  function addFavoriteMovieBlock(movie) {
    console.log(movie);

    let div = document.createElement("div");
    div.classList.add("favoriteMovieBlock");
    div.setAttribute("id", "favoriteBlock" + movie.id);

    let removeButton = document.createElement("a");
    removeButton.classList.add("removeFavoriteButton");
    removeButton.textContent = "X";

    removeButton.addEventListener("click", function (e) {
      removeFavorite(movie.id);
    });

    div.appendChild(removeButton);

    let a = document.createElement("a");
    a.setAttribute("href", "index.php");

    let img = document.createElement("img");
    img.classList.add("favoriteMovieImage");
    img.setAttribute("src", posterURL + "w185" + movie.poster_path);
    a.appendChild(img);

    let title = document.createElement("div");
    title.classList.add("favoriteMovieTitle");
    title.textContent = movie.title;
    a.appendChild(title);

    div.appendChild(a);

    favoritesBox.appendChild(div);
  }

  function populateFavorites() {
    for (let i = 0; i < favorites.length; i++) {
      addFavoriteMovieBlock(favorites[i]);
    }
  }

  function populateRecommendations() {
    for (let i = 0; i < recommendations.length; i++) {
      addRecommendedMovieBlock(recommendations[i]);
    }
  }

  function getRecommendations() {
    fetch(recommendationsURL)
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          return Promise.reject({
            status: response.status,
            statusText: response.statusText,
          });
        }
      })
      .then((data) => {
        recommendations = data.data;
        populateRecommendations();
      });
  }
  function getFavorites() {
    fetch(favMoviesURL)
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          return Promise.reject({
            status: response.status,
            statusText: response.statusText,
          });
        }
      })
      .then((data) => {
        favorites = data.data;
        populateFavorites();
      })
      .catch((e) => console.log(error));
  }

  function removeFavorite(movieId) {
    fetch(removeFavoriteIdURL + movieId)
      .then(function (response) {
        if (response.ok) {
          return response.json();
        } else {
          return Promise.reject({
            status: response.status,
            statusText: response.statusText,
          });
        }
      })
      .then((data) => {
        if (data.isSuccessful) {
          let favoriteBlock = document.querySelector(
            "#favoriteBlock" + movieId
          );
          favoriteBlock.style.display = "none";
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }
});
