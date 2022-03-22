<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='project4.css'>
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <?php

    session_start();

    $comment = $_POST['comment'];
    $commentid = $_POST['commentid'];
    $redirect = $_POST['link'];

    echo "<section id = 'sectionlog'>
      <h1>Edit Comment</h1>
      <form action='inputcommentedits.php' method='POST' id = 'usrform' enctype='multipart/form-data'>
        <!--  -->
        <label for = 'Edit_Comment'></label>
        <input class = 'orangetext' id = 'Edit_Comment' type='text' placeholder='$comment' name = 'comment'>
        <input type='hidden' name='commentid' value='$commentid'>
        <input type='hidden' name='link' value='$redirect'>
        <br>
        <input id = 'submit' type='submit' value='Edit'>
      </form>
    </section>";
    ?>
  </body>
</html>
