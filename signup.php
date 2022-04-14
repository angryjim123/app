<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
    <script src="https://app.simplefileupload.com/buckets/0f6ab5fed3a03b1d305d9ac29a4c160a.js"></script>
  </head>
  <body>
    <?php include 'nav.php'; ?>
    <section id = 'sectionlog'>
      <h1>Sign Up For Free</h1>
      <h3>and enhance your experience</h3>
      <form action="createaccount.php" method="POST" id = "usrform" enctype="multipart/form-data">
        <!--  -->
        <label for = "First_Name"></label>
        <input id = "First_Name" type="text" placeholder="First Name *" name = "firstname" required>
        <br>
        <!--  -->
        <label for = "Last_Name"></label>
        <input id = "Last_Name" type="text" placeholder="Last Name *" name = "lastname" required>
        <br>
        <!--  -->
        <label for = "Email"></label>
        <input id = "Email" type="text" placeholder="Email *" name = "email" required>
        <br>
        <!--  -->
        <label for = "Phone_Number"></label>
        <input id = "Phone_Number" type="text" placeholder="Phone Number" name = "phonenumber">
        <br>
        <!--  -->
        <label for = "Account_Name"></label>
        <input id = "Account_Name" type="text" placeholder="Account Name *" name = "accountname" required>
        <br>
        <!--  -->
        <label for = "Password"></label>
        <input id = "Password" type="password" placeholder="Password *" name = "password" required>
        <br>
        <!--  -->
        <textarea name = "bio" form = "usrform" placeholder = "Bio"></textarea>
        <br>
        <!--  -->
        <input id="male" type="radio" name="gender" value = "Male" required>
        <label for="male">Male</label>
        <input id="female" type="radio" name="gender" value = "Female">
        <label for="female">Female</label>
        <input id="other" type="radio" name="gender" value = "Other">
        <label for="other">Other</label>
        <br>
        <!--  -->
        <label for="Birthdate">Birthdate:</label>
        <input type="date" id="Birthdate" name="birthdate" required>
        <br>
        <!--  -->
        <input type="hidden" name="avatar_url" id="avatar_url" class="simple-file-upload" >
        <!-- <label for="filename" class = "custom">Upload Profile Picture</label>
        <input type="file" id="filename" name="filename"> -->
        <br>
        <!--  -->
        <input id = "submit" type="submit" value="Sign Up" >
      </form>
      <h5>By signing up, you agree to our <span style = "color:orange">Terms and Conditions</span></h5>
    </section>
  </body>
</html>
