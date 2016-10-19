<?php

/**
* The function create connection to db, utf8_encoded.
*
* @return string Returns error message if connection not ok.
**/
function connectDB() {
  global $conn;
  $conn = new mysqli("localhost", "root", "root", "inl2");
  $conn->set_charset("utf8");

  if ($conn->connect_errno) {
      return "<p>Failed to connect to database";
      die();
  }
}

/**
* The function creates a hashed and salted password.
*
* @param string $password.
* @return string $hashPw Returns a hashed and salted password.
**/
function hashPassword($password){
  global $hashPw;
  $salt1 = "/%7c";
  $salt2 = "&jm!s@!";
  $hashPw = hash('ripemd128', "$salt1$password$salt2");
  return $hashPw;
}

/**
* The function removes unwanted slashes and HTML from user input.
*
* @param string $var The string from the user input.
* @return string $var Return a safe sanitized string.
**/
function sanitizeString($var) {
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}

/**
* The function prevent escape characters to be injected in the strings presented to MySQL.
*
* @param string $var The string from the user input. TODO ????
* @param string $conn TODO ???
* @return string $var Return a safe sanitized string.
**/
function sanitizeMySql($conn, $var) {
  $var = $conn->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
}

 ?>
