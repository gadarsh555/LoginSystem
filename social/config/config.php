<?php
ob_start(); //  turns on output buffering (it saves php data and shows all part of php at once on web browser)
session_start();

  $timezone = date_default_timezone_set("Asia/Kolkata");
  $con = mysqli_connect( "localhost", "root", "","social" );

  if(mysqli_connect_errno())
  {
    echo "Failed to connect: ".mysqli_connect_errno();
    
  }
  ?>