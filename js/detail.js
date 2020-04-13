//All URLs needed
const posterURL = "https://image.tmdb.org/t/p/";
const addFavUrl = "http://phseguin.ca/apis/favorite-create.php?movieId=";
const movieDetailURL = "http://phseguin.ca/apis/movies-brief.php";
const loginURL = "http://phseguin.ca/apis/login-user.php";
const registerURL = "http://phseguin.ca/apis/register-user.php";
const imdbURL = "https://www.imdb.com/title/";
const tmdbURL = "https://www.themoviedb.org/movie/";
const loadingSymbolURL = "./images/loadingSymbol.gif";

const leftMovieDetailBlock = document.querySelector("#leftBlock");
const rightMovieDetailBlock = document.querySelector("#rightBlock");
const posterElement = document.querySelector("#movieDetailPoster");

document.addEventListener("DOMContentLoaded", (e) => {

  //Element representing the speech button to speak the movie title
  const favButton = document.querySelector("#addFavButton");

  favButton.addEventListener("click", (e) => {
    fetch(addFavUrl + movieId, {
      method: "GET",
    })
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
        if (data.errorMessage) {
          alert(data.errorMessage);
        }
      });
  });


  const largerPosterElement = document.querySelector(
    "#largerMovieDetailPoster"
  );

  

  //JS code URL: https://www.w3schools.com/howto/howto_css_modals.asp

  // Get the modal
  var modal = document.getElementById("largerPosterModel");

  // Get the button that opens the modal
  var poster = document.getElementById("movieDetailPoster");

  // Get the <span> element that closes the modal
  var close = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  poster.addEventListener("click", function () {
    modal.style.display = "block";
  });

  // When the user clicks on <span> (x), close the modal
  close.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // When the user clicks anywhere outside of the modal, close it
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });

  const crewTab = document.querySelector("#crewTab");
  const castTab = document.querySelector("#castTab");

  crewTab.addEventListener("click", function () {
    crewList.style.display = "block";
    castList.style.display = "none";

    castTab.classList.remove("selected");
    crewTab.classList.add("selected");
  });

  castTab.addEventListener("click", function () {
    crewList.style.display = "none";
    castList.style.display = "block";

    crewTab.classList.remove("selected");
    castTab.classList.add("selected");
  });
  
});

