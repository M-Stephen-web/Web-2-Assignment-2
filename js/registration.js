document.addEventListener("DOMContentLoaded", function() {

    let firstname = document.querySelector("#first");
    let lastname = document.querySelector("#lname");
    let city = document.querySelector("#city");
    let country = document.querySelector("#country");
    let email = document.querySelector("#email");
    let pass = document.querySelector("#password")
    let confirm = document.querySelector("#confirm");
    let submit = document.querySelector("#submit");

    let firsterror = document.querySelector("#firsterror");
    let lasterror = document.querySelector("#lasterror");
    let cityerror = document.querySelector("#cityerror");
    let countryerror = document.querySelector("#countryerror");
    let emailerror = document.querySelector("#emailerror");
    let passerror = document.querySelector("#passerror");
    let confirmerror = document.querySelector("#confirmerror");
    
    
    //Event listeners that create alerts when the error exclamations are clicked
    
    firsterror.addEventListener('click', function() {
        alert("Please enter your first name");
    });

    lasterror.addEventListener('click', function() {
        alert("Please enter your surname");
    });

    cityerror.addEventListener('click', function() {
        alert("Please enter a city");
    });
    
    countryerror.addEventListener('click', function() {
        alert("Please select a country");
    });

    emailerror.addEventListener('click', function() {
        alert("Please enter a valid email");
    });

    passerror.addEventListener('click', function() {
        alert("Password must be at least 8 characters long");
    });

    confirmerror.addEventListener('click', function() {
        alert("Passwords do not match");
    });
    
    
   //Event listeners that remove the error exclamation when the input is changed
    
   firstname.addEventListener('change', function() {
        firsterror.style.display = "none";
    });

    lastname.addEventListener('change', function() {
        lasterror.style.display = "none";
    });
    
    city.addEventListener('change', function() {
        cityerror.style.display = "none";
    });

    country.addEventListener('change', function() {
        countryerror.style.display = "none";
    });

    email.addEventListener('change', function() {
        emailerror.style.display = "none";
    });

    pass.addEventListener('change', function() {
        passerror.style.display = "none";
    });
    
    confirm.addEventListener('change', function() {
        confirmerror.style.display = "none";
    });


    //Form validation on click of the submit button
    
    submit.addEventListener('click', function() {
        if (firstname.value == ""){
            firsterror.style.display = "block";
            return;
        }

        if (lastname.value == ""){
            lasterror.style.display = "block";
            return;
        }

        if (city.value == ""){
            cityerror.style.display = "block";
            return;
        }
        
        if (country.value == "default"){
            countryerror.style.display = "block";
            return;
        }

        if (validateEmail(email) == false){
            return;
        }
        
       
        if (confirm.value != password.value){
            confirmerror.style.display = "block";
            return;
        }
            
        else {
            passerror.style.display = "block";
            return;
        }
    });

});

validateEmail = (email) => {
    let eformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.value.match(eformat)){
        return true;
    }
    else{
        emailerror.style.display = "block";
        return false;
    }
}
