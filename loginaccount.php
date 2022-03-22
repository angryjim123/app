<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <?php

      $servername = "localhost";
      $username = "root";
      $password = "1234567890";
      $dbname = "photo";

      $accountname =  $_POST['username'];
      $pwd = $_POST['password'];

      $rowcount = 0;
      $err = 0; //0 is account error 1 is password error

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM `user` WHERE Account_Name LIKE ?";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$accountname);
        $stmt->execute();

        session_start();

        while($row = $stmt->fetch())
        {
          $err = 1;
          if(password_verify($pwd, $row['Password']))
          {
            $rowcount++;
            $_SESSION['userid'] = $row["User_ID"];
            $_SESSION['firstname'] = $row["First_Name"];
            $_SESSION['lastname'] = $row["Last_Name"];
            $_SESSION['accountname'] = $row["Account_Name"];
            $_SESSION['gender'] = $row["Gender"];
            $_SESSION['birthdate'] = $row["Birthdate"];
            $_SESSION['accountcreatedate'] = $row["Account_Created_Date"];
            $_SESSION['phonenumber'] = $row["Phone_Number"];
            $_SESSION['email'] = $row["Email"];
            $_SESSION['profilepicture'] = $row["Profile_Picture"];
            $_SESSION['password'] = $row["Password"];
            $_SESSION['bio'] = $row["Bio"];
          }
        }

        if($rowcount == 0) //no this account
        {
          echo "<section id = 'sectionlog' style = 'background-color:#ffa31a;'><h1 style = 'color:black'>Account Name or Password Incorrect</h1>
                <br><h1 style = 'color:black'>Redirecting...</h1><br><section>";
          header("refresh:1;url=login.php");
        }
        else
        {
        // login success
        header("refresh:0.1;url=homepage.php");
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
        // }

        $sql = null;
        $conn = null;
        // header("refresh:3;url=welcome.php");
        }
      }
       catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        header("refresh:0.1;url=welcome.php");
      }

    ?>
  </body>
</html>