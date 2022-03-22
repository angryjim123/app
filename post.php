<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <section id = 'sectionlog'>
      <form action='posting.php' method='POST' id = 'usrform' enctype='multipart/form-data'>
        <label for='filename' class = 'custom2'>Upload Picture</label>
        <input type='file' id='filename' name='filename' required>
        <br>
        <textarea name = 'description' form = 'usrform' placeholder = 'Description'></textarea>
        <br>
        <input id = 'submit' type='submit' value='Post' >
      </form>
    </section>
    <?php
    session_start();

    // getting image size
    // $image_info = getimagesize($_FILES['file_field_name']['tmp_name']);
    // $image_width = $image_info[0];
    // $image_height = $image_info[1];
    ?>
  </body>
</html>