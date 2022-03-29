<?php

$servername = "us-cdbr-east-05.cleardb.net";
$username = "be4c22fe1bd451";
$password = "0128e3d6";
$database = "heroku_f4c1f1b843cd581";

header("refresh:0.1;url='welcome.php'");


try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "hi";
  // header("refresh:0.1;url=followerspage.php");
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo "<br>Try again!";
  echo "<br>Redirecting in three seconds...";
  header("refresh:3;url=followerspage.php");
}

?>