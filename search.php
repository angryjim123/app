<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
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
          <a href ="search.php" id = "ph">Search</a>
          <a href ="profile.php" id = "normal">Profile</a>
        </div>
        <div id = "headerright">
          <a href="logout.php">
           <img alt="Logout" src="photos/jeffrey.jpg" id = "logoutimage">
         </a>
        </div>
    </header>
    <section id = "sectionlog">
      <form action="searchaccount.php" method="POST" id = "usrform" enctype="multipart/form-data">
        <!--  -->
        <label for = "searchacc"></label>
        <input id = "searchacc" type="text" placeholder="Account Name" name = "searchaccount" required>
        <br>
        <input id = "submit" type="submit" value="Search" >
      </form>
    </section>
  </body>
</html>