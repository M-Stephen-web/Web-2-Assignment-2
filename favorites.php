<?php
require_once('header.php')
?>

<!DOCTYPE html>

<head>
    <meta charset='utf-8' />
    <title>Favourites</title>
    <link rel="stylesheet" href="css/favorites.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php printHeader() ?>
    <div>
        <a href="index.php" id="homeButton" class="button">Home</a>
        <h2>Favourites</h2>
    </div>
    <button id='removeAllFavorites'>Remove All Favorites</button>
    </header>
    <section id="favoritesBlock">
    </section>
</body>
<script src='js/favorites.js'></script>