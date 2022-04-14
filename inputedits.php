<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='project4.css'>
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
    <?php

    session_start();

    $servername = "us-cdbr-east-05.cleardb.net";
    $username = "bf95d530c89c14";
    $password = "396f81cc";
    $dbname = "heroku_a454372d378d402";
    $err = 0;

    $firstpart = "UPDATE `user` SET ";

    $lastpart = " WHERE `User_ID` = ?";

    if($_POST['firstname'] != "")
    {
      $temp = $_POST['firstname'];
      $str = "`First_Name`='$temp', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['lastname'] != "")
    {
      $temp = $_POST['lastname'];
      $str = "`Last_Name`= '$temp', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['accountname'] != "")
    {

      $accname = addslashes($_POST['accountname']);

      $sql = "SELECT * FROM `user` WHERE `Account_Name` LIKE ?";

      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1,$accname);
      $stmt->execute();

      $row = $stmt->fetch();

      if(gettype($row) == "boolean") //no same name account found
      {
          $str = "`Account_Name`= '$accname', ";
          $firstpart = $firstpart . $str;
      }
      else //taken
      {
        $err++;
        echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Account Name Taken...</h1>
              <section>";
      }
    }

    if($_POST['gender'] != $_SESSION['gender'])
    {
      $g = $_POST['gender'];
      $str = "`Gender`= '$g', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['birthdate'] != "")
    {
      $bd = addslashes($_POST['birthdate']);
      $str = "`Birthdate`= '$bd', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['phonenumber'] != "")
    {
      $pn = $_POST['phonenumber'];
      $str = "`Phone_Number`= '$pn', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['email'] != "")
    {
      $mail = addslashes($_POST['email']);
      $str = "`Email`= '$mail', ";
      $firstpart = $firstpart . $str;
    }


    // $uploaddir = "photos/";
    // $uploaddir = str_replace('/', '\\', $uploaddir);
    // $uploadfile = $uploaddir . basename($_FILES['filename']['name']);

    $profilepic = $_POST['avatar_url'];

    if($profilepic != "")
    {
      $str = "`Profile_Picture`= '$profilepic', ";
      $firstpart = $firstpart . $str;
    }

    // if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploadfile))
    // {
    //     $profilepic = $uploaddir . $_FILES['filename']['name'];
    //     $profilepic = addslashes($profilepic);
    //     $str = "`Profile_Picture`= '$profilepic', ";
    //     $firstpart = $firstpart . $str;
    // }
    // else //did not upload profile picture
    // {
    //
    // }

    if($_POST['bio'] != "")
    {
      $bioo = addslashes($_POST['bio']);
      $str = "`Bio`= '$bioo', ";
      $firstpart = $firstpart . $str;
    }

    if($_POST['oldpassword'] != "" && $_POST['newpassword'] != "") //both filled out
    {
      if(password_verify($_POST['oldpassword'], $_SESSION['password'])) //old pass is correct
      {
        $hashedpwd =  password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        $str = "`Password`= '$hashedpwd', ";
        $firstpart = $firstpart . $str;
      }
      else //old pass not correct
      {
        $err++;
        echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Incorrect Old Password...</h1>
              <section>";

      }
    }
    elseif($_POST['oldpassword'] != "" && $_POST['newpassword'] == "") //only old password is filled out
    {
      $err++;
      echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Did not enter New Password...</h1>
            <section>";
    }
    elseif($_POST['oldpassword'] == "" && $_POST['newpassword'] != "") //only new password is filled out
    {
      $err++;
      echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Did not enter Old Password...</h1>
            <section>";
    }


    if(substr($firstpart, -2, 1) == ',')
    {
      $firstpart = substr($firstpart,0,-2);
      $sql = $firstpart . $lastpart;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$_SESSION['userid']);
        $stmt->execute();
        if($err == 0)
        {
          echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Edited...</h1>
                <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";
        }
        else
        {
          echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Other Information Edited...</h1>
                <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";
        }


        $sql2 = "SELECT * FROM `user` WHERE `User_ID` LIKE ?";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(1,$_SESSION['userid']);
        $stmt2->execute();
        $row = $stmt2->fetch();

        $_SESSION['firstname'] = $row['First_Name'];
        $_SESSION['lastname'] = $row['Last_Name'];
        $_SESSION['accountname'] = $row['Account_Name'];
        $_SESSION['gender'] = $row['Gender'];
        $_SESSION['birthdate'] = $row['Birthdate'];
        $_SESSION['phonenumber'] = $row['Phone_Number'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['profilepicture'] = $row['Profile_Picture'];;
        $_SESSION['password'] = $row['Password'];
        $_SESSION['bio'] = $row['Bio'];

        //////////////////////////////////////////////////////////////////////////////////////////

        $conn = null;
        //////////////////////////////////////////////////////////////////////////////////////////
      } catch(PDOException $e) {
        echo "$sql";
        echo "Connection failed: " . $e->getMessage();
        echo "<br>Try again!";
        echo "<br>Redirecting in three seconds...";
        // header("refresh:3;url=profile.php");
      }
    }
    echo "<br>";
    header("refresh:2;url=profile.php");
    ?>
  </body>
</html>
