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
    <link rel="stylesheet" href="about.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Monoton&display=swap"
      rel="stylesheet"
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
    <div class="header">
    <div class="move"><h2>Explore our Organisation Availabilities </h2></div><br><br>
    <div class="topics">
      <div class="specialist">
        <img src="ammahos.jpeg.jpg"
  
         alt="1">
        <h3><a href="division.htm">Amma Hospital</a></h3>
      </div>
      <div class="specialist"><br>
        <img src= "apolo.jpeg.jpg"  alt="2">
        <h3><a href="division1.htm">Apollo Hospitals</a></h3>
      </div>
      
 <div class="specialist">
        <img src= "cmc.jpeg.jpg" alt="5">
        <h3><a href="division3.html">C.M.C Hospitals</a></h3>
      </div></div></div>
 <div class="header">
    
    <div class="topics">
 <div class="specialist">
        <img src= "./best-hospitals-hyderabad-2.jpg" alt="6">
        <h3><a href="division4.htm">Global Hospitals</a></h3>
      </div> <div class="specialist">
        <img src="./kims.jpeg.jpg" alt="7">
        <h3><a href="division5.htm">KIMS </a></h3>
      </div> 
       <div class="specialist">
        <img src="./stt.jpeg.jpg" alt="10" >
        <h3><a href="division6.htm">St.Johns Medical Hospital</a></h3>
      </div>
    </div>
  </div>
  <div class="header">
    <div class="topics">
     
 <div class="specialist">
        <img src="./Gandhi-Hospital-1-.jpg" alt=" 15">
        <h3><a href="./division7.htm">Gandhi Hospitals</a></h3>
      </div></div></div>
  </body>
</html>