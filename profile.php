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

        $_SESSION['temp'] = $_SESSION['userid'];
        $accountname = $_SESSION['accountname'];
        $pfp = $_SESSION['profilepicture'];
        $bio = $_SESSION['bio'];
        //get all posts by current user
        $sql = "SELECT `post`.*,`user`.`Account_Name`,`user`.`Profile_Picture` FROM `post` LEFT JOIN `user` ON `post`.`User_ID`=`user`.`User_ID` WHERE `post`.`User_ID`=? ORDER BY `post`.`Post_ID` DESC";

        //get count of followed people
        $sql2 = "SELECT COUNT(`Followed_User_ID`) FROM `follower_table` WHERE `Followed_User_ID`=?";

        //get count of following people
        $sql3 = "SELECT COUNT(`Following_User_ID`) FROM `follower_table` WHERE `Following_User_ID`=?";

        //did current user like this post
        $sql4 = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

        //get like count
        $sql5 = "SELECT COUNT(`Like_ID`) FROM `post_like_table` WHERE `Post_ID` = ?";

        //get comment count
        $sql6 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$_SESSION['userid']);
          $stmt->execute();
          //////////////////////////////////////////////////////////////////////
          $stmt2 = $conn->prepare($sql2);
          $stmt2->bindParam(1,$_SESSION['userid']);
          $stmt2->execute();

          $value = $stmt2->fetch();

          if(gettype($value) == "boolean")
          {
            $followers = 0;
          }
          else
          {
            $followers = $value[0];
          }
          //////////////////////////////////////////////////////////////////////
          $stmt3 = $conn->prepare($sql3);
          $stmt3->bindParam(1,$_SESSION['userid']);
          $stmt3->execute();

          $value2 = $stmt3->fetch();

          if(gettype($value2) == "boolean")
          {
            $followings = 0;
          }
          else {
            $followings = $value2[0];
          }
          //the top profile image + account + name + bio + followers/following numbers
          echo "<div>
                  <img id = 'profileimage' src = '$pfp'>
                  <h4 id = 'profileuser'>$accountname<br><br><a href = 'followerspage.php'>$followers Follower</a><a href = 'followingspage.php'> $followings Following</a></h4>
                  <br>
                  <h4 id = 'profilebio'>$bio</h4>
                  <form action = 'editprofile.php' method = 'POST'>
                    <button id = 'buttonuneditphoto' name = 'followorno' type = 'submit'><h4 id ='profilesearch'>Edit Profile</h4></button>
                  </form>
                  <br>
                  <form action = 'likedposts.php' method = 'POST'>
                    <button id = 'buttontotallike' name = 'followorno' type = 'submit'><h4 id ='profilesearch'>Liked Posts</h4></button>
                  </form>
                  <br><br>
                </div>";

          while($row = $stmt->fetch())
          {
            //fetched variables declaration
            $image = $row['Image'];
            $desc = $row['Description'];
            $create = $row['Post_Created_Datetime'];
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $postid = $row['Post_ID'];
            ////////////////////////////////////////////////////////////////////
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bindParam(1,$postid);
            $stmt4->bindParam(2,$_SESSION['userid']);
            $stmt4->execute();

            $rowcount = 0;

            while($row = $stmt4->fetch())
            {
              $rowcount++;
            }
            ////////////////////////////////////////////////////////////////////
            $stmt5 = $conn->prepare($sql5);
            $stmt5->bindParam(1,$postid);
            $stmt5->execute();
            $likedamount = $stmt5->fetch();
            //no likes
            if(gettype($likedamount) == "boolean")
            {
              $likedamount = 0;
            }
            else
            {
              $likedamount = $likedamount[0];
            }
            ////////////////////////////////////////////////////////////////////
            $stmt6 = $conn->prepare($sql6);
            $stmt6->bindParam(1,$postid);
            $stmt6->execute();

            $commentamount = $stmt6->fetch();
            //no comments
            if(gettype($commentamount) == "boolean")
            {
              $commentamount = 0;
            }
            else
            {
              $commentamount = $commentamount[0];
            }

            //each post
            echo "<div id = '$postid'>
                    <img id = 'profileimage' src = '$profilepicture'>
                    <h4 id = 'profileuser'>$accountname</h4>
                  </div>
                    <br>
                  <div id = 'feedimagediv'>
                    <img id = 'feedimage' src = '$image'>
                  </div>";

            //not liked
            if($rowcount == 0)
            {
              echo "<form action = 'like.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Like</h4></button>
                      <input type='hidden' name='link' value='profile.php#$postid'>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
            }
            //liked
            else
            {
              echo "<form action = 'like.php' method = 'POST'>
                      <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                      <input type='hidden' name='link' value='profile.php#$postid'>
                      <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                    </form>";
            }

            //comment button
            echo "<form action = 'comment.php' method = 'POST'>
                    <button id = 'buttoncomment' name = 'comment' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Comment</h4></button>
                  </form>";

            echo "<br>
                  <div>
                    <h3 id = 'text'><strong>$accountname</strong> $desc</h3>
                    <h3 id = 'text'>$create</h3>
                  </div>
                  <br>";
          }

          echo "<br><br>";

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