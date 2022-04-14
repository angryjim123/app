<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <?php

    $servername = "us-cdbr-east-05.cleardb.net";
    $username = "bf95d530c89c14";
    $password = "396f81cc";
    $dbname = "heroku_a454372d378d402";

      $accountname =  $_POST['accountname'];
      $email = $_POST['email'];
      $rowcount = 0;

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM `user` WHERE Account_Name LIKE ? OR Email LIKE ?";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$accountname);
        $stmt->bindParam(2,$email);
        $stmt->execute();

        while($row = $stmt->fetch())
        {
          $rowcount++;
        }

        $sql = null;
        $conn = null;
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        echo "<br>Try again!";
        echo "<br><a href ='signup.html'>Sign Up</a>";
      }

      if($rowcount != 0) //same account name or email
      {
        echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Account Name or Email registered</h1>
              <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";
        header("refresh:3;url=signup.php");
      }
      else
      {
        $firstname =  $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phonenumber = $_POST['phonenumber'];
        if($phonenumber == "")
        {
          $phonenumber = NULL;
        }
        //
        $pwd = $_POST['password'];
        $bio = $_POST['bio'];
        if($bio == "")
        {
          $bio = NULL;
        }
        //
        $gender = $_POST['gender'];
        $birthdate = $_POST['birthdate'];

        //$profilepicture = $_POST['picture'];
        $uploaddir = "photos/";
        $uploaddir = str_replace('/', '\\', $uploaddir);
        $uploadfile = $uploaddir . basename($_FILES['filename']['name']);

        if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploadfile))
        {
            $profilepicture = $uploaddir . $_FILES['filename']['name'];
        }
        else
        {
          $profilepicture = $uploaddir . "default.jpg";
          //no picture
        }
        //

        $hashedpwd =  password_hash($pwd, PASSWORD_BCRYPT);

        $email = addslashes($email);
        $accountname = addslashes($accountname);
        $bio = addslashes($bio);
        $birthdate = addslashes($birthdate);
        $profilepicture = addslashes($profilepicture);


        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "INSERT INTO `user`(`First_Name`, `Last_Name`, `Account_Name`, `Gender`, `Birthdate`, `Phone_Number`, `Email`, `Profile_Picture`, `Password`, `Bio`) VALUES ('$firstname', '$lastname', '$accountname', '$gender', '$birthdate', '$phonenumber', '$email', '$profilepicture', '$hashedpwd','$bio')";
          $conn->exec($sql);
          echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Connected successfully...</h1>
                <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";

          //////////////////////////////////////////////////////////////////////////////////////////

          $sql = null;
          $conn = null;
          //////////////////////////////////////////////////////////////////////////////////////////
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
          echo "<br>Try again!";
          echo "<br>Redirecting in three seconds...";
          header("refresh:3;url=welcome.php");
        }

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "SELECT * FROM `user` WHERE Account_Name LIKE ? AND Password LIKE ?";

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(1,$accountname);
          $stmt->bindParam(2,$hashedpwd);
          $stmt->execute();

          session_start();

          while($row = $stmt->fetch())
          {
            $_SESSION['userid'] = $row["User_ID"];
            $_SESSION['accountcreatedate'] = $row["Account_Created_Date"];
          }
          //id
          $_SESSION['firstname'] = $firstname;
          $_SESSION['lastname'] = $lastname;
          $_SESSION['accountname'] = $accountname;
          $_SESSION['gender'] = $gender;
          $_SESSION['birthdate'] = $birthdate;
          //account created
          $_SESSION['phonenumber'] = $phonenumber;
          $_SESSION['email'] = $email;
          $_SESSION['profilepicture'] = $profilepicture;
          $_SESSION['password'] = $hashedpwd;
          $_SESSION['bio'] = $bio;

          // echo $_SESSION['userid'] . "<br>";
          // echo $_SESSION['firstname'] . "<br>";
          // echo $_SESSION['lastname'] . "<br>";
          // echo $_SESSION['accountname'] . "<br>";
          // echo $_SESSION['gender'] . "<br>";
          // echo $_SESSION['birthdate'] . "<br>";
          // echo $_SESSION['accountcreatedate'] . "<br>";
          // echo $_SESSION['phonenumber'] . "<br>";
          // echo $_SESSION['email'] . "<br>";
          // echo $_SESSION['profilepicture'] . "<br>";
          // echo $_SESSION['password'] . "<br>";
          // echo $_SESSION['bio'] . "<br>";

          $sql = null;
          $conn = null;
          header("refresh:3;url=homepage.php");
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
          echo "<br>Try again!";
          echo "<br><a href ='signup.html'>Sign Up</a>";
        }
      }
    ?>
  </body>
</html>