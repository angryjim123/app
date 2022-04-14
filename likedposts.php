<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <!-- where all the following posts will be here. -->
    <?php
      session_start();
        echo "<section id = 'sectionfeed'>";

        $servername = "us-cdbr-east-05.cleardb.net";
        $username = "bf95d530c89c14";
        $password = "396f81cc";
        $dbname = "heroku_a454372d378d402";

        $sql = "SELECT `post`.*, `user`.`Account_Name`, `user`.`Profile_Picture` FROM `post_like_table` JOIN `post` ON `post_like_table`.`Post_ID` = `post`.`Post_ID`
        LEFT JOIN `user` ON `user`.`User_ID` = `post`.`User_ID`
        WHERE `Liked_User_ID` = ?
        ORDER BY `post`.`Post_Created_Datetime` DESC;";

        $sql3 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$_SESSION['userid']);
          $stmt->execute();

          $arr = array("");
          $prev;

          while($row = $stmt->fetch())
          {
            $postid = $row['Post_ID'];
            $image = $row['Image'];
            $desc = $row['Description'];
            $create = $row['Post_Created_Datetime'];
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $userrid = $row['User_ID'];
            array_push($arr,$postid);
            $num = count($arr)-2;
            $prev = $arr[$num];

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

            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(1,$postid);
            $stmt3->execute();
            $commentamount = $stmt3->fetch();

            if(gettype($commentamount) == "boolean") //no likes
            {
              $commentamount = 0;
            }
            else
            {
              $commentamount = $commentamount[0];
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
                    </div>
                    <form action = 'likedpostlike.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                      <input type='hidden' name='previd' value='$prev'/>
                    </form>
                    <form action = '#####################' method = 'POST'>
                      <button id = 'buttoncomment' name = 'comment' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Comment</h4></button>
                    </form>
                    <br>
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