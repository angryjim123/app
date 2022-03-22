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

        if(empty($_POST['comment']))
        {
          $postid = $_SESSION['commenttemp'];
        }
        else
        {
          $postid = $_POST['comment'];
          $_SESSION['commenttemp'] = $postid;
        }

        $sql = "SELECT `post`.*,`user`.`Account_Name`,`user`.`Profile_Picture`,`comment_table`.`Comment_ID`,`comment_table`.`Comment`,`comment_table`.`Time`, `comment_table`.`User_ID` AS 'CUser_ID' FROM `post`
        LEFT JOIN `user` ON `post`.`User_ID`=`user`.`User_ID`
        LEFT JOIN `comment_table` ON `post`.`Post_ID` = `comment_table`.`Post_ID`
        WHERE `post`.`Post_ID`=?
        ORDER BY `comment_table`.`Time` DESC";

        $sql2 = "SELECT COUNT(`Like_ID`) FROM `post_like_table` WHERE `Post_ID` = ?";

        $sql3 = "SELECT * FROM `post_like_table` WHERE `Post_ID` = ? AND `Liked_User_ID` = ?";

        $sql4 = "SELECT COUNT(`Comment_ID`) FROM `comment_table` WHERE `Post_ID` = ?";

        $sql5 = "SELECT `user`.`Account_Name` FROM `user` WHERE `User_ID` = ?";

        $first = true;

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //////////////////////////////////////////////////////////////////////
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$postid);
          $stmt->execute();
          //////////////////////////////////////////////////////////////////////
          $stmt2 = $conn->prepare($sql2);
          $stmt2->bindParam(1,$postid);
          $stmt2->execute();

          $likedamount = $stmt2->fetch();

          if(gettype($likedamount) == "boolean") //no likes
          {
            $likedamount = 0;
          }
          else
          {
            $likedamount = $likedamount[0];
          }
          //////////////////////////////////////////////////////////////////////
          $stmt3 = $conn->prepare($sql3);
          $stmt3->bindParam(1,$postid);
          $stmt3->bindParam(2,$_SESSION['userid']);
          $stmt3->execute();

          $liked = $stmt3->fetch();

          if(gettype($liked) == 'boolean') //not liked
          {
            $liked = false;
          }
          else
          {
            $liked = true;
          }
          //////////////////////////////////////////////////////////////////////
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

          while($row = $stmt->fetch())
          {
            $userid = $row['User_ID'];
            $image = $row['Image'];
            $desc = $row['Description'];
            $create = $row['Post_Created_Datetime'];
            $accountname = $row['Account_Name'];
            $profilepicture = $row['Profile_Picture'];
            $commentid = $row['Comment_ID'];
            $comment = $row['Comment'];
            $commenttime = $row['Time'];
            $accountid = $row['CUser_ID'];

            $stmt5 = $conn->prepare($sql5);
            $stmt5->bindParam(1,$accountid);
            $stmt5->execute();
            $result = $stmt5->fetch();
            if(gettype($result) != 'boolean')
            {
              $accountnamee = $result['Account_Name'];
            }


            if($first)
            {
              $first = false;
              echo "<form action = 'profile.php' method = 'POST'>
                      <img id = 'profileimage' src = '$profilepicture'>
                      <button id = 'buttonlink' type = 'submit'><h4 id = 'profileuserfeed'>$accountname</h4></button>
                    </form>
                    <br>";

              echo "<div id = 'feedimagediv'>
                      <img id = 'feedimage' src = '$image'>
                      <br><br>
                      <h3 id = 'text'>$desc</h3>
                    </div>";

              if(!$liked) //not liked
              {
                echo "<form action = 'like.php' method = 'POST'>
                  <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Like</h4></button>
                  <input type='hidden' name='link' value='comment.php'>
                  <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                </form>";
              }
              else //liked
              {
                echo "<form action = 'like.php' method = 'POST'>
                  <button id = 'buttonlike' name = 'like' type = 'submit' value = '$postid'><h4 id ='profilesearch'>Unlike</h4></button>
                  <input type='hidden' name='link' value='comment.php'>
                  <h3 id = 'liketext'>$likedamount Likes $blankspace$commentamount Comments</h3>
                </form>";
              }
            }

            echo "<br><br>";

            if($comment != null)
            {
              echo "<form action = 'clickaccount.php' method = 'POST'>
                      <button id = 'usercomment' name = 'acc' type = 'submit' value = '$accountid'><h4 id ='profilesearch'>$accountnamee</h4></button>
                    </form>";

              if($accountnamee == $_SESSION['accountname'])
              {
                echo "<form action = 'editcomment.php' method = 'POST'>
                        <button id = 'commentedit' name = 'commentid' type = 'submit' value = '$commentid'><h4 id ='profilesearch'>Edit</h4></button>
                        <input type='hidden' name='comment' value='$comment'>
                        <input type='hidden' name='link' value='comment.php'>
                      </form>";
                echo "<form action = 'deletecomment.php' method = 'POST'>
                        <button id = 'commentdelete' name = 'commentid' type = 'submit' value = '$commentid'><h4 id ='profilesearch'>Delete</h4></button>
                        <input type='hidden' name='link' value='comment.php'>
                      </form>";
              }
              echo "<h3 id = 'text2'>$comment</h3><h3 id = 'datetime'>$commenttime</h3><br><br><br><hr>";
            }
          }

          echo "<br><br>
                <div style = 'text-align: center'>
                  <form action = 'addcomment.php' method = 'POST' id = 'usrform'>
                    <textarea name = 'comment' form = 'usrform' placeholder = 'Comment'></textarea>
                    <input type='hidden' name='postid' value='$postid'>
                    <input type='hidden' name='link' value='comment.php'>
                    <input id = 'submit' type='submit' value='Comment' >
                  </form>
                </div>";

        }catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
              echo "<br>Try again!";
              echo "<br>Redirecting in three seconds...";
              // header("refresh:3;url=profile.php");
        }

      ?>
    </section>
  </body>
</html>