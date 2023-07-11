<?php session_start(); ?>
<?php
include 'db.php';

if(isset($_POST['smit'])){
    $patid=null;
    if(null !== $_POST['usr']){
        $patid=$_POST['usr'];
    }
    $checkQuery = "SELECT * FROM patient WHERE userid = '$patid'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $patientExists = mysqli_num_rows($checkResult) > 0;
    if ($patientExists) {
        $npdf=$_FILES['pdfile']['name'];
        $pdf_type=$_FILES['pdfile']['type'];
        $pdf_size=$_FILES['pdfile']['size'];
        $pdf_tem_loc=$_FILES['pdfile']['tmp_name'];
        $pdf_store="store/".$npdf;
        move_uploaded_file($pdf_tem_loc,$pdf_store);
        $sql="insert into docdoings(orgid,patientid,datapdf) values('{$_SESSION['org_id']}','$patid','$npdf')";
        $query=mysqli_query($conn,$sql);
        
        $orgid = $_SESSION['org_id'];
        $orgname = $_SESSION['org_name'];
                        
        $sql2 = "insert into addrequests(orgid,orgname,patientid,data) values('$orgid','$orgname','$patid','$npdf')";
        mysqli_query($conn,$sql2);}
        else{
          echo"<script>alert('Patient ID does not exist')</script>";
        }


    // Redirect to the same page to avoid re-uploading on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();}
if (isset($_POST['smit3'])) {
    $x = $_POST['usr3'];
      $getIndexQuery = "SELECT priid FROM docdoings WHERE priid='$x'";
      $result = mysqli_query($conn, $getIndexQuery);
      $row = mysqli_fetch_assoc($result);
      $currentIndex = $row['priid'];
    $sql = "DELETE FROM docdoings WHERE priid='$x'";
    mysqli_query($conn, $sql);

         // Update the remaining rows
      $updateQuery = "UPDATE docdoings SET priid = priid - 1 WHERE priid > '$currentIndex'";
      mysqli_query($conn, $updateQuery);

      $maxIndexQuery = "SELECT MAX(priid) AS maxIndex FROM docdoings";
  $result = mysqli_query($conn, $maxIndexQuery);
  $row = mysqli_fetch_assoc($result);
  $maxIndex = $row['maxIndex'];

  // Set the new index value
  $newIndex = $maxIndex + 1;

  // Reset the auto-increment value for the table
  $resetAutoIncrementQuery = "ALTER TABLE docdoings AUTO_INCREMENT = $newIndex";
  mysqli_query($conn, $resetAutoIncrementQuery);

    // Redirect to the same page after deleting the record
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Display pdf</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <style>
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Calibri", "Trebuchet MS",sans-serif;
        /* border:1px solid lime; */
      }
      .modal {
        display: none;
        position: fixed;
        z-index: 7;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        height: 40%;
        overflow: auto;
        background-color: #a1a1a1;
        border-radius: 5px;
        color: white;
      }
      .modal-content {
        margin: 50px auto;
        /* border: 1px solid #999; */
        width: 60%;
      }
      h2,
      p {
        margin: 0 0 20px;
        font-weight: 400;
      }
      span {
        display: block;
        padding: 0 0 5px;
      }
      form {
       
        box-shadow: 0 2px 5px #f5f5f5;
      }
      input,
      textarea {
        width: 90%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #1c87c9;
        outline: none;
      }
      .contact-form form{
        display: none;
      }
      .contact-form button {
        width: 100%;
        padding: 10px;
        border: none;
        background: #1c87c9;
        font-size: 16px;
        font-weight: 400;
        color: #fff;
      }
      .contact-form  h2{
        font-size: 35px;
      }
      .contact-form div{
        position: absolute;
        top:20%;
        left:70%;
      } 
      button:hover {
        background: #2371a0;
      }
      .close {
        color: black;
        float: right;
        font-size: 48px;
        font-weight: bold;
      }
      .close:hover,
      .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
      }
      button.button {
        background: none;
        border-top: none;
        outline: none;
        border-right: none;
        border-left: none;
        border-bottom: #02274a 1px solid;
        padding: 0 0 3px 0;
        font-size: 16px;
        cursor: pointer;
      }
      button.button:hover {
        border-bottom: #a99567 1px solid;
      }
      body{
        height :100vh;
        background-color: white;
      }

      .file_upload{
        position: fixed;
        height:100vh;
        width:25%;
        left:75%;
        margin-top: 100px;
        border-left:3px solid black;
        background-color: white;
      }
      .file_upload *{
        background-color: transparent;
        position: relative;
      }

      .file_upload h2{
        font-size: 32px;
        color:black;
        position: relative;
        top:20px;
        left:25px;
      }
      .search-container{
        width: 65%;
        /* background-color: rgba(0, 0, 0, 0.4); */
        text-align: center;
        position: relative;
        left:4%;
      }
      
      .search-box{
        display: flex;
        justify-content: center;
      }
      .search-box input{
        border-radius:80px;
        background-color: rgb(40,34,58);
        color: white;
        width: 85%;
        padding: 15px 30px;
        font-size:20px;
        font-weight: 0;
      }
      .search-box input[type="submit"]{
        position:relative;
        background-color: transparent;
        right:50px;
        color:transparent;
        cursor: pointer;
      }
      .search{
      margin-top: 100px;
      margin-left: -670px;
    }
    #search_query {
      border-radius: 40px;
      width: 500px;
      background-color: #eee;
      margin-right: 20px;
    }
      .search-box i{
        font-size:20px;
        position :relative;
        z-index: 1;
        color:white;
        left:-5%;
        background-color: transparent;
        padding-top: 16px;
      }
      input{
        border:none;
        outline:none;
        width: fit-content;
      }
      ::placeholder{
        color:#878787;
        align-items: center;
        font-size: 20px;
        top:3px;
        padding-left:20px;
      }
      .btn-hide{
        background-color: transparent;
      }
      table{
        width: 85%;
        text-align: center;
        position: relative;
        left:7%;
        border-radius: 5px;
        padding: 0px;
        /* border:1px solid black; */
        overflow: visible;
        font-family: 'Roboto', sans-serif;
        font-size:20px;
        background-color: rgb(40,34,58);
        border:none;
        box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
      }
      tr{
        padding:5px; 
      }
      th{
          padding: 20px;
          font-weight: 300;
          background-color: rgb(40,34,58);
          color:white;
          
       }
      td{
            padding: 7px 15px;
            vertical-align:middle;
            font-weight: 250;
            background-color: white;
            /* border :1px solid white; */
        }
      .del{
            width:50px;
            padding: 5px;
           
          }
      .recent{
        width: 65%;
        position: relative;
        margin-top: 40px;
        left:1.5%;
      }
      .abc{
        display: flex;
        flex-direction: column;
        margin-top: 6%;
      }
      a{
        text-decoration: none;
        background-color: transparent;
        color:black;
      }
      #btnn {
        color:#f44336;
      }
      #form_label{
        position: relative;
        font-weight: 600;
        padding-top: 7px;
        left:-25px;
      }
      #userid{
        background-color:#e8e9eb;
        border-radius: 25px;
        padding: 10px;
        font-size: 15px;
        font-weight: 500;
      }
      #form_flex{
        display: flex;
        flex-direction: row;
        justify-content: center;
        font-size:20px;
      }
       tr, td, th{
        
    }
    .button .material-symbols-outlined{
      position: relative
    }
.container-nav {
  margin: 10px auto;
  display: flex;
  justify-content: space-between;
  min-width: 900px;
}

#smitid{
  border-radius: 10px;
  background-color: #e74a14;
}
.menu,
.signup {
  display: inline-block;
  justify-content: flex-end;
  margin: 0 40px;
  gap: 1rem;
}
.menu a,
.signup a {
  color: #fff;
  text-decoration: none;
  font-weight: 400;
  font-size: 18.5px;
  transition: 0.4s;
  padding: 10px 25px;
  margin: 0 5px;
  border-radius: 100px;
}
.menu a:hover,
.signup a:hover {
  background-color: #e74c14;
}

nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 99;
  padding: 16px 32px;
  background-color: #212121;
  border-bottom: 3px solid #e74c14;
   font-family: "fantasy", "Gill Sans", "Gill Sans MT", "Calibri", "Trebuchet MS",
    sans-serif;
}
#smit3{
  margin:0px;
  background-color: #f44336
  ;border-radius: 10px;
}
#smitid2   {
      border-radius: 50%;
      background-color: green;
    }
.signup a {
  border-radius: 0;
  padding: 16px 24px;
  border: 1px solid white;
}
/  
      /* #label_1{
        background-color:  #4caf50;
        color: white;
        padding:12px;
      } */ */
    </style>
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
          <a href="signout.php">Sign Out</a>
        </div>
      </div>
  </nav>

  <?php
  include 'db.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['smit'])){
        $patid=null;
        if(null !== $_POST['usr']){
            $patid=$_POST['usr'];
        }
        // Check if the patient ID exists in the patient table
    $checkQuery = "SELECT * FROM patient WHERE userid = '$patid'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $patientExists = mysqli_num_rows($checkResult) > 0;
    if ($patientExists) {
        $npdf=$_FILES['pdfile']['name'];
        $pdf_type=$_FILES['pdfile']['type'];
        $pdf_size=$_FILES['pdfile']['size'];
        $pdf_tem_loc=$_FILES['pdfile']['tmp_name'];
        $pdf_store="store/".$npdf;
        move_uploaded_file($pdf_tem_loc,$pdf_store);
        $sql="insert into docdoings(orgid,patientid,datapdf) values('{$_SESSION['org_id']}','$patid','$npdf')";
        $query=mysqli_query($conn,$sql);
        
        $orgid = $_SESSION['org_id'];
        $orgname = $_SESSION['org_name'];
                        
        $sql2 = "insert into addrequests(orgid,orgname,patientid,data) values('$orgid','$orgname','$patid','$npdf')";
        mysqli_query($conn,$sql2);}
        else{
          echo"<script>alert('Patient ID does not exist')</script>";
        }
    }

    if (isset($_POST['smit3'])) {
        $x = $_POST['usr3'];
        $getIndexQuery = "SELECT priid FROM docdoings WHERE priid='$x'";
      $result = mysqli_query($conn, $getIndexQuery);
      $row = mysqli_fetch_assoc($result);
      $currentIndex = $row['priid'];
        $sql = "DELETE FROM docdoings WHERE priid='$x'";
        mysqli_query($conn, $sql);

                // Update the remaining rows
      $updateQuery = "UPDATE docdoings SET priid = priid - 1 WHERE priid > '$currentIndex'";
      mysqli_query($conn, $updateQuery);

      $maxIndexQuery = "SELECT MAX(priid) AS maxIndex FROM docdoings";
  $result = mysqli_query($conn, $maxIndexQuery);
  $row = mysqli_fetch_assoc($result);
  $maxIndex = $row['maxIndex'];

  // Set the new index value
  $newIndex = $maxIndex + 1;

  // Reset the auto-increment value for the table
  $resetAutoIncrementQuery = "ALTER TABLE docdoings AUTO_INCREMENT = $newIndex";
  mysqli_query($conn, $resetAutoIncrementQuery);
      // Delete the file from the directory
      $filename = $_POST['filename']; // Get the filename from the form
      $filepath = 'store/' . $filename; // Path to the file
      if (file_exists($filepath)) {
        unlink($filepath); // Delete the file
      }
    }

    if (isset($_POST['smit2']) && isset($_POST['usr2'])) {
      $searchQuery = $_POST['usr2'];
      $sql = " SELECT * FROM docdoings WHERE orgid='{$_SESSION['org_id']}' AND ( patientid LIKE '%$searchQuery%' ) ";
      $query = mysqli_query($conn, $sql);
    }
  } else {
    $sql = "SELECT * FROM docdoings WHERE orgid='{$_SESSION['org_id']}'";
    $query = mysqli_query($conn, $sql);
  }
  ?>


  <div name="upload_div" class="file_upload">
    <h2>Upload files</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div id="form_flex"><label for="userid" id="form_label">Patient ID:</label>
        <input id="userid" type="text" name="usr" value="" placeholder="Enter Patient ID" /></div>
        <label id="label_1">
        <input id="pdfid" type="file" name="pdfile" value="" accept=".pdf"title="Upload PDF" />
        <label>
        <input id="smitid" type="submit" name="smit" value="Upload" onKeyPress="return keyPressed(event)">
    </from>
  </div>

  <!-- <div class="abc">
    <a href="notification.php">
      <span id="notification">Notification</span>
      <span id="icon">
        <img src="bell_icon.png" />
      </span>
    </a>
  </div> -->

  <div name="search_div" class="search">
    <h2>Search files</h2>
    <div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div id="form_flex">
          <label for="search_query" id="form_label">Search:</label>
          <input id="search_query" type="text" name="usr2" value="" placeholder="Enter Patient ID or filename" />
          <input id="smitid2" type="submit" name="smit2" value="Go" onKeyPress="return keyPressed(event)">
        </div>
      </form>
    </div>
  </div>

  <div name="recents_div" class="recent">
    <h2>Medivault of <?php echo $_SESSION['org_name']; ?></h2>
    <table>
      <tr>
        <th>File ID</th>
        <th>Patient ID</th>
        <th>Date</th>
        <th>File Name</th>
        <th>Action</th>
      </tr>
      <?php
      $i = 1;
      while ($info = mysqli_fetch_array($query)) {
        ?>
        <tr>
          <td><?php echo $info['priid']; ?></td>
          <td><?php echo $info['patientid']; ?></td>
          <td><?php echo $info['whenup']; ?></td>
          <td><a href="store/<?php echo $info['datapdf']; ?>"><?php echo $info['datapdf']; ?></a></td>
          <td class="del">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="usr3" value="<?php echo $info['priid']; ?>">
              <input type="hidden" name="filename" value="<?php echo $info['datapdf']; ?>">
              <input id = 'smit3'type="submit" name="smit3" value="Delete" onKeyPress="return keyPressed(event)">
            </form>
          </td>
        </tr>
      <?php
        $i++;
      }
      ?>
    </table>
  </div>

  <script>
    function keyPressed(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        return false;
      }
    }
  </script>
</body>
</html>