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
    <div class="header">
        <h1>Favourites</h1>
        <button id='removeAllFavorites' class="button">Remove All Favorites</button>
    </div>
    <section id="favoritesBlock">
    </section>
</body>
<script src='js/favorites.js'></script>