<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <?php

    $servername = "us-cdbr-east-05.cleardb.net";
    $username = "bf95d530c89c14";
    $password = "396f81cc";
    $dbname = "heroku_a454372d378d402";

    $link = $_POST['avatar_url'];

    echo $link;

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO `test_table`(`test_link`) VALUES ('$link')";

      $conn->exec($sql);

      $sql = null;
      $conn = null;
      // header("refresh:0.1;url=followerspage.php");
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      echo "<br>Try again!";
      echo "<br>Redirecting in three seconds...";
      // header("refresh:3;url=index.php");
    }

    ?>
  </body>
</html>