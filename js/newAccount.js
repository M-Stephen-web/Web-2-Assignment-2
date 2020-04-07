document.addEventListener("DOMContentLoaded", (e) => {
  let emailInput = document.querySelector("#emailInput");
  let passwordInput = document.querySelector("#passwordInput");
  let passwordConfirm = document.querySelector("#passwordConfirm");

  emailInput.addEventListener("change", (e) => {
    let emailRegex = "^w+@[a-zA-Z_]+?.[a-zA-Z]{2,3}$";
    let passwordRegex = "";
    let emailResult = emailRegex.test(emailInput.value);
    let passwordResult = passwordRegex.test(pass);
  });
});
