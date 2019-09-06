<?php
require "config/config.php"; // this line adds the contents of the config.php file to this file .

if(isset($_SESSION['username']))
{
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username ='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else
{
   header("Location: register.php");
}
?>

<html>
<head>
    <title>friendbook </title>

    <!-- JAVASCRIPT FILES -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/740c51e510.js"></script>

    <!-- CSS FILES -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body >
  <div >
<div class="top_bar">

     <div class="logo">
    <a href="index.php" ><i class="fab fa-facebook-f"> friendbook</i></a>
    </div>
    
    <nav>
    <a href="<?php  echo $userLoggedIn;?>"><?php echo $user['first_name']." "; ?> <img src="<?php echo $user['profile_pic']; ?>" ></a>
    <a href="#" ><i class="fa fa-home" aria-hidden="true" > Home</i></a>
    <a href="#"><i class="fa fa-envelope" aria-hidden="true"> Messages</i></a>
    <a href="#"><i class="fa fa-bell" aria-hidden="true"> Notifications</i></a>
    <a href="#"><i class="fa fa-users" aria-hidden="true"> Friends</i></a>
    <a href="#"><i class="fa fa-cog" aria-hidden="true"> Settings</i></a>
    <a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt" aria-hidden="true" > Sign out</i></a>
    </nav>
</div>
  
<div class="wrapper parallax">

