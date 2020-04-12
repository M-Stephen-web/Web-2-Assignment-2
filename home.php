<?php #require_once('header.php')
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/index.css">
    <meta title="Home Page">
</head>

<body>
    <?php  #printHeader() 
    ?>
    <div class="left" id="userInfoBox">
        <?php #code to get user info here
        ?>
    </div>
    <div class="left" id="favoriteMoviesBox">

    </div>
    <div class="right" id="searchBox">
        <form method="GET" action="default.php">
            <input id="movieSearch" name="movieFilter">
        </form>
    </div>
    <div class="right" id="recommendations">

    </div>
</body>

</html>