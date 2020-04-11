const posterURL = "https://image.tmdb.org/t/p/";
const removeFavoriteIdURL = "apis/favorite-delete-id.php?movieId=";
const removeFavoriteAllURL = "apis/favorite-delete-all.php";

document.addEventListener('DOMContentLoaded', e => {
    const favorites = document.querySelector('favorites');
    const favMovies = [];
    getFavorites();


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
});

function getFavorites(){
    fetch("./apis/movies-favorite.php")
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
            console.log(data);

            //updateStorage(data); //Place favorites into local storage

            favMovies = data.data; //Set global variable

            //favMovies = sortMovies(movies); //Reset global variable with sorted movies

            populateFavoriteMovies(favMovies);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function populateFavoriteMovies(favMovies)
{
    for (let i = 0; i < favMovies.length; i++)
    {
        addFavoriteMovieBlock(favMovies[i]);
    }
}



let favoritesBlock = document.querySelector('#favoritesBlock');

function addFavoriteMovieBlock(movie)
{
    console.log(movie);


    let div = document.createElement('div');
    div.classList.add('favoriteMovieBlock');
    div.setAttribute('id', 'favoriteBlock'+movie.id);

    let removeButton = document.createElement('a');
    removeButton.classList.add('removeFavoriteButton');
    removeButton.textContent = 'X';

    removeButton.addEventListener('click', function(e){
        removeFavorite(movie.id);
    });

    div.appendChild(removeButton);
    
    let a = document.createElement('a');
    a.setAttribute("href", 'index.php');

    let img = document.createElement('img');
    img.classList.add('favoriteMovieImage');
    img.setAttribute("src", posterURL + "w185" + movie.poster_path);
    a.appendChild(img);

    let title = document.createElement('div');
    title.classList.add('favoriteMovieTitle');
    title.textContent = movie.title;
    a.appendChild(title);


    div.appendChild(a);

    favoritesBlock.appendChild(div);
}

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