//urls
const favMoviesURL = "apis/movies-favorite.php";
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";
const recommendationsURL = "apis/get-recommended.php";

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

    let a = document.createElement("a");
    a.classList.add("imageAnchor");
    a.setAttribute("href", "index.php");

    let img = document.createElement("img");
    img.classList.add("favoriteMovieImage");
    img.setAttribute("src", posterURL + "w92" + movie.poster_path);
    a.appendChild(img);
    
    div.appendChild(a);

    let title = document.createElement("a");
    title.classList.add("favoriteMovieTitle");
    title.setAttribute("href", "index.php");
    title.textContent = movie.title;
    div.appendChild(title);

    recommendationsBox.appendChild(div);
  }

  function addFavoriteMovieBlock(movie) {
    let div = document.createElement("div");
    div.classList.add("favoriteMovieBlock");
    div.setAttribute("id", "favoriteBlock" + movie.id);

    let a = document.createElement("a");
    a.classList.add("imageAnchor");
    a.setAttribute("href", "index.php");

    let img = document.createElement("img");
    img.classList.add("favoriteMovieImage");
    img.setAttribute("src", posterURL + "w92" + movie.poster_path);
    a.appendChild(img);
    
    div.appendChild(a);

    let title = document.createElement("a");
    title.classList.add("favoriteMovieTitle");
    title.setAttribute("href", "index.php");
    title.textContent = movie.title;
    div.appendChild(title);

    favoritesBox.appendChild(div);
  }

  function populateFavorites(favorites) {
    for (let i = 0; i < favorites.length && i < 10; i++) {
      addFavoriteMovieBlock(favorites[i]);
    }
  }

  function populateRecommendations(recommendations) {
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
        populateRecommendations(data.data);
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
        populateFavorites(data.data);
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
