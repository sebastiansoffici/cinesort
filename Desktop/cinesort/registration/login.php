<?php include ('server.php');?>
<!DOCTYPE html>
<html>
<head>
  <title> Cinesort | Login </title>
  <link rel = "stylesheet" type = "text/css" href = "style.css">
  </head>
  <body>
    <div class = "header">
      <h2>Login</h2>
    </div>
    <form method = "post" action = "login.php">
      <?php include('errors.php'); ?>
      <div class = "input-group">
        <label>Username</label>
        <input type = "text" name = "username">
        <label>Password</label>
        <input type = "password" name = "password">
        <button type = "submit" name = "login_user" class = "btn">Login</button>
      </div>
      <p>
          Not a member? <a href="register.php">Sign Up</a>
      </p>
    </form>

  </body>
  </html>
