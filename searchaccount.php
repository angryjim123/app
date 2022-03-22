<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <section id = "sectionfeed">
      <?php
        session_start();
        $searchaccount = $_POST['searchaccount'];
        $searchaccount = "%" . $searchaccount . "%";
        $searchaccount = addslashes($searchaccount);

        $rowcount = 0;

        $sql = "SELECT * FROM `user` WHERE `Account_Name` LIKE ?";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$searchaccount);
          $stmt->execute();

          echo "<form action = 'clickaccount.php' method = 'POST'>";

          //display accounts in query
          while($row = $stmt->fetch())
          {
            $rowcount++;
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $userid = $row['User_ID'];

            if($_SESSION['accountname'] == $accountname)
            {
              //not displaying your own account.
            }
            else
            {
              //display account
              echo "<div>
                      <img id = 'profileimage' src = '$profilepicture'>
                      <button id = 'buttonsearch' name = 'acc' type = 'submit' value = '$userid'><h4 id ='profilesearch'>$accountname</h4></button>
                    </div>
                    ";
            }
          }
          if($rowcount == 0)
          {
            echo "<h1 style = 'color:#ffa31a;text-align:center'>No Account Found</h1>";
          }

          echo "</form><br><br>";

          $sql = null;
          $conn = null;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
            echo "<br>Try again!";
            echo "<br><a href ='signup.html'>Sign Up</a>";
        }
      ?>
    </section>
  </body>
</html>