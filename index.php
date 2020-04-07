<?php
$userName = '';
$userId = '';

// function checkLoggedIn($userName)
// {
// 	if (isset($_POST['userName'])) {
// 		$userName = $_POST['userName'];
// 		echo $userName;
// 	} else {
// 		echo "<button id="loginButton">Log In</button>";
// 	}
// }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>Movie Browser</title>

	<link rel='stylesheet' href='css/index.css'>
</head>
<body>
	<div class="hero-image">
		<section id="homeSection">
			<div id="movieBrowerBox">
				<center>
					<h2 id="movieBrowserTitle">Movie Browser</h2>
				</center>
				<div id="">
					<div>
						<label for="userNameInput">user name</label>
						<input type="text" id="userNameInput" />
					</div>
					<div>
						<label for="passwordInput">password</label>
						<input type="password" id="passwordInput">
					</div>
					<div class="row">
						<button id="newAcctButton">
							create a new account </button>
						<button id="signInButton">
							sign in </button>
					</div>
				</div>
			</div>
	</section>
	<section id='defaultSection'>
		<header>
				<h2>COMP 3512 Assign2</h2>
		</header>
		<aside id='asideFilterBlock'>
			<div class='row filterBlock'>
				<div id='filterBox'>
					<center>
						<h2>Movie Filter</h2>
					</center>
					<div class='filterBlock'>
						<label class='filterTitle'>Title</label>
						<div>
							<input id='titleFilterInput' type='text' />
						</div>
					</div>
					<div class='filterBlock'>
						<label class='filterTitle'>Year</label>
						<div class='filterRow'>
							<label class='container'>Before
								<input type='radio' name='yearType' id='yearTypeRadioBefore'>
								<span class='checkmark'></span>
							</label>
							<input type='number' id='yearTypeValueBefore' />
						</div>
						<div class='filterRow'>
							<label class='container'>After
								<input type='radio' name='yearType' id='yearTypeRadioAfter'>
								<span class='checkmark'></span>
							</label>
							<input type='number' id='yearTypeValueAfter' />
						</div>
						<div class='filterRow'>
							<label class='container multiRow'>Between
								<input type='radio' name='yearType' id='yearTypeRadioBetween'>
								<span class='checkmark'></span>
							</label>
							<div class='multiRowInput'>
								<input type='number' id='yearTypeValueBetweenMin' />
								<input type='number' id='yearTypeValueBetweenMax' />
							</div>
						</div>
					</div>
					<div class='filterBlock'>
						<label class='filterTitle'>Rating</label>
						<div class='filterRow'>
							<label class='container'>Below
								<input type='radio' name='ratingType' id='ratingTypeRadioBelow'>
								<span class='checkmark'></span>
							</label>
							<div>
								<div class='sliderBlock'>
									<input type='range' min='0' max='10' id='ratingTypeValueBelow' />
								</div>
								<div class='rangeDescription'>
									<span>0</span>
									<span id='ratingBelowValue'>5</span>
									<span class='rangeMaxValue'>10</span>
								</div>
							</div>
						</div>
						<div class='filterRow'>
							<label class='container'>Above
								<input type='radio' name='ratingType' id='ratingTypeRadioAbove'>
								<span class='checkmark'></span>
							</label>
							<div>
								<div class='sliderBlock'>
									<input type='range' min='0' max='10' id='ratingTypeValueAbove' />
								</div>
								<div class='rangeDescription'>
									<span>0</span>
									<span id='ratingAboveValue'>5</span>
									<span class='rangeMaxValue'>10</span>
								</div>
							</div>
						</div>
						<div class='filterRow'>
							<label class='container multiRow'>Between
								<input type='radio' name='ratingType' id='ratingTypeRadioBetween'>
								<span class='checkmark'></span>
							</label>
							<div class='multiRowInput'>
								<div class='sliderBlock'>
									<input type='range' min='0' max='10' id='ratingTypeValueBetweenMin' />
								</div>
								<div class='sliderBlock'>
									<input type='range' min='0' max='10' id='ratingTypeValueBetweenMax' />
								</div>
								<div class='rangeDescription'>
									<span>0</span>
									<span>
										<span id='ratingBetweenMinValue'>5</span> -
										<span id='ratingBetweenMaxValue'>5</span>
									</span>
									<span class='rangeMaxValue'>10</span>
								</div>
							</div>
						</div>
					</div>
					<div class='filterButtonRow'>
						<button id='filterButton'>
							Filter
						</button>
						<button id='clearFilterButton'>
							Clear
						</button>
					</div>
				</div>
				<div id='filterCloseButton'>
					<h1>
						<< /h1> </div> </div> </aside> <div id='movieListBlock'>
							<center>
								<h2>List/Matches</h2>
							</center>
							<div class='matchesRow legend'>
								<label id='titleLabel'>Title</label>
								<label id='yearLabel'>Year</label>
								<label id='ratingLabel'>Rating</label>
							</div>
							<center id='errorMovieSearch'>
								No Movies Were Found
							</center>
							<div id='matchesRowsBlock'>
							</div>
							<center id='loadingSymbolDefaultView'>
								<img class='loadingSymbol' src='./images/loadingSymbol.gif' />
							</center>
				</div>
	</section>
	<section id='detailSection'>
		<main>
			<section id='leftBlock'>
				<div class='row speak'>
					<h1 id='movieDetailTitle'>Movie Title</h1>
					<button id='speakButton'>
						Speak
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
	
	<footer>Photo by Johannes Plenio on Unsplash</footer>
	<script src='js/index.js'></script>
</body>
</html>