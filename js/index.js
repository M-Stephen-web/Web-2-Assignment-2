//All URLS needed
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";
const movieDetailURL = "http://phseguin.ca/apis/movies-brief.php";
const loginURL = "http://phseguin.ca/apis/login-user.php";
const registerURL = "http://phseguin.ca/apis/register-user.php";
const imdbURL = "https://www.imdb.com/title/";
const tmdbURL = "https://www.themoviedb.org/movie/";
const loadingSymbolURL = "./images/loadingSymbol.gif";

//Global variables to hold data
let movies = []; //To hold all movies that are sorted by title
let showingMovies = []; //To hold all movies that are currently being displayed

document.addEventListener("DOMContentLoaded", function () {
  //Elements to represent the different pages
  const homeSection = document.querySelector("#homeSection");
  const defaultSection = document.querySelector("#defaultSection");
  const detailSection = document.querySelector("#detailSection");
  const favButton = document.querySelector("#favButton");

  //To hide all the pages
  function hideAllPages() {
    homeSection.style.display = "none";
    detailSection.style.display = "none";
    defaultSection.style.display = "none";
  }

  //Shows default page
  function showDefaultPage() {
    hideAllPages();
    //check if the user is logged in
    if (true) {
      favButton.style.display = "none";
    }
    matchesRowsBlock.style.display = "none";
    loadingSymbolDefaultView.style.display = "block";

    let storage = retieveStorage();

    //Checks if movies were saved to storage
    if (localStorage.getItem("movies")) {
      movies = storage;

      movies = sortMovies(movies); //Sort the stored movies

      showingMovies = movies.slice();

      populateDefaultView();
    } //If movies are not saved to storage, then fetch them
    else {
      fetchMovies();
    }

    defaultSection.style.display = "grid";
  }

  function showDetailPage() {
    hideAllPages();
    detailSection.style.display = "grid";
  }

  //To be used when in detail view to go back to the default page
  function closeDetailPage() {
    detailSection.style.display = "none";
    defaultSection.style.display = "grid";
  }

  function showHomePage() {
    hideAllPages();
    homeSection.style.display = "grid";
  }

  //Elements in the home page
  const signInButton = document.querySelector("#login"); //Button to show all the movies
  const newAcctButton = document.querySelector("#join"); //Button to show movies with title matching partially matching the input
  const movieSearchInput = document.querySelector("#searchBox"); //The input where the user can search by title

  //Event listener for when the user wants to search for a movie without signing in
  movieSearchInput.addEventListener("keypress", (e) => {
    console.log(e.key);
    if (e.key == "Enter") {
      titleFilterInput.value = movieSearchInput.value; //changes the filter input title to have the value inputted at home page
      showDefaultPage();
    }
  });

  //Click listener for when the user wants to sign in
  signInButton.addEventListener("click", function () {
    //this will do something eventually
  });

  //Click listener for when the user wants to create a new ac
  newAcctButton.addEventListener("click", function (e) {
    //this will do something eventually
  });

  //To fetch all the movies
  function fetchMovies() {
    console.log("fetching");
    fetch(movieListURL)
      .then(function (response) {
        console.log("fetch halfway");
        if (response.ok) {
          return response.json();
        } else {
          return Promise.reject({
            status: response.status,
            statusText: response.statusText,
          });
        }
      })
      .then((data) => {
        console.log("fetch complete");
        updateStorage(data); //Place movies into local storage

        movies = data; //Set global variable

        movies = sortMovies(movies); //Reset global variable with sorted movies

        showingMovies = movies.slice(); //Set global variable

        populateDefaultView();
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  //To retireve the movie data locally
  function retieveStorage() {
    return JSON.parse(localStorage.getItem("movies")) || [];
  }

  //To update the movie data to local storage
  function updateStorage(data) {
    console.log("doin it");
    localStorage.setItem("movies", JSON.stringify(data));
  }

  const loadingSymbolDefaultView = document.querySelector(
    "#loadingSymbolDefaultView"
  );

  //To display the default view with all the movies
  function populateDefaultView() {
    showingMovies = filterMovies(movies.slice());

    populateMovieList();

    matchesRowsBlock.style.display = "block";
    loadingSymbolDefaultView.style.display = "none";
  }

  //Elements selected for showing movies or error in the list
  const errorMovieSearch = document.querySelector("#errorMovieSearch");
  const matchesRowsBlock = document.querySelector("#matchesRowsBlock");

  //To display showingMovies to the screen
  function populateMovieList() {
    //Readjust screen if error message was showing
    matchesRowsBlock.style.height = "75vh";
    errorMovieSearch.style.display = "none";

    //Empty the list element
    matchesRowsBlock.innerHTML = "";

    //Flag to see if a movie is displayed
    let movieShown = false;

    for (let i = 0; i < showingMovies.length; i++) {
      if (showingMovies[i]) {
        generateMatchRow(showingMovies[i]);
        movieShown = true;
      }
    }

    //If no movie was displayed, then show error message
    if (!movieShown) {
      matchesRowsBlock.style.height = "70vh";
      errorMovieSearch.style.display = "block";
    }
  }

  //To sort the movies by title
  function sortMovies(movies) {
    movies.sort(function (a, b) {
      return a.title.localeCompare(b.title);
    });

    return movies;
  }

  //Elements to capture the buttons in the filter box
  const filterButton = document.querySelector("#filterButton");
  const clearFilterButton = document.querySelector("#clearFilterButton");

  //If filter button is clicked, show the default page
  filterButton.addEventListener("click", function () {
    showDefaultPage(movies);
  });

  //If clear button is clicked, reset all the values in the filter box
  clearFilterButton.addEventListener("click", function () {
    titleFilterInput.value = "";

    yearTypeRadioBefore.checked = false;
    yearTypeRadioAfter.checked = false;
    yearTypeRadioBetween.checked = false;

    yearTypeValueBefore.value = "";
    yearTypeValueAfter.value = "";
    yearTypeValueBetweenMin.value = "";
    yearTypeValueBetweenMax.value = "";

    ratingTypeRadioBelow.checked = false;
    ratingTypeRadioAbove.checked = false;
    ratingTypeRadioBetween.checked = false;

    ratingTypeValueBelow.value = 5;
    ratingTypeValueAbove.value = 5;
    ratingTypeValueBetweenMin.value = 5;
    ratingTypeValueBetweenMax.value = 5;

    ratingBelowValue.innerHTML = 5;
    ratingAboveValue.innerHTML = 5;
    ratingBetweenMinValue.innerHTML = 5;
    ratingBetweenMaxValue.innerHTML = 5;

    showDefaultPage(movies);
  });

  //Element representing the speech button to speak the movie title
  const speakButton = document.querySelector("#speakButton");

  //When the speak button is clicked, speak the currently shwoing movie's title
  speakButton.addEventListener("click", function () {
    speakTitle(speakTitleText);
  });

  //Event delgation for when an image, title or button is clicked for a movie, that movie is shown in the detail view
  matchesRowsBlock.addEventListener("click", function (e) {
    if (e.target) {
      showMovieDetail(e.target.parentNode.getAttribute("movieId"));
    }
  });

  //To generate each row of showingMovies
  function generateMatchRow(movie) {
    let div = document.createElement("div");
    div.classList.add("matchesRow");
    div.setAttribute("movieId", movie.id);

    let img = document.createElement("img");
    img.setAttribute("src", posterURL + "w92" + movie.poster);
    div.appendChild(img);

    let title = document.createElement("label");
    title.classList.add("title");
    title.textContent = movie.title;
    div.appendChild(title);

    let year = document.createElement("span");
    year.textContent = movie.release_date.substring(0, 4);
    div.appendChild(year);

    let rating = document.createElement("span");
    rating.textContent = movie.ratings.average;
    div.appendChild(rating);

    let view = document.createElement("button");
    view.textContent = "View";

    div.appendChild(view);

    matchesRowsBlock.append(div);
  }

  //Support the filter feature
  const titleFilterInput = document.querySelector("#titleFilterInput");

  const yearTypeRadioBefore = document.querySelector("#yearTypeRadioBefore");
  const yearTypeValueBefore = document.querySelector("#yearTypeValueBefore");

  const yearTypeRadioAfter = document.querySelector("#yearTypeRadioAfter");
  const yearTypeValueAfter = document.querySelector("#yearTypeValueAfter");

  const yearTypeRadioBetween = document.querySelector("#yearTypeRadioBetween");
  const yearTypeValueBetweenMin = document.querySelector(
    "#yearTypeValueBetweenMin"
  );
  const yearTypeValueBetweenMax = document.querySelector(
    "#yearTypeValueBetweenMax"
  );

  const ratingTypeRadioBelow = document.querySelector("#ratingTypeRadioBelow");
  const ratingTypeValueBelow = document.querySelector("#ratingTypeValueBelow");

  const ratingTypeRadioAbove = document.querySelector("#ratingTypeRadioAbove");
  const ratingTypeValueAbove = document.querySelector("#ratingTypeValueAbove");

  const ratingTypeRadioBetween = document.querySelector(
    "#ratingTypeRadioBetween"
  );
  const ratingTypeValueBetweenMin = document.querySelector(
    "#ratingTypeValueBetweenMin"
  );
  const ratingTypeValueBetweenMax = document.querySelector(
    "#ratingTypeValueBetweenMax"
  );

  //To filter through each movie if it is to be shown
  function filterMovies(sortedMovies) {
    for (let i = 0; i < sortedMovies.length; i++) {
      //To filter by title
      if (titleFilterInput.value) {
        if (
          !sortedMovies[i].title
            .toLowerCase()
            .includes(titleFilterInput.value.toLowerCase())
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by year before
      if (yearTypeRadioBefore.checked) {
        if (
          sortedMovies[i] &&
          sortedMovies[i].release_date > yearTypeValueBefore.value
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by year after
      if (yearTypeRadioAfter.checked) {
        if (
          sortedMovies[i] &&
          sortedMovies[i].release_date < yearTypeValueAfter.value
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by year between
      if (yearTypeRadioBetween.checked) {
        if (sortedMovies[i]) {
          if (
            !(
              sortedMovies[i].release_date < yearTypeValueBetweenMax.value &&
              sortedMovies[i].release_date > yearTypeValueBetweenMin.value
            )
          ) {
            delete sortedMovies[i];
          }
        }
      }

      //To filter by rating below
      if (ratingTypeRadioBelow.checked) {
        if (
          sortedMovies[i] &&
          sortedMovies[i].ratings.average > ratingTypeValueBelow.value
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by rating after
      if (ratingTypeRadioAbove.checked) {
        if (
          sortedMovies[i] &&
          sortedMovies[i].ratings.average < ratingTypeValueAbove.value
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by rating between
      if (ratingTypeRadioBetween.checked) {
        console.log(
          "ratingTypeValueBetweenMax:" +
            ratingTypeValueBetweenMax.value +
            " ratingTypeValueBetweenMin: " +
            ratingTypeValueBetweenMin.value
        );
        if (sortedMovies[i]) {
          if (
            !(
              sortedMovies[i].ratings.average <=
                ratingTypeValueBetweenMax.value &&
              sortedMovies[i].ratings.average >= ratingTypeValueBetweenMin.value
            )
          ) {
            delete sortedMovies[i];
          }
        }
      }
    }

    return sortedMovies;
  }
  //end of filter feature

  //To change the shown value of each slider when everytime a slider has been changed
  const ratingBelowValue = document.querySelector("#ratingBelowValue");

  ratingTypeValueBelow.addEventListener("change", function () {
    ratingBelowValue.innerHTML = ratingTypeValueBelow.value;
  });

  const ratingAboveValue = document.querySelector("#ratingAboveValue");

  ratingTypeValueAbove.addEventListener("change", function () {
    ratingAboveValue.innerHTML = ratingTypeValueAbove.value;
  });

  const ratingBetweenMinValue = document.querySelector(
    "#ratingBetweenMinValue"
  );
  const ratingBetweenMaxValue = document.querySelector(
    "#ratingBetweenMaxValue"
  );

  ratingTypeValueBetweenMin.addEventListener("change", function () {
    ratingBetweenMinValue.innerHTML = ratingTypeValueBetweenMin.value;
  });

  ratingTypeValueBetweenMax.addEventListener("change", function () {
    ratingBetweenMaxValue.innerHTML = ratingTypeValueBetweenMax.value;
  });
  //End slider feature

  //tab features
  const titleLabel = document.querySelector("#titleLabel");
  const yearLabel = document.querySelector("#yearLabel");
  const ratingLabel = document.querySelector("#ratingLabel");

  //Use a variable to determine at what order the list is being shown as
  let titleOrder = "asc";

  titleLabel.addEventListener("click", function () {
    console.log(showingMovies);

    if (showingMovies.length > 2) {
      if (titleOrder == "asc") {
        showingMovies = showingMovies.sort(function (b, a) {
          return a.title.localeCompare(b.title);
        });

        titleOrder = "desc";
      } else {
        showingMovies = showingMovies.sort(function (a, b) {
          return a.title.localeCompare(b.title);
        });

        titleOrder = "asc";
      }
    }

    populateMovieList();
  });

  let yearOrder = "asc";

  yearLabel.addEventListener("click", function () {
    if (showingMovies.length > 2) {
      if (yearOrder == "asc") {
        showingMovies = showingMovies.sort(function (b, a) {
          if (a.release_date >= b.release_date) return 1;
          else return -1;
        });

        yearOrder = "desc";
      } else {
        showingMovies = showingMovies.sort(function (a, b) {
          if (a.release_date >= b.release_date) return 1;
          else return -1;
        });

        yearOrder = "asc";
      }
    }

    populateMovieList();
  });

  let ratingOrder = "asc";

  ratingLabel.addEventListener("click", function () {
    if (showingMovies.length > 2) {
      if (ratingOrder == "asc") {
        showingMovies = showingMovies.sort(function (b, a) {
          if (a.ratings.average >= b.ratings.average) return 1;
          else return -1;
        });

        ratingOrder = "desc";
      } else {
        showingMovies = showingMovies.sort(function (a, b) {
          if (a.ratings.average >= b.ratings.average) return 1;
          else return -1;
        });

        ratingOrder = "asc";
      }
    }

    populateMovieList();
  });
  //end of tab features

  const leftMovieDetailBlock = document.querySelector("#leftBlock");
  const rightMovieDetailBlock = document.querySelector("#rightBlock");

  //Shows the loading symbol and fetches for the movie detail
  function showMovieDetail(id) {
    leftMovieDetailBlock.style.visibility = "hidden";
    rightMovieDetailBlock.style.visibility = "hidden";

    posterElement.classList.add("loadingSymbol");
    posterElement.setAttribute("src", loadingSymbolURL);

    showDetailPage();

    fetchMovieDetail(id);
  }

  //To fetch for the movie details, then populate the movie detail page
  function fetchMovieDetail(id) {
    fetch(movieDetailURL + id)
      .then(function (response) {
        if (response.ok) {
          return response.json();
        } else {
          return Promise.reject({
            status: response.status,
            statusText: response.statusText,
          });
        }
      })
      .then((data) => {
        populateMovieDetail(data);
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  //Elements to populate movie detail page
  const movieTitleElement = document.querySelector("#movieDetailTitle");
  const releaseDateElement = document.querySelector("#movieDetailReleaseDate");
  const revenueElement = document.querySelector("#movieDetailRevenue");
  const runtimeElement = document.querySelector("#movieDetailRuntime");
  const taglineElement = document.querySelector("#movieDetailTagline");
  const imdbElement = document.querySelector("#movieDetailIMDBLink");
  const tmdbElement = document.querySelector("#movieDetailTMDBLink");

  const companiesListElement = document.querySelector("#companiesList");
  const countriesListElement = document.querySelector("#countriesList");
  const keywordsListElement = document.querySelector("#keywordsList");
  const genresListElement = document.querySelector("#genresList");

  const posterElement = document.querySelector("#movieDetailPoster");
  const largerPosterElement = document.querySelector(
    "#largerMovieDetailPoster"
  );

  let speakTitleText = "";

  function populateMovieDetail(movie) {
    movieTitleElement.innerHTML = movie.title;
    releaseDateElement.innerHTML = "Release Date: " + movie.release_date;

    revenueElement.innerHTML = "Revenue: " + revenueString(movie.revenue);

    runtimeElement.innerHTML = "Runtime: " + runtimeString(movie.runtime);
    taglineElement.innerHTML = "Tagline: " + movie.tagline;

    imdbElement.setAttribute("href", imdbURL + movie.imdb_id);
    imdbElement.textContent = imdbURL + movie.imdb_id;

    tmdbElement.setAttribute("href", imdbURL + movie.tmdb_id);
    tmdbElement.textContent = imdbURL + movie.tmdb_id;

    companiesListElement.innerHTML = "";

    if (movie.production.companies != null) {
      for (let companies of movie.production.companies) {
        let li = document.createElement("li");
        li.textContent = companies.name;
        companiesListElement.appendChild(li);
      }
    }

    countriesListElement.innerHTML = "";

    if (movie.production.countries != null) {
      for (let country of movie.production.countries) {
        let li = document.createElement("li");
        li.textContent = country.name;
        countriesListElement.appendChild(li);
      }
    }

    keywordsListElement.innerHTML = "";

    if (movie.details.keywords != null) {
      for (let keyword of movie.details.keywords) {
        let li = document.createElement("li");
        li.textContent = keyword.name;
        keywordsListElement.appendChild(li);
      }
    }

    genresListElement.innerHTML = "";

    if (movie.details.genres != null) {
      for (let genre of movie.details.genres) {
        let li = document.createElement("li");
        li.textContent = genre.name;
        genresListElement.appendChild(li);
      }
    }

    crewListElement.innerHTML = "";

    if (movie.production.crew != null) {
      let sortedCrew = movie.production.crew.slice();

      sortedCrew.sort(function (a, b) {
        if (a.department == b.department) return a.name.localeCompare(b.name);
        else return a.department.localeCompare(b.department);
      });

      for (let crew of sortedCrew) {
        generateCrewRow(crew);
      }
    }

    castListElement.innerHTML = "";

    if (movie.production.cast != null) {
      let sortedCast = movie.production.cast.slice();

      sortedCast.sort(function (a, b) {
        if (a.order >= b.order) return 1;
        else return 0;
      });

      for (let cast of sortedCast) {
        generateCastRow(cast);
      }
    }

    speakTitleText = movie.title;

    posterElement.setAttribute("src", posterURL + "w342" + movie.poster);
    largerPosterElement.setAttribute("src", posterURL + "w500" + movie.poster);
    posterElement.classList.remove("loadingSymbol");

    leftMovieDetailBlock.style.visibility = "visible";
    rightMovieDetailBlock.style.visibility = "visible";
  }

  //Functions to format html strings
  function runtimeString(runtime) {
    let runtimeHours = Math.floor(runtime / 60).toFixed(0);
    let runtimeMinutes = runtime - runtimeHours * 60;

    return runtimeHours + "h " + runtimeMinutes + "m";
  }

  function revenueString(revenue) {
    return new Intl.NumberFormat("en-us", {
      style: "currency",
      currency: "USD",
    }).format(revenue);
  }

  //To populate the crew rows
  const crewListElement = document.querySelector("#crewListContent");

  function generateCrewRow(crew) {
    let div = document.createElement("div");
    div.classList.add("contentRow");

    let department = document.createElement("span");
    department.textContent = crew.department;
    div.appendChild(department);

    let job = document.createElement("span");
    job.textContent = crew.job;
    div.appendChild(job);

    let name = document.createElement("span");
    name.textContent = crew.name;
    div.appendChild(name);

    crewListElement.appendChild(div);
  }

  //To populate the cast rows
  const castListElement = document.querySelector("#castListContent");

  function generateCastRow(cast) {
    let div = document.createElement("div");
    div.classList.add("contentRow");

    let character = document.createElement("span");
    character.textContent = cast.character;
    div.appendChild(character);

    let emptySpan = document.createElement("span");
    div.appendChild(emptySpan);

    let name = document.createElement("span");
    name.textContent = cast.name;
    div.appendChild(name);

    castListElement.appendChild(div);
  }

  //Elements that represent the tabs and what happens when clicked
  const crewTab = document.querySelector("#crewTab");
  const castTab = document.querySelector("#castTab");

  crewTab.addEventListener("click", function () {
    crewList.style.display = "block";
    castList.style.display = "none";

    castTab.classList.remove("selected");
    crewTab.classList.add("selected");
  });

  castTab.addEventListener("click", function () {
    crewList.style.display = "none";
    castList.style.display = "block";

    crewTab.classList.remove("selected");
    castTab.classList.add("selected");
  });

  //JS code URL: https://www.w3schools.com/howto/howto_css_modals.asp

  // Get the modal
  var modal = document.getElementById("largerPosterModel");

  // Get the button that opens the modal
  var poster = document.getElementById("movieDetailPoster");

  // Get the <span> element that closes the modal
  var close = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  poster.addEventListener("click", function () {
    modal.style.display = "block";
  });

  // When the user clicks on <span> (x), close the modal
  close.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // When the user clicks anywhere outside of the modal, close it
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });

  /*End imported JS code*/

  //Functions to hold the filter block function of hiding and appearing
  const filterCloseButton = document.querySelector("#filterCloseButton");
  const asideFilterBlock = document.querySelector("#asideFilterBlock");
  const h1asideFilterBlock = document.querySelector("#asideFilterBlock h1");

  filterCloseButton.addEventListener("click", function () {
    if (asideFilterBlock.classList.contains("closeBox")) {
      asideFilterBlock.classList.remove("closeBox");
      defaultSection.classList.remove("asideClose");
      h1asideFilterBlock.innerHTML = "<";
    } else {
      asideFilterBlock.classList.add("closeBox");
      defaultSection.classList.add("asideClose");
      h1asideFilterBlock.innerHTML = ">";
    }
  });

  //Function to speak the movie title
  function speakTitle(title) {
    const utterance = new SpeechSynthesisUtterance(title);
    speechSynthesis.speak(utterance);
  }

  //Function to close the detail page
  const closeDetailPageButton = document.querySelector(
    "#closeDetailPageButton"
  );

  closeDetailPageButton.addEventListener("click", function () {
    closeDetailPage();
  });
});
