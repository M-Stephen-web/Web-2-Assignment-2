//urls
const favMoviesURL = "http://phseguin.ca/apis/movies-favorite.php";
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";

let favorites = [];
let recommendations = [];

document.addEventListener("DOMContentLoaded", (e) => {
  //declarations for page elements
  const userInfo = document.querySelector('userInfoBox');
  const



  getRecommendations();


  function printRecommendations(){

  }
  function getRecommendations(){fetch(favMoviesURL)
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
    })
    .catch((e) => console.log(error));}

    
});
