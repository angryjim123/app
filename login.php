<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="photov1.css">
  </head>
  <body>
    <?php include 'nav.php'; ?>
    <section id = 'sectionlog'>
      <h1>Login</h1>
      <form action="loginaccount.php" method="POST">
        <label for = "Username"></label>
        <input id = "Username" type="text" placeholder="Username" name = "username">
        <br>
        <label for = "Password"></label>
        <input id = "Password" type="password" placeholder="Password" name = "password">
        <br>
        <input id = "submit" type="submit" value="Login">
      </form>
    </section>
  </body>
</html>