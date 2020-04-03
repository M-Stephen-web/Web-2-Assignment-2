<?php
    session_start();
                
    function addToFavorites($selectedMovie) {
        
        if (IsLoggedIn() == true) {
            $favorites = $_SESSION['Favorites'];
            $checkMovie = $_GET['id'];

            // checking if there is content in favorites, if not add movie
            if (!isset($favorites)) {
                echo 'There is no content here... add your favorite movies!';
                $favorites = [];
            } else {
                if ($selectedMovie == $checkMovie) {
                    echo $checkMovie . 'movie is already in favorites.';
                    // display the movie
                }
                else {
                    $favorites[] = $selectedMovie;
                }
            }
            $_SESSION['Favorites'] = $favorites;
        }
        else {
            // redirect to login
        }
    }

    function remove() {
        
    }


?>
