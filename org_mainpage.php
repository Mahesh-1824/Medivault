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
    <link rel="stylesheet" href="home.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Monoton&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
  <?php
   session_start();
    ?>
  <nav>
      <div class="container-nav">
        <div class="menu">
          <a href="org_mainpage.php">Home</a>
          <a href="org_notifications.php">Appointments</a>
          <a href="display_pdf.php">My records</a>
          <a href="contactus1.php">Contact Us </a>
          <a href="about1.php">About Us</a>
        </div>
        <div class="signup">
          <a href="signout.php">Signout</a>
        </div>
      </div>
    </nav>
    <div class="parentt">
      <div class="container">
        <h1>MEDI &nbsp; VAULT</h1>
        <p>
          MediVault provides a database to store all medical reports, including
          X-rays, MRI scans, blood test reports and all kinds of medical
          reports. This helps people to access their medical reports from
          anywhere and anytime.
        </p>
        <div class="button">
          <a href="about1.php">Know More</a>
        </div>
      </div>
    </div>
  </body>
</html>