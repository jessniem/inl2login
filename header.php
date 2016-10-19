<!DOCTYPE html>
<html lang="se">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans%7CRuslan+Display" rel="stylesheet">
  <link rel="stylesheet" href="./style/normalize.css">
  <link rel="stylesheet" href="./style/style.css">
</head>

<body>
  <nav>
    <div class="container" id="menu">

      <?php
      if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
        ?>
        <div><a href="profile.php">Profil</a></div>
        <div><a href="logout.php">Logga ut</a></div>
        <?php
      } else {
        ?>
        <div><a href="register.php">Registrera dig</a></div>
        <div><a href="login.php">Logga in</a></div>
        <?php
      }
       ?>


    </div>
  </nav>
