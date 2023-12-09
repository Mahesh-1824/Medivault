<?php
	session_start();
 
	if (!isset($_SESSION['id'])) {
		header('location:login.php');
		exit();
	}
  if(time()-$_SESSION["login_time_stamp"] >3600)
  {
  session_unset();
  session_destroy();
  header("Location:login.php");
  }
?>


<?php

  include 'db.php';
  $patid = $_SESSION['pat_id'];

  // echo "<h1>'$patid'</h1>";

  if(isset($_POST['asub'])){

    $npdf = $_POST['hvaldata'];
    $asql="insert into patdoings(patuserid,patdatapdf) values('$patid','$npdf')";
    mysqli_query($conn,$asql);

    $hva = $_POST['hvalorg'];
    $exsql = "DELETE FROM addrequests WHERE (orgid='$hva' and data='$npdf')";
    mysqli_query($conn,$exsql);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;

  }
  if(isset($_POST['rsub'])){

    $npdf = $_POST['hvaldata'];
    $hva = $_POST['hvalorg'];
    $rsql="DELETE FROM addrequests WHERE (orgid='$hva' and data='$npdf')";
    mysqli_query($conn,$rsql);
    
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;

  }
  if(isset($_POST['accepted_ok'])){

    $hva = $_POST['hvalorg'];
    
    $sql="DELETE FROM accepted_appointments WHERE (orgid='$hva' and patientid='$patid')";
    mysqli_query($conn,$sql);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;

  }
  if(isset($_POST['rejected_ok'])){

    $hva = $_POST['hvalorg'];
    
    $sql="DELETE FROM rejected_appointments WHERE (orgid='$hva' and patientid='$patid')";
    mysqli_query($conn,$sql);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;

  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="notification.css" />
    <title>Patient Notifications</title>
  </head>
  <body>

    <nav>
      <div class="container-nav">
        <div class="menu">
          <a href="./pat_mainpage.php">Home</a>
          <a href="./appointment.php">Appointments</a>
          <a href="./pat_display_pdf.php">My records</a>
          <a href="./contactus2.php">Contact Us </a>
          <a href="./about2.php">About Us</a>
        </div>
        <!-- <div class="signup">
          <a href="./login">Sign In</a>
        </div> -->
      </div>
    </nav>
    <div class="container">
      <h2>Accept / Reject requests</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <ul class="notification-table">

        <?php
          $sql="select * from addrequests where patientid='$patid'";
          $query = mysqli_query($conn,$sql);
          while($info=mysqli_fetch_array($query)){
        ?>

          <li class="table-row">
              <div class="data"><?php echo $info['orgname']; ?></div>
              <div class="data"><?php echo $info['requestedon']; ?></div>
              <div class="data"><?php echo $info['data']; ?></div>

              <input type="hidden" value="<?php echo $info['data']; ?>" name="hvaldata" />
              <input type="hidden" value="<?php echo $info['orgid']; ?>" name="hvalorg" />

              <div class="accept"><input type="submit" value="Accept" name="asub" /></div>
              <div class="decline">
              <input
                  type="submit"
                  value="Reject"
                  style="background-color: #f44336"
                  name="rsub"
              />
              </div>
          </li>

        <?php } ?>

        </ul>
      </form>
    </div>




    <div class="container">
      <h2>Appointment Status</h2>

      <h4>Accepted appointments:</h4>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <ul class="notification-table">

        <?php
          $sql="select * from accepted_appointments where patientid='$patid'";
          $query = mysqli_query($conn,$sql);
          while($info=mysqli_fetch_array($query)){
        ?>

          <li class="table-row">
              <div class="data"><?php echo $info['orgid']; ?></div>

              <input type="hidden" value="<?php echo $info['orgid']; ?>" name="hvalorg" />

              <div class="accept"><input type="submit" value="Ok" name="accepted_ok" /></div>

          </li>

        <?php } ?>

        </ul>
      </form>


      <h4>Rejected appointments:</h4>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <ul class="notification-table">

        <?php
          $sql="select * from rejected_appointments where patientid='$patid'";
          $query = mysqli_query($conn,$sql);
          while($info=mysqli_fetch_array($query)){
        ?>

          <li class="table-row">
              <div class="data"><?php echo $info['orgid']; ?></div>

              <input type="hidden" value="<?php echo $info['orgid']; ?>" name="hvalorg" />

              <div class="accept"><input type="submit" value="Ok" name="rejected_ok" /></div>

          </li>

        <?php } ?>

        </ul>
      </form>



    </div>



  </body>

  </html>