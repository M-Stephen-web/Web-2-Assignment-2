<?php
require_once('header.php');
require_once('includes/session-helper.inc.php');
require_once('includes/db-helper.inc.php');
require_once('includes/config.inc.php');

$posterURL = 'https://image.tmdb.org/t/p/w500';
$largerPosterURL = 'https://image.tmdb.org/t/p/w780';

$user = GetSessionUser();

$movie = null;

if(isset($_GET['movieId']))
{
    $movie = getMovieDetail($_GET['movieId'], $connection);
}

if($movie == null)
{
    header('Location: index.php');
}

$isFavorited = false;

if(isset($_SESSION['Favorites']))
{
    $favoritedMovies = unserialize($_SESSION['Favorites']);

    foreach($favoritedMovies as $favoritemovie)
    {
        if($favoritemovie->id == $movie->id)
        {
            $isFavorited = true;
            break;
        }
    }
}


?>

<head>
    <meta charset='utf-8' />
    <title>Single Movie - </title>

    <link rel='stylesheet' href='css/detail.css'>
</head>

<body>
    <?php
        printHeader()
    ?>
    <main>
        <section id='leftBlock'>
            <h1 id='movieDetailTitle'><?php echo $movie->title ?></h1>
            <?php 
            if(IsLoggedIn())
            {
                if($isFavorited)
                {
                    echo "
                        <div class='favorite'>
                            <center><a href='favorites/addSingleFavorite.php?movieId=". $movie->id ."'><button id='addFavButton' class='selected'></button></a></center>
                        </div>
                    ";
                }
                else{
                    echo "
                        <div class='favorite'>
                            <center><a href='favorites/addSingleFavorite.php?movieId=". $movie->id ."'><button id='addFavButton'></button></a></center>
                        </div>
                    ";
                }
            }
            ?>
            <p id='movieDetailReleaseDate'>Release Date: <?php //echo $movie->release_date ?></p>
            <p id='movieDetailRevenue'>Revenue: 
                <?php 
                    //https://www.php.net/manual/en/function.number-format.php For the number_format function
                    echo '$'.number_format($movie->revenue) 
                ?>
            </p>
            <p id='movieDetailRuntime'>Runtime: 
                <?php 
                    //https://www.w3schools.com/PHP/func_math_floor.asp For the floor function
                    $hours =  floor($movie->runtime/60);
                    $minutes = $movie->runtime - 60*$hours;
                    
                    echo $hours . "h " . $minutes ."m";
                ?>
            </p>
            <p id='movieDetailTagline'>Tagline: <?php //echo $movie->tagline ?></p>
            <p id='movieDetailIMDBLabel'>IMDB Link: <a id='movieDetailIMDBLink' href="https://www.imdb.com/title/<?php echo $movie->imdb_id ?>">Link</a></p>
            <p id='movieDetailTMDBLabel'>TMDB Link: <a id='movieDetailTMDBLink' href=https://www.themoviedb.org/movie/<?php echo $movie->tmdb_id ?>">Link</a></p>
            <div id='movieOtherInfoBlock'>
                <div class='movieInfoBlock'>
                    <label>Companies</label>
                    <ul id='companiesList'>
                        <?php 
                            $companiesArray = json_decode($movie->production_companies);
                            foreach($companiesArray as $company)
                            {
                                echo "<li>" . $company->name . "</li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class='movieInfoBlock'>
                    <label>Countries</label>
                    <ul id='countriesList'>
                        <?php 
                            $countriesArray = json_decode($movie->production_countries);
                            foreach($countriesArray as $country)
                            {
                                echo "<li>" . $country->name . "</li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class='movieInfoBlock'>
                    <label>Keywords</label>
                    <ul id='keywordsList'>
                        <?php 
                            $keywordsArray = json_decode($movie->keywords);
                            foreach($keywordsArray as $keyword)
                            {
                                echo "<li>" . $keyword->name . "</li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class='movieInfoBlock'>
                    <label>Genres</label>
                    <ul id='genresList'>
                        <?php 
                            $genresArray = json_decode($movie->genres);
                            foreach($genresArray as $genre)
                            {
                                echo "<li>" . $genre->name . "</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </section>
        <section id='middleBlock'>
            <center id='movieDetailPosterBlock'>
                <img id='movieDetailPoster' src="<?php echo $posterURL . $movie->poster_path ?>" />
                <!-- Imported HTML Code URL: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal-->
                <!-- The Modal -->
                <div id='largerPosterModel' class='modal'>
                    <!-- Modal content -->
                    <div class='modal-content'>
                        <span class='close'>&times;</span>
                        <img id='largerMovieDetailPoster' src="<?php echo $largerPosterURL . $movie->poster_path ?>" />
                    </div>
                </div>
                <!-- End of Imported HTML Code -->
            </center>
        </section>
        <section id='rightBlock'>
            <div id='tabButtonBlock'>
                <div class='tab selected' id='castTab'>Cast</div>
                <div class='tab' id='crewTab'>Crew</div>
            </div>
            <div class='tabContentBlock cast' id='castList'>
                <div class='contentRow'>
                    <span>Character</span>
                    <span></span>
                    <span>Name</span>
                </div>
                <div id='castListContent'>
                    <?php
                        $castArray = json_decode($movie->cast);
                        foreach($castArray as $cast)
                        {
                            echo "<div class='contentRow'>
                                <span>
                                    " . $cast->character . "
                                </span>
                                <span>
                                </span>
                                <span>
                                    " . $cast->name . "
                                </span>
                            </div>";
                        }
                    ?>
                </div>
            </div>
            <div class='tabContentBlock' id='crewList'>
                <div class='contentRow'>
                    <span>Department</span>
                    <span>Job</span>
                    <span>Name</span>
                </div>
                <div id='crewListContent'>
                    <?php
                        $crewArray = json_decode($movie->crew);
                        foreach($crewArray as $crew)
                        {
                            echo "<div class='contentRow'>
                                <span>
                                    " . $crew->department . "
                                </span>
                                <span>
                                    " . $crew->job . "
                                </span>
                                <span>
                                    " . $crew->name . "
                                </span>
                            </div>";
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script src="js/detail.js"></script>
</body>
<footer></footer>
</html>