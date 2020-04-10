document.addEventListener('DOMContentLoaded', e => {
    const favorites = document.querySelector('favorites');
    const favMovies = [];
    getFavorites();

})

function getFavorites(){
    fetch("movies-favorite.php")
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
            updateStorage(data); //Place favorites into local storage

            favMovies = data; //Set global variable

            favMovies = sortMovies(movies); //Reset global variable with sorted movies

            showingMovies = movies.slice(); //Set global variable

            populateDefaultView();
        })
        .catch(function (error) {
            console.log(error);
        });
}