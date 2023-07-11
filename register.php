<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>health Database</title>
    <link rel="stylesheet" href="signup.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      function checkUseridAvailability() {
        var userid = $('#userid').val();
        if (userid !== '') {
          $.ajax({
            type: 'POST',
            url: 'check_username.php',
            data: { userid: userid },
            success: function(response) {
              $('#message').html(response);
            }
          });
        } else {
          $('#message').html('');
        }
      }
    </script>
  </head>
  <body>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'healthcare');
    if (isset($_POST['submit'])) {
      $Userid = mysqli_real_escape_string($conn, $_POST['userid']);
      $Username = mysqli_real_escape_string($conn, $_POST['username']);
      $Phone_No = $_POST['phone'];
      $pass = md5($_POST['password']);
      $cpass = md5($_POST['cpassword']);

      // Check if the username already exists
      $select = "SELECT * FROM patient WHERE userid='$Userid'";
      $result = mysqli_query($conn, $select);
      
      if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username already exists')</script>";
      } else {
        if ($pass != $cpass) {
          echo "<script>alert('Incorrect confirm password')</script>";
        } else {
          $insert = "INSERT INTO `patient`(`userid`, `username`, `phone`, `password`)
          VALUES ('$Userid','$Username',$Phone_No,'$pass')";
          mysqli_query($conn, $insert);
          echo '<script type="text/javascript"> window.location.href="login.php"; </script>';
        }
      }
    }
    ?>

    <div class="container">
      <div class="box-container">
        <div class="login-image"></div>
        <div class="screen">
          <h1>SIGN UP</h1>

          <form class="login" action="" method="post">
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="text" class="login_input" name="userid" required placeholder="User ID" onblur="checkUsernameAvailability()">
            </div>
            <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
              <input type="text" class="login_input" name="username" id="username" required placeholder="UserName" >
              <div id="message"></div>
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
              <input type="submit" name="submit" value="Sign Up" class="button login_submit">
            </div>
            <div class="sign-up">
              <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>

  </body>
</html>
