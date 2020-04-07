<?php ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>COMP 3512 Assign1</title>

    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="hero-image">
        <section id="homeSection">
            <div id="movieBrowerBox">
                <center>
                    <h2 id="newAcctTitle">Create An Account</h2>
                </center>
                <div id="newUserForm">
                    <form method="POST" action="apis\register-user.php">
                        <div>
                            <label for="emailInput">Email Address</label>
                            <input type="text" id="emailInput" required>
                        </div>
                        <div>
                            <label for="passwordInput">Password</label>
                            <input type="password" id="passwordInput" required>
                        </div>
                        <div>
                            <label for="passwordConfirm">Confirm</label>
                            <input type="password" id="passwordConfirm">
                        </div>
                        <div>
                            <button id="newUserSubmit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
            <center id="heroImageCredit">
                Hero Image Credit:
                <a href="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80">
                    Link
                </a>
            </center>
        </section>

</body>
<script src="js/index.js"></script>

</html>