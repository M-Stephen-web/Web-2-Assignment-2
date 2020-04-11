//All URLs needed
const posterURL = "https://image.tmdb.org/t/p/";
const addFavUrl = "http://phseguin.ca/apis/favorite-create.php?movieId=";
const movieDetailURL = "http://phseguin.ca/apis/movies-brief.php";
const loginURL = "http://phseguin.ca/apis/login-user.php";
const registerURL = "http://phseguin.ca/apis/register-user.php";
const imdbURL = "https://www.imdb.com/title/";
const tmdbURL = "https://www.themoviedb.org/movie/";
const loadingSymbolURL = "./images/loadingSymbol.gif";

document.addEventListener("DOMContentLoaded", (e) => {
  //Shows the loading symbol and fetches for the movie detail
  function showMovieDetail(id) {
    leftMovieDetailBlock.style.visibility = "hidden";
    rightMovieDetailBlock.style.visibility = "hidden";
    movieId = id;
    posterElement.classList.add("loadingSymbol");
    posterElement.setAttribute("src", loadingSymbolURL);

    showDetailPage();

    fetchMovieDetail(id);
  }
  //Element representing the speech button to speak the movie title
  const favButton = document.querySelector("#addFavButton");

  favButton.addEventListener("click", (e) => {
    fetch(addFavUrl + movieId, {
      method: "GET",
    })
      .then((response) => {
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
        if (data.errorMessage) {
          alert(data.errorMessage);
        }
      });
  });

  //To fetch for the movie details, then populate the movie detail page
  function fetchMovieDetail(id) {
    fetch(movieDetailURL + "?movieId=" + id)
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
        populateMovieDetail(data.data);
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

  function populateMovieDetail(movie) {
    console.log(movie);
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

    if (movie.production_companies != null) {
      for (let companies of JSON.parse(movie.production_companies)) {
        let li = document.createElement("li");
        li.textContent = companies.name;
        companiesListElement.appendChild(li);
      }
    }

    countriesListElement.innerHTML = "";

    if (movie.production_countries != null) {
      for (let country of JSON.parse(movie.production_countries)) {
        let li = document.createElement("li");
        li.textContent = country.name;
        countriesListElement.appendChild(li);
      }
    }

    keywordsListElement.innerHTML = "";

    if (movie.keywords != null) {
      for (let keyword of JSON.parse(movie.keywords)) {
        let li = document.createElement("li");
        li.textContent = keyword.name;
        keywordsListElement.appendChild(li);
      }
    }

    genresListElement.innerHTML = "";

    if (movie.genres != null) {
      for (let genre of JSON.parse(movie.genres)) {
        let li = document.createElement("li");
        li.textContent = genre.name;
        genresListElement.appendChild(li);
      }
    }

    crewListElement.innerHTML = "";

    if (movie.crew != null) {
      let sortedCrew = JSON.parse(movie.crew.slice());
      console.log(sortedCrew);

      sortedCrew.sort(function (a, b) {
        if (a.department == b.department) return a.name.localeCompare(b.name);
        else return a.department.localeCompare(b.department);
      });

      for (let crew of sortedCrew) {
        generateCrewRow(crew);
      }
    }

    castListElement.innerHTML = "";

    if (movie.cast != null) {
      let sortedCast = JSON.parse(movie.cast.slice());

      sortedCast.sort(function (a, b) {
        if (a.order >= b.order) return 1;
        else return 0;
      });

      for (let cast of sortedCast) {
        generateCastRow(cast);
      }
    }

    posterElement.setAttribute("src", posterURL + "w342" + movie.poster_path);
    largerPosterElement.setAttribute(
      "src",
      posterURL + "w500" + movie.poster_path
    );
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
});
