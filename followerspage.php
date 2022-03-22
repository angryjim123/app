<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <header id = "homeheader">
        <div id = "headerleft">
          <a href="homepage.php">
           <img alt="Logo" src="photos/jeremy.jpg" id = "logoimage">
         </a>
       </div>
       <div id = "headermiddle">
          <a href ="homepage.php" id = "normal">Feed</a>
          <a href ="post.php" id = "normal">Post</a>
          <a href ="search.php" id = "normal">Search</a>
          <a href ="profile.php" id = "ph">Profile</a>
        </div>
        <div id = "headerright">
          <a href="logout.php">
           <img alt="Logout" src="photos/jeffrey.jpg" id = "logoutimage">
         </a>
        </div>
    </header>
    <section id = "sectionfeed">
      <?php

        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "1234567890";
        $dbname = "photo";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "SELECT `follower_table`.*,`user`.`Account_Name`,`user`.`Profile_Picture` FROM `follower_table` LEFT JOIN `user` ON `follower_table`.`Following_User_ID`=`user`.`User_ID` WHERE `follower_table`.`Followed_User_ID`=?";

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$_SESSION['temp']);
          $stmt->execute();

          $rowcount = 0;

          echo "All Followers";

          while($row = $stmt->fetch())
          {
            $rowcount++;
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $userid = $row['Following_User_ID'];

            echo "<form action = 'clickaccount.php' method = 'POST'>
                    <div>
                      <img id = 'profileimage' src = '$profilepicture'>
                      <button id = 'buttonsearch' name = 'acc' type = 'submit' value = '$userid'><h4 id ='profilesearch'>$accountname</h4></button>
                    </div>
                  </form>
                  <form action = 'deletefollowers.php' method = 'POST'>
                  <div>
                    <button id = 'buttondelete' name = 'deleteacc' type = 'submit' value = '$userid'><h4 id ='profilesearch'>Remove</h4></button>
                  </div>
                  </form>
                  ";
          }

          echo "<br><br>";

          $sql = null;
          $conn = null;
          // header("refresh:3;url=welcome.php");
          }

          catch(PDOException $e) {
           echo "Connection failed: " . $e->getMessage();
           echo "<br>Try again!";
           echo "<br><a href ='homepage.php'>Home</a>";
         }

      ?>
    </section>
  </body>
</html>