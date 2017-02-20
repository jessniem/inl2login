<?php
session_start();
require_once "functions.php";

// create session for LOGGED IN users
if (isset($_POST["username"]) && isset($_POST["password"]) ) {
    // connection to db
    connectDB();

    $user = sanitizeMySql($conn, $_POST["username"]);
    $pass = sanitizeMySql($conn, $_POST["password"]);
    $hPass = hashPassword($pass);
    // Check password
    $get_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$user'"));
    $password = $get_user["password"];
    if ($hPass == $password) {
        // create sessions & cookie
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $user;
        $_SESSION["userid"] = $get_user["id"];
        $_SESSION["firstname"] = $get_user["firstname"];
        $_SESSION["profilepic"] = $get_user["profilepic_url"];
        setcookie("username", $user, time() + (60*60*7*24)); //stay logged in for a week
    } else {
      $_SESSION["wrong_pw"] = true;
      header ("Location: login.php");
      exit;
    }
    // close db connections

    $conn->close();
}

header ("Location: profile.php");

?>
