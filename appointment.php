<?php session_start(); ?>
<?php
  include 'db.php';

  if(isset($_POST['appoint_request'])){
    $patid = $_POST['patientId'];
    $orgid = $_POST['doctorId'];
    $adate = $_POST['date'];

    $sql="insert into appointment_requests(patientid,orgid,appointment_date) values('$patid','$orgid','$adate')";
    mysqli_query($conn,$sql);
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
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet" />
  </head>
  <body>
  <nav>
      <div class="container-nav">
        <div class="menu">
          <a href="pat_mainpage.php">Home</a>
          <a href="appointment.php">Appointments</a>
          <a href="pat_display_pdf.php">My records</a>
          <a href="about2.php">About Us</a>
          <a href="contactus2.php">Contact Us </a>
        </div>
        <div class="signup">
          <a href="signout.php">Signout</a>
        </div>
      </div>
    </nav>
    <style>
      /* CSS Styles */
      body {
        font-family: Arial, sans-serif;
        background-color: #F2F5FA;
      }

      .container {
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        background-color: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }

      h1 {
        text-align: center;
        color: #333333;
        margin-top: 30px; /* Added margin-top */
      }

      label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555555;
      }

      .input-container {
        position: relative;
      }

      .input-container i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #888888;
      }

      input[type="text"],
      input[type="email"],
      select,
      textarea {
        width: 100%;
        padding: 8px;
        padding-left: 30px;
        border: 1px solid #CCCCCC;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
        color: #333333;
      }

      button {
        background-color: #2980B9;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
      }

      button:hover {
        background-color: #1E6091;
      }

      .message {
        margin-top: 10px;
        padding: 10px;
        background-color: #E6ECF0;
        border: 1px solid #CCCCCC;
        color: #333333;
      }
    </style>
    <div class="container">
      <h1>Doctor Appointment</h1>
      <form id="appointmentForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="input-container">
          <i class="fas fa-user-md"></i>
          <input type="text" id="doctorId" name="doctorId" placeholder="Doctor's User ID" required>
        </div>

        <div class="input-container">
          <i class="fas fa-hospital"></i>
          <input type="text" id="hospitalName" name="hospitalName" placeholder="Hospital Name" required>
        </div>

        <div class="input-container">
          <i class="fas fa-user"></i>
          <input type="text" id="name" name="name" placeholder="Name" required>
        </div>

        <div class="input-container">
          <i class="fas fa-user"></i>
          <input type="text" id="patientId" name="patientId" value="<?php $_SESSION['pat_id']; ?>" placeholder="Patient's User ID" required>
        </div>

        <div class="input-container">
          <i class="fas fa-envelope"></i>
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-container">
          <i class="fas fa-phone"></i>
          <input type="text" id="phone" name="phone" placeholder="Phone" required>
        </div>

        <div class="input-container">
          <i class="fas fa-calendar-alt"></i>
          <input type="date" id="date" name="date" required>
        </div>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4"></textarea>

        <button type="submit" name="appoint_request">Submit</button>
      </form>
      <div id="responseMessage" class="message"></div>
    </div>
  </body>
</html>
