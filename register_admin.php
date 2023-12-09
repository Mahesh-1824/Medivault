<?php
	session_start();
 
	if (isset($_SESSION['id_org'])) {
		header('location:org_mainpage.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Health Database</title>
    <link rel="stylesheet" href="signup.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet" />
  </head>
  <body>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'healthcare');
    if (isset($_POST['submit'])) {
      $Username = mysqli_real_escape_string($conn, $_POST['username']);
      $Userid = mysqli_real_escape_string($conn, $_POST['userid']);
      $Phone_No = $_POST['phone'];
      $pass = md5($_POST['password']);
      $cpass = md5($_POST['cpassword']);
      
      // Check if the organization ID already exists
      $select = "SELECT * FROM doctor WHERE userid='$Userid'";
      $result = mysqli_query($conn, $select);

      if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Organization ID already exists')</script>";
      } else {
        if ($pass != $cpass) {
          echo "<script>alert('Incorrect password')</script>";
        } else {
          $insert = "INSERT INTO `doctor`(`userid`, `username`, `phone`, `password`)
                     VALUES ('$Userid', '$Username', $Phone_No, '$pass')";
          mysqli_query($conn, $insert);
          echo '<script type="text/javascript"> window.location.href="login_admin.php"; </script>';
        }
      }
    }
    ?>

    <div class="container">
      <div class="box-container">
        <div class="login-image"></div>
        <div class="screen">
          <h1>SIGN UP</h1>
          <form action="" method="post" class="login">
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="text" class="login_input" name="userid" required placeholder="Organization ID">
            </div>
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="text" class="login_input" name="username" required placeholder="Organization name">
            </div>
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="password" class="login_input" name="password" required placeholder="Valid password type" pattern="(?=.*\d)(?=.*\W)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain one number, one uppercase and lowercase letter, a symbol, at least 8 characters" required>
            </div>
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="password" class="login_input" name="cpassword" required placeholder="Confirm your password">
            </div>
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="phone" class="login_input" name="phone" required placeholder="**********">
            </div>
            <div class="button_text">
              <input type="submit" name="submit" value="Register" class="button login_submit">
            </div>
            <div class="sign-up">
              <p>Already have an account?<a href="login_admin.php">Sign In</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
