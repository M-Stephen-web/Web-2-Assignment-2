const posterURL = "https://image.tmdb.org/t/p/";
const removeFavoriteIdURL = "apis/favorite-delete-id.php?movieId=";
const removeFavoriteAllURL = "apis/favorite-delete-all.php";

document.addEventListener('DOMContentLoaded', e => {

  document.querySelector('#removeAllFavorites').addEventListener('click', function (e)
  {
      fetch(removeFavoriteAllURL)
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
            if(data.isSuccessful)
            {
              let favoritesBlock = document.querySelector('#favoritesBlock');
              favoritesBlock.style.display = "none";
          }
        })
        .catch(function (error) {
          console.log(error);
        });
  });


  function removeFavorite(movieId)
  {
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
            if(data.isSuccessful)
            {
              let favoriteBlock = document.querySelector('#favoriteBlock'+movieId);
              favoriteBlock.style.display = "none";
          }
        })
        .catch(function (error) {
          console.log(error);
        });
  }
});