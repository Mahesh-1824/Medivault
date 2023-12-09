<?php
	session_start();
 
	if (!isset($_SESSION['id_org'])) {
		header('location:login_admin.php');
		exit();
	}
  if(time()-$_SESSION["login_time_stamp_org"] >3600)
  {
  session_unset();
  session_destroy();
  header("Location:login_admin.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="contactus.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Monoton&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
  <nav>
      <div class="container-nav">
        <div class="menu">
          <a href="org_mainpage.php">Home</a>
          <a href="org_notifications.php">Appointments</a>
          <a href="display_pdf.php">My records</a>
          <a href="about1.php">About Us</a>
          <a href="contactus1.php">Contact Us </a>
        </div>
        <div class="signup">
          <a href="signout.php">Signout</a>
        </div>
      </div>
    </nav>
    <h1>Contact &nbsp; Us</h1>
    <div class="container">
        
      <div class="sub">
        <i class="fa fa-solid fa-phone" style="font-size: 52px"></i>
        <h2>By phone</h2>
        <h3>( Monday to Friday 9:00 am to 4:00 pm IST)</h3>
        <p>Toll-Free</p>
        <p>+91 1234567890</p>
      </div>
      <div class="sub email">
        <i class="fa fa-regular fa-envelope" style="font-size: 52px"></i>
        <h2>Email</h2>
        <p>Send us your queries by Email</p>
        <p style="font-weight: 400">bl.en.u4aie22xyz@students.amrita.edu</p>
      </div>
      <div class="sub">
        <i class="fa fa-solid fa-map" style="font-size: 52px"></i>
        <h2>Reach out</h2>
        <h3>( Monday to Friday 9:00 am to 3:00 pm IST)</h3>
        <p>Amrita College of Engineering</p>
        <p>Bengaluru , Karnataka</p>
      </div>
    </div>
  </body>
</html>