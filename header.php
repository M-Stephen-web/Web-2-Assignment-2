<?php
require_once('includes/session-helper.inc.php');
echo "<header> 
    <a href='index.php' class='button' id='homeButton'>Home</a> 
    <a href='about.php' class='button' id='aboutButton'>About</a>
    ";
if (IsLoggedIn()) {
    //echos header contents depending on whether the user is logged in
    echo "<a href='favorites.php' class='button' id='favButton'>Favorites</a>
              <a href='signout.php' class='button' id='logoutButton'>Log Out</a>";
} else {
    echo "<a href='login.php' class='button' id='loginButton'>Log In</a>
        <a href='registration.php' class='button' id='signupButton'>Sign Up</a>";
}
echo "</header>";
