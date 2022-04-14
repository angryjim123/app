<?php

session_start();

$servername = "us-cdbr-east-05.cleardb.net";
$username = "bf95d530c89c14";
$password = "396f81cc";
$dbname = "heroku_a454372d378d402";

$userrid = $_POST['deleteacc'];



try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM `follower_table` WHERE `Following_User_ID` = ? AND `Followed_User_ID` = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1,$userrid);
  $stmt->bindParam(2,$_SESSION['userid']);
  $stmt->execute();
  $sql = null;
  $conn = null;
  header("refresh:0.1;url=followerspage.php");
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  echo "<br>Try again!";
  echo "<br>Redirecting in three seconds...";
  header("refresh:3;url=followerspage.php");
}
?>