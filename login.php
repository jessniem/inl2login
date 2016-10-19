<?php
session_start();
require_once "functions.php";
include_once "./includes/header.php";
?>

<h1>Header</h1>

  <div class="login-window">
    <?php
    if (isset($_GET["email_registered"]) && $_GET["email_registered"] == true) { ?>
        <p class="error">Din email-adress är redan registrerad!</p> <?php
    }
    if (isset($_GET["logout"]) && $_GET["logout"] == true) { ?>
        <p>Du är utloggad!<p> <?php
    }
     ?>
    <h2>Logga in</h2>
    <form method="post" action="profile.php?loginUser=true">
      Användarnamn: <br>
      <input type="text" name="username" placeholder="email" value=""><br>
      Lösenord: <br>
      <input type="text" name="password" placeholder="lösenord" value=""><br>
      <input type="submit" name="login" value="Logga in" formaction="profile.php">
  </div> <!-- /login-window -->

</body>
</html>
