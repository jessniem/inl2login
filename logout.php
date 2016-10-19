<?php
session_start();

$_SESSION["logged_in"] = false;
unset($_SESSION["username"]);
unset($_SESSION["userid"]);
unset($_SESSION["profilepic"]);

session_destroy();

//redirect to login page
header ("Location: login.php?logout=true");

 ?>
