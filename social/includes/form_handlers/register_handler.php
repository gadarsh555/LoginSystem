<?php

$fname = ""; // first name
$lname = ""; //last name
$em = "";//email
$em2 = "";//email2
$password="";//password
$password2="";//password 2
$profile_pic="";
$date="";//sign up date
$error_array=array();//holds error messages


if(isset($_POST['register_button']))   // this line means register button is cliclked.
{
    //Registration form values
    
// validating first name
$fname = strip_tags($_POST['reg_fname']);// remove html tage
$fname = str_replace(' ','',$fname);// remove spaces
$fname = ucfirst(strtolower($fname));//uppercase first letter
$_SESSION['reg_fname']=$fname; // stores first name into session variable    
    
    //validating last name
$lname = strip_tags($_POST['reg_lname']);// remove html tage
$lname = str_replace(' ','',$lname);// remove spaces
$lname = ucfirst(strtolower($lname));//uppercase first letter
$_SESSION['reg_lname']=$lname; // stores last name into session variable     
    
    //validating email
$em = strip_tags($_POST['reg_email']);// remove html tage
$em = str_replace(' ','',$em);// remove spaces
$em = ucfirst(strtolower($em));//uppercase first letter
$_SESSION['reg_email']=$em; // stores email into session variable    
    
     //validating email 2
$em2 = strip_tags($_POST['reg_email2']);// remove html tage
$em2 = str_replace(' ','',$em2);// remove spaces
$em2 = ucfirst(strtolower($em2));//uppercase first letter
$_SESSION['reg_email2']=$em2; // stores email2 into session variable  
    
     //validating password
$password = strip_tags($_POST['reg_password']);// remove html tage
$_SESSION['reg_password']=$password; // stores password into session variable  
    
     //validating password 2
$password2 = strip_tags($_POST['reg_password2']);// remove html tage
$_SESSION['reg_password2']=$password2; // stores password2 into session variable  
    
    $date= date("Y-m-d"); // current date
   
    
    if($em == $em2)
    {
        //check if email is in corect format or validating email
        if(filter_var($em,FILTER_VALIDATE_EMAIL))
        {
            $em = filter_var($em,FILTER_VALIDATE_EMAIL);
            //  check if email already exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em' ");
            // count the number of rows
            $num_rows = mysqli_num_rows($e_check);
            if($num_rows > 0)
             array_push($error_array,"<br>Email already in use<br>");
                             
        }
        else
       array_push($error_array,"<br>Invalid format<br>");
        
    }
    
   else
   array_push($error_array," <br> Email's don't match <br>");
    
    
    if(strlen($fname)>25 || strlen($fname)<2 )
   array_push($error_array,"<br>First name should be between 2 to 25 characters<br>");
    
    if(strlen($lname)>25 || strlen($lname)<2 )
   array_push($error_array,"<br>last name should be between 2 to 25 characters<br>");


   if($password != $password2)
   array_push($error_array,"<br>Passwords do not match<br>");
   else
   {
    if(preg_match('/[^A-Za-z0-9]/', $password)) //finds a character other than the allowed characters
   array_push($error_array,"<br>Your pasword can only contain english letters and numbers<br>");
   }
    
    if(strlen($password)>30 || strlen($password)<5)
   array_push($error_array,"<br>Your password must be between  30 and 5 characters<br>");
    
    
    if(empty($error_array))
    {
        
    $password = md5($password); // encrypt password before sending to the database
    
    // generate username by concatenationg first name and last name
    $username2 =  $username = strtolower($fname."_".$lname);
    
    // check if the username already exists
    
    $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
    $i=0;
    
    while(mysqli_num_rows($check_username_query)!=0)
    {     $i++;
        $username = $username2;
        $username = $username."_".$i;
        $check_username_query = mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
    }
        
        $rand = rand(1,5);
        //profile pic assignment
       switch($rand)
        {
            case 1 :  $profile_pic ="assets/images/profile_pics/defaults/head_amethyst.png"; break;
                
            case 2 :  $profile_pic ="assets/images/profile_pics/defaults/head_deep_blue.png"; break;
                
            case 3 :  $profile_pic ="assets/images/profile_pics/defaults/head_nephritis.png"; break;
                
            case 4 :  $profile_pic ="assets/images/profile_pics/defaults/head_red.png"; break;
                
            case 5 :  $profile_pic ="assets/images/profile_pics/defaults/head_sun_flower.png"; break;
                
        }
        
        /*if($rand == 1)
        $profile_pic ="assets/images/profile_pics/defaults/head_amethyst.png";
        else
        $profile_pic ="assets/images/profile_pics/defaults/head_amethyst.png";
        */
        $query = mysqli_query($con, "INSERT INTO users VALUES (NULL,'$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
        array_push($error_array,"<br><br><span style=color:'green';>Your Acoount Is Registered Successfully !</span>");
        // CLEAR SESSIONS VARIABLE
        
        /* $_SESSION=NULL; */
       
      $_SESSION['reg_fname']="";
       $_SESSION['reg_lname']="";
       $_SESSION['reg_email']="";
       $_SESSION['reg_email2']="";
      
    }
    
    
 }
   

?>