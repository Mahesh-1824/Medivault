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
<?php
  include 'db.php';
  $orgid = $_SESSION['org_id'];
//   echo "<h1>'$orgid'</h1>";
  if(isset($_POST['asub'])){

    $patid = $_POST['hid_patid'];

    $asql="insert into accepted_appointments(patientid,orgid) values('$patid','$orgid')";
    mysqli_query($conn,$asql);

    $sql="DELETE FROM appointment_requests WHERE (orgid='$orgid' and patientid='$patid')";
    mysqli_query($conn,$sql);

  }
  if(isset($_POST['rsub'])){

    $patid = $_POST['hid_patid'];

    $rsql="insert into rejected_appointments(patientid,orgid) values('$patid','$orgid')";
    mysqli_query($conn,$rsql);

    $sql="DELETE FROM appointment_requests WHERE (orgid='$orgid' and patientid='$patid')";
    mysqli_query($conn,$sql);
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="notification.css" />
    <title>Organization Notifications</title>
  </head>
  <body>

    <nav>
      <div class="container-nav">
        <div class="menu">
          <a href="./org_mainpage.php">Home</a>
          <a href="./org_notifications.php">Appointments</a>
          <a href="./about1.php">About</a>
          <a href="./display_pdf.php">My records</a>
          <a href="./contactus1.php">Contact Us </a>
        </div>
        <!-- <div class="signup">
          <a href="./login">Sign In</a>
        </div> -->
      </div>
    </nav>
    <div class="container">
      <h2>Appointment Requests</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <ul class="notification-table">

        <?php
          $sql="select * from appointment_requests where orgid='$orgid'";
          $query = mysqli_query($conn,$sql);
          while($info=mysqli_fetch_array($query)){
        ?>

          <li class="table-row">
              <div class="data"><?php echo $info['patientname']; ?></div>
              <div class="data"><?php echo $info['patientid']; ?></div>
              <div class="data"><?php echo $info['appointment_date']; ?></div>
            
              <input type="hidden" value="<?php echo $info['patientid']; ?>" name="hid_patid" />

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
  </body>

  </html>