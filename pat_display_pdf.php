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

if (isset($_POST['smit'])) {
  $usrid = $_SESSION['pat_id'];
  $npdf = $_FILES['pdfile']['name'];
  $pdf_type = $_FILES['pdfile']['type'];
  $pdf_size = $_FILES['pdfile']['size'];
  $pdf_tem_loc = $_FILES['pdfile']['tmp_name'];
  $pdf_store = "store/" . $npdf;
  move_uploaded_file($pdf_tem_loc, $pdf_store);
  $sql = "INSERT INTO patdoings (patuserid, patdatapdf) VALUES ('$usrid', '$npdf')";
  $query = mysqli_query($conn, $sql);

  // Redirect to the same page to avoid re-uploading on page refresh
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

if (isset($_POST['smit3'])) {
  $x = $_POST['usr3'];
  $getIndexQuery = "SELECT patpriid FROM patdoings WHERE patpriid='$x'";
      $result = mysqli_query($conn, $getIndexQuery);
      $row = mysqli_fetch_assoc($result);
      $currentIndex = $row['patpriid'];
    
      // Delete the row from the table
      $deleteQuery = "DELETE FROM patdoings WHERE patpriid='$x'";
      mysqli_query($conn, $deleteQuery);
    
      // Update the remaining rows
      $updateQuery = "UPDATE patdoings SET patpriid = patpriid - 1 WHERE patpriid > '$currentIndex'";
      mysqli_query($conn, $updateQuery);

      $maxIndexQuery = "SELECT MAX(patpriid) AS maxIndex FROM patdoings";
  $result = mysqli_query($conn, $maxIndexQuery);
  $row = mysqli_fetch_assoc($result);
  $maxIndex = $row['maxIndex'];

  // Set the new index value
  $newIndex = $maxIndex + 1;

  // Reset the auto-increment value for the table
  $resetAutoIncrementQuery = "ALTER TABLE patdoings AUTO_INCREMENT = $newIndex";
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
  <title>Display pdf</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Calibri", "Trebuchet MS", sans-serif;
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
      /* background: #eee; */
    }

    input,
    textarea {
      width: 90%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #1c87c9;
      outline: none;
    }

    .contact-form form {
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

    .contact-form h2 {
      font-size: 35px;
    }

    .contact-form div {
      position: absolute;
      top: 20%;
      left: 70%;
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

    body {
      height: 100vh;
      background-color: white;
    }

    .file_upload {
      position: fixed;
      height: 100vh;
      width: 25%;
      left: 75%;
      border-left: 3px solid black;
      background-color: white;
    }

    .file_upload * {
      background-color: transparent;
      position: relative;
    }

    .file_upload h2 {
      font-size: 32px;
      color: black;
      position: relative;
      top: 20px;
      left: 25px;
    }

    .search-container {
      display: none;
      width: 65%;
      /* background-color: rgba(0, 0, 0, 0.4); */
      text-align: center;
      position: relative;
      left: 4%;
    }

    .search-box {
      display: flex;
      justify-content: center;
    }

    .search-box input {
      border-radius: 80px;
      background-color: rgb(40, 34, 58);
      color: white;
      width: 85%;
      padding: 15px 30px;
      font-size: 20px;
      font-weight: 0;
    }

    .search-box input[type="submit"] {
      position: relative;
      background-color: transparent;
      right: 50px;
      color: transparent;
      cursor: pointer;
    }

    .search-box i {
      font-size: 20px;
      position: relative;
      z-index: 1;
      color: white;
      left: -5%;
      background-color: transparent;
      padding-top: 16px;
    }
    .search{
      margin-top: -30px;
      margin-left: 70px;
    }
    input {
      border: none;
      outline: none;
      width: fit-content;
    }

    ::placeholder {
      color: #878787;
      align-items: center;
      font-size: 20px;
      top: 3px;
      padding-left: 20px;
    }

    .btn-hide {
      background-color: transparent;
    }

    table {
      width: 85%;
      text-align: center;
      position: relative;
      left: 7%;
      border-radius: 5px;
      padding: 0px;
      /* border:1px solid black; */
      overflow: visible;
      font-family: 'Roboto', sans-serif;
      font-size: 20px;
      background-color: rgb(40, 34, 58);
      border: none;
      box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
    }

    tr {
      /* padding: 5px; */
      margin: 0;
      height:0px;
    }

    th {
      padding: 20px;
      font-weight: 300;
      background-color: rgb(40, 34, 58);
      color: white;

    }

    td {
      /* padding: 7px 15px; */
      vertical-align: middle;
      font-weight: 250;
      background-color: white;
      /* border :1px solid white; */
    }

    .del {
      width: 50px;
      margin: 0px;
      padding: 0px;
    }

    .recent {
      width: 65%;
      position: relative;
      margin-top: 40px;
      left: 1.5%;
    }

    .abc {
      display: flex;
      flex-direction: column;
      margin-top: 6%;
      width: min-content;
      position: relative;
      top:15px;
      left:1050px;
    }

    a {
      text-decoration: none;
      background-color: transparent;
      color: black;
    }

    #btnn {
      color: #f44336;
    }

    #form_label {
      position: relative;
      font-weight: 600;
      padding-top: 7px;
      left: -25px;
    }

    #userid {
      background-color: #e8e9eb;
      border-radius: 25px;
      padding: 10px;
      font-size: 15px;
      font-weight: 500;
    }

    #form_flex {
      flex-direction: row;
      justify-content: center;
      font-size: 20px;
    }

    #smitid2   {
      border-radius: 50%;
      background-color: green;
    }
    #smitid{
      border-radius: 15px;
      background-color: lawngreen
    }
    #search_query {
      border-radius: 40px;
      width: 500px;
      background-color: #eee;
      margin-right: 20px;
    }

    .button .material-symbols-outlined {
      position: relative
    }

    .container-nav {
      margin: 10px auto;
      display: flex;
      justify-content: space-between;
      min-width: 1000px;
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
    #smit3{
      margin:0px;
      background-color: #f44336;
      border-radius: 10px;
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

    #bell {
      /* position: relative;
      left: 65%;
      top: 20%; */
    }

    .signup a {
      border-radius: 0;
      padding: 16px 24px;
      border: 1px solid white;
    }
    td{
      height: 100px;
    }
  </style>
</head>

<body>
  <nav>
    <div class="container-nav">
      <div class="menu">
        <a href="pat_mainpage.php">Home</a>
        <a href="appointment.php">Appointments</a>
        <a href="pat_display_pdf.php">My records</a>
        <a href="about2.php">About Us</a>
        <a href="contactus2.php">Contact Us</a>
      </div>
      <div class="signup">
        <a href="signout.php">Sign Out</a>
      </div>
    </div>
  </nav>

  <?php
  include 'db.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['smit'])) {
      $usrid = $_SESSION['pat_id'];
      $npdf = $_FILES['pdfile']['name'];
      $pdf_type = $_FILES['pdfile']['type'];
      $pdf_size = $_FILES['pdfile']['size'];
      $pdf_tem_loc = $_FILES['pdfile']['tmp_name'];
      $pdf_store = "store/" . $npdf;
      move_uploaded_file($pdf_tem_loc, $pdf_store);
      $sql = "INSERT INTO patdoings (patuserid, patdatapdf) VALUES ('$usrid', '$npdf')";
      $query = mysqli_query($conn, $sql);
    }

    if (isset($_POST['smit3'])) {
      $x = $_POST['usr3'];
    
      // Get the current index of the row being deleted
      $getIndexQuery = "SELECT patpriid FROM patdoings WHERE patpriid='$x'";
      $result = mysqli_query($conn, $getIndexQuery);
      $row = mysqli_fetch_assoc($result);
      $currentIndex = $row['patpriid'];
    
      // Delete the row from the table
      $deleteQuery = "DELETE FROM patdoings WHERE patpriid='$x'";
      mysqli_query($conn, $deleteQuery);
    
      // Update the remaining rows
      $updateQuery = "UPDATE patdoings SET patpriid = patpriid - 1 WHERE patpriid > '$currentIndex'";
      mysqli_query($conn, $updateQuery);
      $maxIndexQuery = "SELECT MAX(patpriid) AS maxIndex FROM patdoings";
  $result = mysqli_query($conn, $maxIndexQuery);
  $row = mysqli_fetch_assoc($result);
  $maxIndex = $row['maxIndex'];

  // Set the new index value
  $newIndex = $maxIndex + 1;

  // Reset the auto-increment value for the table
  $resetAutoIncrementQuery = "ALTER TABLE patdoings AUTO_INCREMENT = $newIndex";
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
      $sql = "SELECT * FROM patdoings WHERE patuserid='{$_SESSION['pat_id']}' AND patdatapdf LIKE '%$searchQuery%'";
      $query = mysqli_query($conn, $sql);
    }
  } else {
    $sql = "SELECT * FROM patdoings WHERE patuserid='{$_SESSION['pat_id']}'";
    $query = mysqli_query($conn, $sql);
  }
  ?>

  <div name="upload_div" class="file_upload">
    <h2>Upload files</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <!-- <div id="form_flex">
        <label for="userid" id="form_label">User ID:</label>
        <input id="userid" type="text" name="usr" value="" placeholder="Enter User ID" />
      </div> -->
      <label id="label_1">
        <input id="pdfid" type="file" name="pdfile" value="" accept=".pdf" title="Upload PDF" required />
      </label>
      <input id="smitid" type="submit" name="smit" value="Upload" onKeyPress="return keyPressed(event)">
    </form>
  </div>

  <!-- <div class="abc">
    <a href="notification.php">
      <span id="notification">Notification</span>
      <span id="icon">
        <img src="bell_icon.png" />
      </span>
    </a>
  </div> -->
  <div class="abc">
    <a href="notification.php">
      <span >
      <i class="fa fa-bell" style="font-size:36px"></i>
      </span></a>
  </div>

  <div name="search_div" class="search">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div id="form_flex">
        <label for="search_query" id="form_label">Search:</label>
        <input id="search_query" type="text" name="usr2" value="" placeholder="Enter file name" />
        <input id="smitid2" type="submit" name="smit2" value="Go" onKeyPress="return keyPressed(event)">
      </div>
    </form>
  </div>

  <div name="recents_div" class="recent">
    <table>
      <tr>
        <th>File ID</th>
        <th>Date</th>
        <th>File Name</th>
        <th>Action</th>
      </tr>
      <?php
      $i = 1;
      while ($info = mysqli_fetch_array($query)) {
        ?>
        <tr>
          <td>
            <?php echo $info['patpriid']; ?>
          </td>
          <td>
            <?php echo $info['patwhenup']; ?>
          </td>
          <td><a href="store/<?php echo $info['patdatapdf']; ?>"><?php echo $info['patdatapdf']; ?></a></td>
          <td class="del">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="usr3" value="<?php echo $info['patpriid']; ?>">
              <input type="hidden" name="filename" value="<?php echo $info['patdatapdf']; ?>">
              <input id = "smit3"type="submit" name="smit3" value="Delete" onKeyPress="return keyPressed(event)">
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