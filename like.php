<?php
include 'variables.php';

session_start();

$currentuser = $_SESSION['userid'];
$postid = $_POST['like'];
$redirect = $_POST['link'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1,$postid);
  $stmt->bindParam(2,$currentuser);
  $stmt->execute();

  $rowcount = 0;

  while($row = $stmt->fetch())
  {
    $rowcount++;
  }



  if($rowcount != 0) //liked post
  {
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
      header("refresh:0.1;url=$redirect");
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      echo "<br>Try again!";
      echo "<br>Redirecting in three seconds...";
      // header("refresh:3;url=profile.php");
    }
  }
  else
  {
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO `post_like_table`(`Post_ID`, `Liked_User_ID`) VALUES ('$postid', '$currentuser')";
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
  }
}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "<br>Try again!";
    echo "<br>Redirecting in three seconds...";
    // header("refresh:3;url=profile.php");
}



?>