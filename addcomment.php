<?php

session_start();

$servername = "us-cdbr-east-05.cleardb.net";
$username = "bf95d530c89c14";
$password = "396f81cc";
$dbname = "heroku_a454372d378d402";

$userid = $_SESSION['userid'];
$postid = $_POST['postid'];
$comment = $_POST['comment'];
$redirect = $_POST['link'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT INTO `comment_table`(`User_ID`, `Post_ID`, `Comment`) VALUES ('$userid', '$postid', '$comment')";
  $conn->exec($sql);

  $sql = null;
  $conn = null;
  //////////////////////////////////////////////////////////////////////////////////////////
  header("refresh:0.1;url=$redirect");
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo "<br>Try again!";
  echo "<br>Redirecting in three seconds...";
  // header("refresh:3;url=profile.php");
}
?>