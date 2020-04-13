<?php
// require_once('header.php');
// require_once('includes/db-helper.inc.php');

// $posterURL = 'https://image.tmdb.org/t/p/w185';

// $User = GetSessionUser(); //Gets current user

// $favoriteMovieIds = getFavoriteMovieIds($User, $connection); //Get all the movie ids the user has favorited

// $favoriteMovies = getMoviesByIds($favoriteMovieIds, $connection); //Passes the ids from above to get the movies

//$favoriteMovies = unserialize($_SESSION['Favorites']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Favourites</title>
    <link rel="stylesheet" href="css/favorites.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php //printHeader() ?>
    <div class="header">
        <h1>Favourites</h1>
        <a id='removeAllFavorites' class="button" href="favorites/removeAllFavorites.php">Remove All Favorites</a>
    </div>
    <section id="favoritesBlock">
        <?php
        
            // foreach($favoriteMovies as $movie)
            // {
            //     echo '<div class="favoriteMovieBlock">';
            //         echo '<a class="removeFavoriteButton" href="favorites/removeSingleFavorite.php?movieId='. $movie->id . '">X</a>';
            //         echo '<a>';
            //             echo '<img class="favoriteMovieImage" src="' . $posterURL . $movie->poster_path . '" />';
            //             echo '<div class="favoriteMovieTitle">' . $movie->title . '</div>';
            //         echo '</a>';
            //     echo'</div>';
            // }
        
        ?>
    </section>
</body>
<footer></footer>
</html>