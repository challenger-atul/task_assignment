<?php
  require_once './php/dbconfig.php';

  if($user -> is_loggedin() != "")
  {
    $user -> redirect('./php/fork.php');
  }

  if(isset($_POST['btn-login']))
  {
    $uname = $_POST['txt_uname_email'];
    $umail = $_POST['txt_uname_email'];
    $upass = $_POST['txt_password'];

    if($user -> login($uname, $umail, $upass))
    {
      $user -> redirect('./php/fork.php');
    }
    else
    {
      $error = "Wrong Details !";
    }
  }
?>

<!DOCTYPE html >
<html>
  <head>
    <meta charset="UTF-8">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="./css/login.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskMe</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="center-align" id="title">
        <h1>Task me</h1>
      </div>
      <div id="form-container" class="row">
        <form method="post" id="login-form" class="col s10 offset-s1">
          <h2>Sign in</h2>
          <div class="section">
            <input type="text" name="txt_uname_email" placeholder="Username or E mail ID" required />
          </div>
          <div class="section">
            <input type="password" name="txt_password" placeholder="Your Password" required />
          </div>
          <div class="section">
            <button type="submit" name="btn-login" class="btn purple">
              SIGN IN
            </button>
          </div>
          <label>Don't have account yet ! <a href="./php/sign-up.php">Sign Up</a></label>
        </form>
      </div>
    </div>
  </body>
</html>