<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="login.css">
    <link
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Monoton&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    </head>
   <body>

    <div class="container">
    <div class="box-container">
        <div class="login-image"></div>
    <div class="screen">
    <h1>SIGN IN</h1>
    <div id="toggle-btn2">
        <p id="individual" class="solid2"><a href="login.php">Patient </p></a>
        <p id="organization" class="line2"><a href="login_admin.php">Organization</p></a>
      </div>

    <form class="login" action="login.php" method="post">
       
    <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>
        
         <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
        <input type="text" name="userid" class="login_input" required placeholder="User ID">
    </div>
    <div class="login_field">
              <i class="login_icon fa fa-solid fa-user"></i>
        <input type="text" name="username" class="login_input" required placeholder="Username">
    </div>
    <div class="login_field">
        <i class="login_icon fa fa-lock"></i>
       <input type="password" name="password" class="login_input" required placeholder="Password">
       </div>
        <div class="button_text">
        <input type="submit" name="submit" value="Sign In" class="button login_submit">
     <span class="material-symbols-outlined">
keyboard_double_arrow_right
</span>
    </div>
        <div class="sign-up">
        <p>Don't have an account?&nbsp; <a href="register.php">Sign up</a></p>
    </div>
    </form>
    </div>
    </div>
    </div>
   
    <?php
      session_start();
   echo "<div class='form-container'>";
     $conn = mysqli_connect('localhost','root','','healthcare');
     if(isset($_POST['submit'])){

        $Userid = mysqli_real_escape_string($conn,$_POST['userid']);
        $Username = mysqli_real_escape_string($conn,$_POST['username']);

        $_SESSION['pat_id']=$Userid;
        $_SESSION['pat_name']=$Username;

        $pass = md5($_POST['password']);
        $select = 'SELECT * FROM patient WHERE userid = "'.$_POST["userid"].'"';
        $result = $conn->query($select);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["userid"]=== $Userid) {
                    if ($row["password"]=== md5($_POST["password"])){
                        echo"<script>window.location.href='pat_mainpage.php'</script>";   
                    } 
                    else{
                        echo"<script>alert('Incorrect password')</script>";    
                    }               
               
                }
                   

                }
            }
      else {
        echo"<script>alert('Incorrect Username')</script>";         

      }
      $conn->close();
    }
    echo "</div>";
    ?>
    
   </body> 

</html>