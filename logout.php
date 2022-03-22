<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="project4.css">
  </head>
  <body>
    <section>
      <?php
        session_start();
        session_destroy();
        header("refresh:0.1;url=login.php");
      ?>
      <br><br>
    </section>
  </body>
</html>