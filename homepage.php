<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <section id = 'sectionfeed'>
    <?php
      session_start();

        //get all following
        $sql = "SELECT `post`.*, `user`.`Account_Name`, `user`.`Profile_Picture` FROM `follower_table` JOIN `post` ON `follower_table`.`Followed_User_ID` = `post`.`User_ID`
        LEFT JOIN `user` ON `user`.`User_ID` = `follower_table`.`Followed_User_ID`
        WHERE `follower_table`.`Following_User_ID` = ?
        ORDER BY `post`.`Post_Created_Datetime` DESC";

        //get all posts from following
        $sql2 = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

        //get all like counts
        $sql3 = "SELECT COUNT(`Like_ID`) FROM `post_like_table` WHERE `Post_ID` = ?";

        //get all comment counts
        $sql4 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

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
            ////////////////////////////////////////////////////////////////////
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(1,$postid);
            $stmt2->bindParam(2,$_SESSION['userid']);
            $stmt2->execute();

            $rowcount = 0;

            while($row = $stmt2->fetch())
            {
              $rowcount++;
            }
            ////////////////////////////////////////////////////////////////////
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(1,$postid);
            $stmt3->execute();
            $likedamount = $stmt3->fetch();

            if(gettype($likedamount) == "boolean") //no likes
            {
              $likedamount = 0;
            }
            else
            {
              $likedamount = $likedamount[0];
            }
            ////////////////////////////////////////////////////////////////////
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bindParam(1,$postid);
            $stmt4->execute();
            $commentamount = $stmt4->fetch();

            if(gettype($commentamount) == "boolean") //no likes
            {
              $commentamount = 0;
            }
            else
            {
              $commentamount = $commentamount[0];
            }
            ////////////////////////////////////////////////////////////////////
            //profile image + account name + post
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

            //not liked
            if($rowcount == 0)
            {
              echo "<form action = 'like.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Like</h4></button>
                      <input type='hidden' name='link' value='homepage.php#$postid'>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
            }
            //liked
            else
            {
              echo "<form action = 'like.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                      <input type='hidden' name='link' value='homepage.php#$postid'>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
            }
            //comment button
            echo "<form action = 'commentfeed.php' method = 'POST'>
                    <button id = 'buttoncomment' name = 'comment' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Comment</h4></button>
                  </form>";

            //description + post created date
            echo "<br>
                  <div>
                    <h3 id = 'text'><strong>$accountname</strong> $desc</h3>
                    <h3 id = 'text'>$create</h3>
                  </div>
                  <br>";
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
    ?>
    </section>
  </body>
</html>