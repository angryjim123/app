<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "1234567890";
$dbname = "photo";

$userrid = $_POST['followorno'];
$currentuser = $_SESSION['userid'];
$num = substr($userrid,1);
$userrid = $userrid[0];

if($userrid == 'n') //not following yet
{
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO `follower_table`(`Followed_User_ID`, `Following_User_ID`) VALUES ('$num', '$currentuser')";
    $conn->exec($sql);
    $sql = null;
    $conn = null;
    header("refresh:0.1;url=clickaccount.php");
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "<br>Try again!";
    echo "<br>Redirecting in three seconds...";
    header("refresh:3;url=post.php");
  }
}
else //following already
{
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM `follower_table` WHERE `Follower_ID` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$num);
    $stmt->execute();
    $sql = null;
    $conn = null;
    header("refresh:0.1;url=clickaccount.php");
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "<br>Try again!";
    echo "<br>Redirecting in three seconds...";
    header("refresh:3;url=post.php");
  }
}
?>