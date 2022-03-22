<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'variables.php'; ?>
    <?php
      session_start();

      //upload pictures
      $uploaddir = "photos/";
      $uploaddir = str_replace('/', '\\', $uploaddir);
      $uploadfile = $uploaddir . basename($_FILES['filename']['name']);

      if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploadfile))
      {
          $picture = $uploaddir . $_FILES['filename']['name'];
      }

      //upload descriptions
      $description = $_POST['description'];
      if($description == "")
      {
        $description = NULL;
      }

      $description = addslashes($description);
      $picture = addslashes($picture);
      $userid = $_SESSION['userid'];

      $sql = "INSERT INTO `post`(`User_ID`, `Description`, `Image`) VALUES ('$userid', '$description', '$picture')";

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec($sql);
        echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Posted Successfully...</h1>
              <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";
        //////////////////////////////////////////////////////////////////////////////////////////
        $sql = null;
        $conn = null;
        //////////////////////////////////////////////////////////////////////////////////////////
        header("refresh:3;url=post.php");
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        echo "<br>Try again!";
        echo "<br>Redirecting in three seconds...";
        header("refresh:3;url=post.php");
      }
    ?>
  </body>
</html>