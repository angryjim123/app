<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='photov1.css'>
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <?php

    session_start();

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $accountname = $_SESSION['accountname'];
    $gender = $_SESSION['gender'];
    $birthdate = $_SESSION['birthdate'];
    $phonenumber = $_SESSION['phonenumber'];
    $email = $_SESSION['email'];
    $profilepicture = $_SESSION['profilepicture'];
    $hashedpwd = $_SESSION['password'];
    $bio = $_SESSION['bio'];

    //each edit form
    echo "<section id = 'sectionlog'>
      <h1>Edit Profile</h1>
      <form action='inputedits.php' method='POST' id = 'usrform' enctype='multipart/form-data'>
        <!--  -->
        <h4 id = 'editprofileh4'>First Name</h4>
        <label for = 'First_Name'></label>
        <input class = 'orangetext' id = 'First_Name' type='text' placeholder='$firstname' name = 'firstname'>
        <br>
        <!--  -->
        <h4 id = 'editprofileh4'>Last Name</h4>
        <label for = 'Last_Name'></label>
        <input class = 'orangetext' id = 'Last_Name' type='text' placeholder='$lastname' name = 'lastname'>
        <br>
        <!--  -->
        <h4 id = 'editprofileh4'>Email</h4>
        <label for = 'Email'></label>
        <input class = 'orangetext' id = 'Email' type='text' placeholder='$email' name = 'email'>
        <br>
        <!--------------------------------------------------------------------->";

        //optional field so may be empty
        if($phonenumber == "")
        {
          echo "<h4 id = 'editprofileh4'>Phone Number</h4>
          <label for = 'Phone_Number'></label>
          <input id = 'Phone_Number' type='text' placeholder='$phonenumber' name = 'phonenumber'>
          <br>";
        }
        else
        {
          echo "<h4 id = 'editprofileh4'>Phone Number</h4>
          <label for = 'Phone_Number'></label>
          <input class = 'orangetext' id = 'Phone_Number' type='text' placeholder='$phonenumber' name = 'phonenumber'>
          <br>";
        }

        echo "<!--  -->
        <h4 id = 'editprofileh4'>Account Name</h4>
        <label for = 'Account_Name'></label>
        <input class = 'orangetext' id = 'Account_Name' type='text' placeholder='$accountname' name = 'accountname'>
        <br>
        <!--  -->
        <h4 id = 'editprofileh4'>Password</h4>
        <label for = 'OldPassword'></label>
        <input class = 'orangetext' id = 'OldPassword' type='password' placeholder = 'Old Password' name = 'oldpassword'>
        <label for = 'NewPassword'></label>
        <input class = 'orangetext' id = 'NewPassword' type='password' placeholder = 'New Password' name = 'newpassword'>
        <br>
        <!--------------------------------------------------------------------->";

        //optional field so may be empty
        if($bio == "")
        {
          echo "<h4 id = 'editprofileh4'>Bio</h4>
          <textarea name = 'bio' form = 'usrform' placeholder = '$bio'></textarea>
          <br>";
        }
        else
        {
          echo "<h4 id = 'editprofileh4'>Bio</h4>
          <textarea class = 'orangetext' name = 'bio' form = 'usrform' placeholder = '$bio'></textarea>
          <br>";
        }

        //gender choosen will be automatically selected
        if($gender == 'Male')
        {
          echo "<input id='male' type='radio' name='gender' value = 'Male' checked>
          <label for='male'>Male</label>
          <input id='female' type='radio' name='gender' value = 'Female'>
          <label for='female'>Female</label>
          <input id='other' type='radio' name='gender' value = 'Other'>
          <label for='other'>Other</label>
          <br>";
        }
        elseif ($gender == 'Female')
        {
          echo "<input id='male' type='radio' name='gender' value = 'Male'>
          <label for='male'>Male</label>
          <input id='female' type='radio' name='gender' value = 'Female' checked>
          <label for='female'>Female</label>
          <input id='other' type='radio' name='gender' value = 'Other'>
          <label for='other'>Other</label>
          <br>";
        }
        else
        {
          echo "<input id='male' type='radio' name='gender' value = 'Male'>
          <label for='male'>Male</label>
          <input id='female' type='radio' name='gender' value = 'Female'>
          <label for='female'>Female</label>
          <input id='other' type='radio' name='gender' value = 'Other' checked>
          <label for='other'>Other</label>
          <br>";
        }

        echo "<!--  -->
        <label for='Birthdate'>Birthdate:</label>
        <input type='date' id='Birthdate' name='birthdate'>
        <br>
        <!--  -->
        <label for='filename' class = 'custom'>Upload Profile Picture</label>
        <input type='file' id='filename' name='filename'>
        <br>
        <!--  -->
        <input id = 'submit' type='submit' value='Edit' >
      </form>
    </section>";
    ?>
  </body>
</html>
