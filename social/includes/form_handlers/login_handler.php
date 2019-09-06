

<?php

if(isset($_POST['login_button'])) 
{

    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); // sanitize email
    $_SESSION['log_email'] = $email; // save email into session variable

    $password = md5($_POST['log_password']); // get password in to encrypted format

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1) // that is if the email and password is present in the database.
    {
        // this saves the entire row of the user who enetered email and password  into the $row in form of array 
        // with the column name as the index and data as value of that index.
        $row = mysqli_fetch_array($check_database_query);

       // this line saves the value in username index of the array $row that is it saves the username of the person in variable
       $username = $row['username'];

       $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes' ");
       if(mysqli_num_rows($user_closed_query) == 1)
       {
           $reopen_account = mysqli_query($con , "UPDATE users SET user_closed='no' WHERE email='$email' ");
       }

      $_SESSION['username'] = $username;
       header("Location: index.php");
       exit();
    }
    
    else
    {
        array_push($error_array, "<br> Email or Password is incorrect");
    }


}


?>