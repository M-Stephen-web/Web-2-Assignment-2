<?php 

    require_once('header.php');
    require_once('includes/session-helper.inc.php');

    $user = GetSessionUser();


?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/home.css">
    <meta title="Home Page">
</head>

<body>
    <?php  
        printHeader(); 
    ?>
    <div id="homeGridBlock">
        <div id="homeGridLeft">
            <div class="transparentBox">
                <h2>User Information</h2>
                <div id="userInfoBox">
                    <div>
                        Firstname: <?php echo $user->firstname ?>
                    </div>
                    <div>
                        Lastname: <?php echo $user->lastname ?>
                    </div>
                    <div>
                        City: <?php echo $user->city ?>
                    </div>
                    <div>
                        Country: <?php echo $user->country ?>
                    </div>
                    <div>
                        Email: <?php echo $user->email ?>
                    </div>
                </div>
            </div>
            <div class="transparentBox">
                <h2>Favorites</h2>
                <div id="favoriteMoviesBox">

                </div>
            </div>
        </div>
        <div id="homeGridRight">
            <div class="transparentBox" id="searchBox">
                <h2>Search Box For Movies</h2>
                <form method="GET" action="default.php">
                    <input id="movieSearch" name="movieFilter">
                </form>
            </div>
            <div class="transparentBox">
                <h2>Recommendations</h2>
                <div id="recommendations">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src='js/home.js'></script>