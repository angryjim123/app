<!DOCTYPE html>
<html>
  <head>
    <script src="https://app.simplefileupload.com/buckets/0f6ab5fed3a03b1d305d9ac29a4c160a.js"></script>
  </head>
  <body>
    <form method = "POST" action = "testing.php">
      <input type="hidden" name="avatar_url" id="avatar_url" class="simple-file-upload">
      <input id = "submit" type="submit" value="Sign Up" >
    </form>
    <?php

    $servername = "us-cdbr-east-05.cleardb.net";
    $username = "bf95d530c89c14";
    $password = "396f81cc";
    $dbname = "heroku_a454372d378d402";

    // header("refresh:0.1;url='welcome.php'");

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
  </body>
</html>