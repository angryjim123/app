<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav2.php'; ?>
    <section id = 'sectionfeed'>
    <?php
      session_start();

        $sql = "SELECT `post`.*, `user`.`Account_Name`, `user`.`Profile_Picture` FROM `follower_table` JOIN `post` ON `follower_table`.`Followed_User_ID` = `post`.`User_ID`
        LEFT JOIN `user` ON `user`.`User_ID` = `follower_table`.`Followed_User_ID`
        WHERE `follower_table`.`Following_User_ID` = ?
        ORDER BY `post`.`Post_Created_Datetime` DESC";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$_SESSION['userid']);
          $stmt->execute();

          while($row = $stmt->fetch())
          {
            $postid = $row['Post_ID'];
            $image = $row['Image'];
            $desc = $row['Description'];
            $create = $row['Post_Created_Datetime'];
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $userrid = $row['User_ID'];

            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $sql2 = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

              $stmt2 = $conn->prepare($sql2);
              $stmt2->bindParam(1,$postid);
              $stmt2->bindParam(2,$_SESSION['userid']);
              $stmt2->execute();

              $rowcount = 0;

              while($row = $stmt2->fetch())
              {
                $rowcount++;
              }
            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                echo "<br>Try again!";
                echo "<br>Redirecting in three seconds...";
                // header("refresh:3;url=profile.php");
            }

            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $sql4 = "SELECT COUNT(`Like_ID`) FROM `post_like_table` WHERE `Post_ID` = ?";

              $stmt4 = $conn->prepare($sql4);
              $stmt4->bindParam(1,$postid);
              $stmt4->execute();
              $likedamount = $stmt4->fetch();
              if(gettype($likedamount) == "boolean") //no likes
              {
                $likedamount = 0;
              }
              else
              {
                $likedamount = $likedamount[0];
              }
            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                echo "<br>Try again!";
                echo "<br>Redirecting in three seconds...";
                // header("refresh:3;url=profile.php");
            }

            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $sql5 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

              $stmt5 = $conn->prepare($sql5);
              $stmt5->bindParam(1,$postid);
              $stmt5->execute();

              $commentamount = $stmt5->fetch();
              if(gettype($commentamount) == "boolean") //no likes
              {
                $commentamount = 0;
              }
              else
              {
                $commentamount = $commentamount[0];
              }


            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                echo "<br>Try again!";
                echo "<br>Redirecting in three seconds...";
                // header("refresh:3;url=profile.php");
            }

            echo "<form action = 'clickaccount.php' method = 'POST'>
                    <div id = '$postid'>
                      <img id = 'profileimage' src = '$profilepicture'>
                      <button id = 'buttonlink' name = 'acc' type = 'submit' value = '$userrid''><h4 id = 'profileuserfeed'>$accountname</h4></button>
                    </div>
                  </form>
                      <br>
                    <div id = 'feedimagediv'>
                      <img id = 'feedimage' src = '$image'>
                    </div>";

                  if($rowcount == 0) //not liked
                  {
                    echo "<form action = 'feedlike.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Like</h4></button>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
                  }
                  else //liked
                  {
                    echo "<form action = 'feedlike.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
                  }

                  echo "<form action = 'commentfeed.php' method = 'POST'>
                    <button id = 'buttoncomment' name = 'comment' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Comment</h4></button>
                  </form>";

                  echo "<br>
                    <div>
                      <h3 id = 'text'><strong>$accountname</strong> $desc</h3>
                      <h3 id = 'text'>$create</h3>
                    </div>
                  <br>
                  ";
          }
        }
        catch(PDOException $e)
        {
           echo "Connection failed: " . $e->getMessage();
           echo "<br>Try again!";
           echo "<br><a href ='homepage.php'>Home</a>";
        }

        echo "<br><br>";

        $sql = null;
        $conn = null;
        // header("refresh:3;url=welcome.php");
    ?>
    </section>
  </body>
</html>