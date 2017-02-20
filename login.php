<?php
session_start();
require_once "functions.php";
include_once "./includes/header.php";
?>

<h1>Header</h1>

    <div class="login-window">
    <?php
    // logged out message
    if (isset($_SESSION["logged_out"]) && $_SESSION["logged_out"] == true ) { ?>
        <p>Du är utloggad!<p> <?php
        //unset($_SESSION["logged_out"]);
    }
    // wrong password message
    if (isset($_SESSION["wrong_pw"]) && $_SESSION["wrong_pw"] == true ) { ?>
        <p class="error">Fel användarnamn/lösenord!</p> <?php
        unset($_SESSION["wrong_pw"]);
    }
    // email already registered message
    if (isset($_SESSION["email_registered"]) && $_SESSION["email_registered"] == true) { ?>
        <p class="error">Din email-adress är redan registrerad!</p> <?php
        unset($_SESSION["email_registered"]);
    } ?>

    <h2>Logga in</h2>
    <form method="post" action="logincheck.php?login=true">
        Användarnamn: <br>
        <input type="text" name="username" placeholder="email" value=""><br>
        Lösenord: <br>
        <input type="text" name="password" placeholder="lösenord" value=""><br>
        <input type="submit" name="login" value="Logga in" formaction="logincheck.php?login=true">
    </form>
  </div> <!-- /login-window -->

</body>
</html>
