<?php
class User
{
private $con; // here the $con is the  variable of "this" User class only 
private $user; // here the $user is the  variable of "this" User class only 

public function __construct($con,$user)   // here the $con is the connection variable passed to this constructor
  {                                      // here the $user is the  username of userLoggedIn and passed to this constructor
    // when an object of this class was made in contructor funtion of Post.php
     
    $this->con = $con;   // the $con variable of this class can be accessed using "this->" .
                         // so "this->user" and "this->con" signifies the private variables of this class .
                        // only $con and $user signify the variables received by this fucntion.
     $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username='$user' ");
     $this->user = mysqli_fetch_array($user_details_query);
  }

  public function getUsername()
  {
     return $this->user['username'];
  }
  
  public function getNumPosts()
  {
      $username = $this->user['username'];
      $query = mysqli_query($this->con,"SELECT num_posts FROM users WHERE username='$username' ");
      $row = mysqli_fetch_array($query);
      return $row['num_posts'];
  } 

  public function getFirstAndLastName()
  {
    $username = $this->user['username'];
    $query = mysqli_query($this->con,"SELECT first_name, last_name FROM users WHERE username='$username' ");
   /*   in this only first_name and last_name is taken because it takes less time, if we used * then it would take more time to get 
       everything */ 
    $row = mysqli_fetch_array($query);
    // this line saves the data obtained form the above query in the form of array with index of aaray as column name to the $row variable
    return $row['first_name']." ".$row['last_name'];
  }

  public function isClosed()
  {
      $username= $this->user['username'];
      $query = mysqli_query($this->con,"SELECT user_closed FROM users WHERE username= '$username' ");
      $row = mysqli_fetch_array($query);

      if($row['user_closed'] == 'yes')
       return true;
       else
       return false;

  }

}



?>