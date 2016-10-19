<?php session_start();
require_once "functions.php";
include_once "./includes/header.php";
?>

<h1>Header</h1>

<div class="login-window">
  <h2>Registrera dig</h2>
  <form method="post" action="register.php?newUser=true">
    Förnamn: <br>
    <input type="text" name="firstname" placeholder="förnamn" value=""><br>
    Efternamn: <br>
    <input type="text" name="lastname" placeholder="efternamn" value=""><br>
    E-mail: <br>
    <input type="email" name="username" placeholder="email" value=""><br>
    Lösenord: <br>
    <input type="text" name="password" placeholder="lösenord" value=""><br>
    <input type="submit" name="submit" value="Skapa konto">
  </form>

  <?php


  // check that submit is clicked
  if (isset($_POST["submit"]) ) {
      // check for input in all fields
      if (!empty($_POST["firstname"]) &&
          !empty($_POST["lastname"]) &&
          !empty($_POST["username"]) &&
          !empty($_POST["password"]) ) {
              // connect to db
              connectDB();
              // create variables and clean input
              $fn = $_POST["firstname"];
              $firstname = sanitizeMySql($conn, $fn);
              $ln = $_POST["lastname"];
              $lastname = sanitizeMySql($conn, $ln);
              $em = $_POST["username"];
              $username = sanitizeMySql($conn, $em);
              $pw = $_POST["password"];
              //hash password
              hashPassword($pw);

              // get instance of statement
              $statement = $conn->stmt_init();

              $addUser = ("INSERT INTO users VALUES (NULL, '$firstname', '$lastname', '$username', '$hashPw', '')");
              // check the query
              if ($statement->prepare($addUser)) {
                  //$statement->execute;
                  // run the query and add new user to db
                  mysqli_query($conn, $addUser);
                  echo "<p>Användaren registrerad</p>";
                  $_SESSION["logged_in"] = true;
                  //$_SESSION["firstname"] = $firstname;
                  $_SESSION["username"] = $username;
                  //$_SESSION["userid"] = $id;
              } else {
                echo "Tekniskt problem";
              }
              // close statement
              $statement->close();
              // close the db connection TODO är detta rätt???
              // $statement->();
    }
}

   ?>
