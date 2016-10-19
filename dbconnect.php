<?php

$conn = new mysqli("localhost", "root", "root", "inl2");
$conn ->set_charset("utf8");

if ($conn->connect_errno) {
  echo "<p>Failed to connect to database";
  die();
}

 ?>
