<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "1234567890";
$dbname = "photo";

$commentid = $_POST['commentid'];
$redirect = $_POST['link'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM `comment_table` WHERE `Comment_ID` = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1,$commentid);
  $stmt->execute();

  header("refresh:0.1;url=$redirect");

}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "<br>Try again!";
    echo "<br>Redirecting in three seconds...";
    // header("refresh:3;url=profile.php");
}

?>