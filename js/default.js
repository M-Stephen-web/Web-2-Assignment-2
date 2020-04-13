//All URLS needed
const movieListURL = "http://phseguin.ca/apis/movies-all.php";
const posterURL = "https://image.tmdb.org/t/p/";
const loginURL = "http://phseguin.ca/apis/login-user.php";
const registerURL = "http://phseguin.ca/apis/register-user.php";
const loadingSymbolURL = "./images/loadingSymbol.gif";

//Global variables to hold data
let movies = []; //To hold all movies that are sorted by title
let showingMovies = []; //To hold all movies that are currently being displayed

document.addEventListener("DOMContentLoaded", (e) => {
  //To fetch all the movies
  fetchMovies();
  function fetchMovies() {
    fetch(movieListURL)
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
        if (data.data) {
          updateStorage(data.data); //Place movies into local storage

          movies = data.data; //Set global variable

          movies = sortMovies(movies); //Reset global variable with sorted movies

          showingMovies = movies.slice(); //Set global variable

          populateDefaultView();
        } else {
          alert(data.errorMessage);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  }

  //Shows default page
  function showDefaultPage() {
    matchesRowsBlock.style.display = "none";
    loadingSymbolDefaultView.style.display = "block";

    let storage = retieveStorage();

    //Checks if movies were saved to storage
    if (storage.length > 0) {
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

  //To retireve the movie data locally
  function retieveStorage() {
    return JSON.parse(localStorage.getItem("movies")) || [];
  }

  //To update the movie data to local storage
  function updateStorage(data) {
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

  //Event delgation for when an image, title or button is clicked for a movie, that movie is shown in the detail view
  matchesRowsBlock.addEventListener("click", function (e) {
    if (e.target) {
      if (e.target.parentNode.getAttribute("movieId") != null) {
        document.location.href =
          "detail.php?movieId=" + e.target.parentNode.getAttribute("movieId");
      }
    }
  });

  //To generate each row of showingMovies
  function generateMatchRow(movie) {
    let div = document.createElement("div");
    div.classList.add("matchesRow");
    div.setAttribute("movieId", movie.id);

    let img = document.createElement("img");
    img.setAttribute("src", posterURL + "w92" + movie.poster_path);
    div.appendChild(img);

    let title = document.createElement("label");
    title.classList.add("title");
    title.textContent = movie.title;
    div.appendChild(title);

    let year = document.createElement("span");
    year.textContent = movie.release_date.substring(0, 4);
    div.appendChild(year);

    let rating = document.createElement("span");
    rating.textContent = movie.vote_average;
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
          sortedMovies[i].vote_average > ratingTypeValueBelow.value
        ) {
          delete sortedMovies[i];
        }
      }

      //To filter by rating after
      if (ratingTypeRadioAbove.checked) {
        if (
          sortedMovies[i] &&
          sortedMovies[i].vote_average < ratingTypeValueAbove.value
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
              sortedMovies[i].vote_average <= ratingTypeValueBetweenMax.value &&
              sortedMovies[i].vote_average >= ratingTypeValueBetweenMin.value
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
          if (a.vote_average >= b.vote_average) return 1;
          else return -1;
        });

        ratingOrder = "desc";
      } else {
        showingMovies = showingMovies.sort(function (a, b) {
          if (a.vote_average >= b.vote_average) return 1;
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

  /*End imported JS code*/

  //Functions to hold the filter block function of hiding and appearing
  const filterCloseButton = document.querySelector("#filterCloseButton");
  const asideFilterBlock = document.querySelector("#asideFilterBlock");
  const asideFilterButton = document.querySelector(
    "#asideFilterBlock #filterCloseButton"
  );

  filterCloseButton.addEventListener("click", function () {
    if (asideFilterBlock.classList.contains("closeBox")) {
      asideFilterBlock.classList.remove("closeBox");
      defaultSection.classList.remove("asideClose");
      asideFilterButton.innerHTML = "<<";
    } else {
      asideFilterBlock.classList.add("closeBox");
      defaultSection.classList.add("asideClose");
      asideFilterButton.innerHTML = ">>";
    }
  });
});
