<!DOCTYPE html>
<html>
  <head>
    <script src="https://app.simplefileupload.com/buckets/0f6ab5fed3a03b1d305d9ac29a4c160a.js"></script>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav2.php';
          include 'variables.php'; ?>
    <section id = 'sectionlog'>
      <form method = "POST" action = "posting.php" enctype='multipart/form-data' id = 'usrform'>
        <input type="hidden" name="avatar_url" id="avatar_url" class="simple-file-upload" >
        <br>
        <textarea name = 'description' form = 'usrform' placeholder = 'Description'></textarea>
        <br>
        <input id = "submit" type="submit" value="Post" >
      </form>
      <!-- <form action='posting.php' method='POST' id = 'usrform' enctype='multipart/form-data'>
        <label for='filename' class = 'custom2'>Upload Picture</label>
        <input type='file' id='filename' name='filename' required>
        <br>
        <textarea name = 'description' form = 'usrform' placeholder = 'Description'></textarea>
        <br>
        <input id = 'submit' type='submit' value='Post' >
      </form> -->
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