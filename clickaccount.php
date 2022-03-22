<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <section id = "sectionfeed">
      <?php

        session_start();

        //get all posts by that user
        $sql = "SELECT `post`.*,`user`.`Bio`,`user`.`Account_Name`,`user`.`Profile_Picture` FROM `post` LEFT JOIN `user` ON `post`.`User_ID`=`user`.`User_ID` WHERE `post`.`User_ID`=? ORDER BY `post`.`Post_ID` DESC";

        //get followed user count
        $sql2 = "SELECT COUNT(`Followed_User_ID`) FROM `follower_table` WHERE `Followed_User_ID`=?";

        //get following user count
        $sql3 = "SELECT COUNT(`Following_User_ID`) FROM `follower_table` WHERE `Following_User_ID`=?";

        //if user us following that account
        $sql4 = "SELECT * FROM `follower_table` WHERE `Followed_User_ID`=? AND `Following_User_ID`=?";

        //that user information
        $sql5 = "SELECT * FROM `user` WHERE `User_ID` = ?";

        //if that post is liked by current user
        $sql6 = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

        //like count of the post
        $sql7 = "SELECT COUNT(`Like_ID`) FROM `post_like_table` WHERE `Post_ID` = ?";

        //comment count of the post
        $sql8 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

        //may not have received POST data from other redirection of file
        if(empty($_POST['acc']))
        {
          $userid = $_SESSION['temp'];
        }
        else
        {
          $userid = $_POST['acc'];
          $_SESSION['temp'] = $userid;
        }

        //if it's own account, redirect to profile page
        if(!empty($_POST['acc']) && $_POST['acc'] == $_SESSION['userid'])
        {
          header("refresh:0.1;url=profile.php");
        }
        else
        {
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$userid);
            $stmt->execute();
            ////////////////////////////////////////////////////////////////////
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(1,$userid);
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
            ////////////////////////////////////////////////////////////////////
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(1,$userid);
            $stmt3->execute();

            $value2 = $stmt3->fetch();

            if(gettype($value2) == "boolean")
            {
              $followings = 0;
            }
            else {
              $followings = $value2[0];
            }
            ////////////////////////////////////////////////////////////////////
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bindParam(1,$userid);
            $stmt4->bindParam(2,$_SESSION['userid']);
            $stmt4->execute();

            $follow = $stmt4->fetch();

            if(gettype($follow) == "boolean")
            {
              $followerid = "n" . $userid; //not following
            }
            else {
              $followerid = "y" . $follow['Follower_ID']; //following
            }

            $rowcount = 0;
            $first = true;

            while($row = $stmt->fetch())
            {
              $rowcount++;
              $postid = $row['Post_ID'];
              $image = $row['Image'];
              $desc = $row['Description'];
              $create = $row['Post_Created_Datetime'];
              $accountname = $row['Account_Name'];
              $profilepicture = $row['Profile_Picture'];
              $bio = $row['Bio'];
              //////////////////////////////////////////////////////////////////
              $stmt6 = $conn->prepare($sql6);
              $stmt6->bindParam(1,$postid);
              $stmt6->bindParam(2,$_SESSION['userid']);
              $stmt6->execute();

              $rowcountt = 0;

              while($roww = $stmt6->fetch())
              {
                $rowcountt++;
              }
              //////////////////////////////////////////////////////////////////
              $stmt7 = $conn->prepare($sql7);
              $stmt7->bindParam(1,$postid);
              $stmt7->execute();
              $likedamount = $stmt7->fetch();
              if(gettype($likedamount) == "boolean") //no likes
              {
                $likedamount = 0;
              }
              else
              {
                $likedamount = $likedamount[0];
              }
              //////////////////////////////////////////////////////////////////
              $stmt8 = $conn->prepare($sql8);
              $stmt8->bindParam(1,$postid);
              $stmt8->execute();

              $commentamount = $stmt8->fetch();
              if(gettype($commentamount) == "boolean") //no likes
              {
                $commentamount = 0;
              }
              else
              {
                $commentamount = $commentamount[0];
              }
              //////////////////////////////////////////////////////////////////
              if($first)
              {
                $first = false;
                echo "<div>
                        <img id = 'profileimage' src = '$profilepicture'>
                        <h4 id = 'profileuser'>$accountname<br><br><a href = 'followerspage2.php'>$followers Follower</a><a href = 'followingspage2.php'> $followings Following</a></h4>
                        <br>
                        <h4 id = 'profilebio'>$bio</h4>
                        <br><br>";

                //following already
                if(gettype($follow) != "boolean")
                {
                  echo "<form action = 'follow.php' method = 'POST'>
                          <button id = 'buttonunfollow' name = 'followorno' type = 'submit' value = '$followerid'><h4 id ='profilesearch'>Unfollow</h4></button>
                        </form>";
                }
                //not following
                else
                {
                  echo "<form action = 'follow.php' method = 'POST'>
                          <button id = 'buttonunfollow' name = 'followorno' type = 'submit' value = '$followerid'><h4 id ='profilesearch'>Follow</h4></button>
                        </form>";
                }

                echo "</div>
                      <br>";
              }
              //post picture
              echo "<div id = '$postid'>
                      <div id = 'feedimagediv'>
                        <img id = 'feedimage' src = '$image'>
                      </div>
                    </div>";

              //not liked
              if($rowcountt == 0)
              {
                echo "<form action = 'like.php' method = 'POST'>
                        <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Like</h4></button>
                        <input type='hidden' name='link' value='clickaccount.php#$postid'>
                        <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                      </form>";
              }
              //liked
              else
              {
                echo "<form action = 'like.php' method = 'POST'>
                        <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                        <input type='hidden' name='link' value='clickaccount.php#$postid'>
                        <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                      </form>";
              }

              echo "<form action = 'commentclick.php' method = 'POST'>
                      <button id = 'buttoncomment' name = 'comment' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Comment</h4></button>
                    </form>";

              echo "<br>
                    <div>
                      <h3 id = 'text'><strong>$accountname</strong> $desc</h3>
                    </div>";
            }

            //no posts
            if($rowcount == 0)
            {
              $stmt5 = $conn->prepare($sql5);
              $stmt5->bindParam(1,$userid);
              $stmt5->execute();

              $row = $stmt5->fetch();

              $accountname = $row['Account_Name'];
              $profilepicture = $row['Profile_Picture'];

              echo "<div>
                      <img id = 'profileimage' src = '$profilepicture'>
                      <h4 id = 'profileuser'>$accountname<br><br><a href = 'followerspage2.php'>$followers Follower</a><a href = 'followingspage2.php'> $followings Following</a></h4>";

              if(gettype($follow) != "boolean") //following already
              {
                echo "<form action = 'follow.php' method = 'POST'>
                        <button id = 'buttonunfollow' name = 'followorno' type = 'submit' value = '$followerid'><h4 id ='profilesearch'>Unfollow</h4></button>
                      </form>";
              }
              else
              {
                echo "<form action = 'follow.php' method = 'POST'>
                        <button id = 'buttonunfollow' name = 'followorno' type = 'submit' value = '$followerid'><h4 id ='profilesearch'>Follow</h4></button>
                      </form>";
              }
              echo "</div>
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
            echo "<br><a href ='homepage.php'>Home</a>";
          }
        }
      ?>
    </section>
  </body>
</html>