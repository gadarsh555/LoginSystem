<?php

require "config/config.php"; // this line adds the contents of the config.php file to this file .
require "includes/form_handlers/register_handler.php";  
require "includes/form_handlers/login_handler.php";   

?>

<html>
<head>
<title>Welcome to Friendbook</title>

<!-- JAVASCRIPT FILES -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="assets/js/register.js"></script>
<script src="https://kit.fontawesome.com/740c51e510.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>
    
    <?php
    if(isset($_POST['register_button']))
    {
        echo '
        <script>
        $(document).ready(function(){
        $("#first").hide();
        $("#second").show();
        });    
            
        </script>
        ';
        
        
    }
    ?>
<div class="top_bar">  

   <div class="logo">
    <a href="register.php" ><i class="fab fa-facebook-f"> friendbook</i></a>
    </div>    

</div>

<div class="wrapper">
<div class="detail">
<h1 style="padding-top:15px;"><b>f</b>riendbook <b>h</b>elps <b>y</b>ou <b>c</b>onnect <b>a</b>nd <b>s</b>hare <b>w</b>ith <b>t</b>he <b>p</b>eople <b>a</b>round <b>a</b>nd <b>a</b>cross <b>t</b>he <b>w</b>orld.</h1>
</div>
<div class="login_box">
<div class="login_header"> 
  <h1>friendsbook</h1>  
    Login or Sign up below !
</div>
  <div id="first">
        <form action="register.php" method="post">   <!--  LOGIN FORM -->
        <input type="email" name="log_email" placeholder="Email Address" value="<?php 
          if(isset($_SESSION['log_email']))
              echo $_SESSION['log_email'];
        ?>" required><br>

        <input type="password" name="log_password" placeholder="Password" required><br>
            <?php
            if(in_array("<br> Email or Password is incorrect",$error_array))
            echo "<p  style='color:red;margin:0px;'>Email or Password is incorrect</p>";
        ?>
            <br>
        <input type="submit" name="login_button" value="Login">
            <br>
        <a href="#" id="signup" class="signup">Need an account? Sign Up here!</a>
      </form>
</div>
    

 <div id="second">
      <form action="register.php" method="post"><!-- Register form -->
        <input type="text" name="reg_fname" placeholder=" First Name"  value="<?php 
          if(isset($_SESSION['reg_fname']))
              echo $_SESSION['reg_fname'];
        ?>" required><br>

            <?php
            if(in_array("<br>First name should be between 2 to 25 characters<br>",$error_array))
            echo "<p  style='color:red;margin-top:0px;'>First name should be between 2 to 25 characters<br></p>";
            ?>
            <!-- in_array() checks whether the given string is present in the array or not -->

        <input type="text" name="reg_lname" placeholder="Last Name"   value="<?php 
          if(isset($_SESSION['reg_lname']))
              echo $_SESSION['reg_lname'];
        ?>" required><br>

            <?php
            if(in_array("<br>last name should be between 2 to 25 characters<br>",$error_array))
            echo "<p  style='color:red;margin-top:0px;'>last name should be between 2 to 25 characters<br></p.";
            ?>

        <input type="text" name="reg_email" placeholder="Email"   value="<?php 
          if(isset($_SESSION['reg_email']))
              echo $_SESSION['reg_email'];
        ?>" required><br>

        <input type="text" name="reg_email2" placeholder="Confirm email"   value="<?php 
          if(isset($_SESSION['reg_email2']))
              echo $_SESSION['reg_email2'];
        ?>" required><br>

        <?php
        if(in_array("<br>Email already in use<br>",$error_array)) echo "<p  style='color:red;margin-top:0px;'>Email already in use<br><p>";
        else if(in_array("<br>Invalid format<br>",$error_array)) echo "<p  style='color:red;margin-top:0px;'>Invalid format<br></p>";
        else if(in_array(" <br> Email's don't match <br>",$error_array)) echo "<p  style='color:red;margin-top:0px;'>Email's don't match <br></p>";
            ?>

        <input type="password" name="reg_password" placeholder="Password" required><br>

        <input type="password" name="reg_password2" placeholder="Confirm password"  required><br> 


            <?php
        if(in_array("<br>Passwords do not match<br>",$error_array)) echo "<p  style='color:red;margin-top:0px;'>Passwords do not match<br></p>";
        else if(in_array("<br>Your pasword can only contain english letters and numbers<br>",$error_array)) 
        echo "<p  style='color:red;margin-top:0px;'>Your pasword can only contain english letters and numbers<br></p>";
        else if(in_array("<br>Your password must be between  30 and 5 characters<br>",$error_array)) 
        echo  "<p  style='color:red;margin-top:0px;'>Your password must be between  30 and 5 characters<br></p>";
            ?>

        <input type="submit" name="register_button" value="Register">

        <?php
        if(in_array("<br><br><span style=color:'green';>Your Acoount Is Registered Successfully !</span>",$error_array)) 
        echo "<br><br><span style='color:green;'>Your Acoount Is Registered Successfully !</span><br>";
        ?>
            <br>
        <a href="#" id="signin"  class="signin">Already have an account? Sign in here!</a>
     </form>    
 </div>
   

</div>
</div>

</body>

</html>
