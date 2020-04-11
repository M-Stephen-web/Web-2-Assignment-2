<?php
if(isset($_GET))
?>


<head>
    <meta charset='utf-8' />
    <title>Movie Browser</title>

    <link rel='stylesheet' href='css/index.css'>
</head>

<body>
    <section id='detailSection'>
        <main>
            <section id='leftBlock'>
                <div class='row speak'>
                    <h1 id='movieDetailTitle'>Movie Title</h1>
                    <button id='addFavButton'>
                        :heart:
                    </button>
                </div>
                <p id='movieDetailReleaseDate'>Release Date: </p>
                <p id='movieDetailRevenue'>Revenue: </p>
                <p id='movieDetailRuntime'>Runtime: </p>
                <p id='movieDetailTagline'>Tagline: </p>
                <p id='movieDetailIMDBLabel'>IMDB Link: <a id='movieDetailIMDBLink'></a></p>
                <p id='movieDetailTMDBLabel'>TMDB Link: <a id='movieDetailTMDBLink'></a></p>
                <div id='movieOtherInfoBlock'>
                    <div class='movieInfoBlock'>
                        <label>Companies</label>
                        <ul id='companiesList'>
                        </ul>
                    </div>
                    <div class='movieInfoBlock'>
                        <label>Countries</label>
                        <ul id='countriesList'>
                        </ul>
                    </div>
                    <div class='movieInfoBlock'>
                        <label>Keywords</label>
                        <ul id='keywordsList'>
                        </ul>
                    </div>
                    <div class='movieInfoBlock'>
                        <label>Genres</label>
                        <ul id='genresList'>
                        </ul>
                    </div>
                </div>
            </section>
            <section id='middleBlock'>
                <center>
                    <button id='closeDetailPageButton'>
                        Close
                    </button>
                </center>
                <center id='movieDetailPosterBlock'>
                    <img id='movieDetailPoster' />
                    <!-- Imported HTML Code URL: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal-->
                    <!-- The Modal -->
                    <div id='largerPosterModel' class='modal'>
                        <!-- Modal content -->
                        <div class='modal-content'>
                            <span class='close'>&times;</span>
                            <img id='largerMovieDetailPoster' />
                        </div>
                    </div>
                    <!-- End of Imported HTML Code -->
                </center>
            </section>
            <section id='rightBlock'>
                <div id='tabButtonBlock'>
                    <div class='tab selected' id='castTab'>
                        Cast
                    </div>
                    <div class='tab' id='crewTab'>
                        Crew
                    </div>
                </div>
                <div class='tabContentBlock cast' id='castList'>
                    <div class='contentRow'>
                        <span>
                            Character
                        </span>
                        <span>

                        </span>
                        <span>
                            Name
                        </span>
                    </div>
                    <div id='castListContent'>
                    </div>
                </div>
                <div class='tabContentBlock' id='crewList'>
                    <div class='contentRow'>
                        <span>
                            Department
                        </span>
                        <span>
                            Job
                        </span>
                        <span>
                            Name
                        </span>
                    </div>
                    <div id='crewListContent'>
                    </div>
                </div>
            </section>
        </main>
    </section>
    <script src="js/detail.js"></script>
</body>