<?php

session_start();

$servername = "us-cdbr-east-05.cleardb.net";
$username = "bf95d530c89c14";
$password = "396f81cc";
$dbname = "heroku_a454372d378d402";

$currentuser = $_SESSION['userid'];
$postid = $_POST['like'];
$previd = $_POST['previd'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1,$postid);
  $stmt->bindParam(2,$currentuser);
  $stmt->execute();

  $sql = null;
  $conn = null;
  header("refresh:0.1;url=likedposts.php#$previd");
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo "<br>Try again!";
  echo "<br>Redirecting in three seconds...";
  // header("refresh:3;url=profile.php");
}

?>