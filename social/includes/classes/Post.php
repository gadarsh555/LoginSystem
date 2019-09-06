<?php
class Post
{
private $con; // here the $con is the  variable of "this" User class only 
private $user_obj; // here the $user is the  variable of "this" User class only 

public function __construct($con,$user)   // here the $con is the connection variable passed to this constructor
  {                                      // here the $user is the  username of user logged in and passed to this function
      // $user has the username of userLoggedIn and $con has the connection variable both are passed to this contructor from index page
     // just after clicking the post button ,  an object of this class was made in index.php

    $this->con = $con;   // the $con variable of this class can be accessed using "this->" .
                         // so "this->user" and "this->con" signifies the private variables of this class .
                        // only $con and $user signify the variables received by this fucntion.
     $this->user_obj = new User($con,$user);
    
  } // __construct
  
  public function submitPost($body,$user_to)
  {
    $body = strip_tags($body); // strip_yags removes html  tags
    $body = mysqli_real_escape_string($this->con,$body);  // this funtion escapes any sepcial character like single quotes(') etc.
    $check_empty = preg_replace('/\s+/','',$body); // this removes all space from the text
    //   \s+ is the symbol for space , "/ /" these surround the symbol to be replaced
    // preg_replace replaces a pattern with another pattern in a string or text
    // synatx of preg_replace(pattern,replacement,subject)
    
     if($check_empty!="") // this checks if the text written by user to post is not just a space
     {                    // beacuse after removing all the spaces if now the text is empty then  this means theere is no text ,so nothimg will be posted istead of posting a space

       // get current date and time
        $date_added = date("Y-m-d H:i:s"); // Y- year, m-month, d-date, H- hours, i-minutes, s- seconds
        // get username
        $added_by = $this->user_obj->getUsername();

        // if user is on own profile, user_to is null
        if($user_to == $added_by) // this line is useful when the user is posting on his own profile then the heading of
        {
            $user_to == "none";
        }

          // insert post
          $query = mysqli_query($this->con,"INSERT INTO posts VALUES(NULL,'$body','$added_by','$user_to',
          '$date_added','no','no','0')"); // this inserts values into the database in table posts
          $returned_id = mysqli_insert_id($this->con); // this returns the id of the post submitted just now.

          // insert notification  


          // update post count for user
          $num_posts = $this->user_obj->getNumPosts();
          $num_posts++;
          $update_query = mysqli_query($this->con,"UPDATE users SET num_posts='$num_posts' WHERE username='$added_by' ");

     }  //  if($check_empty!="")


   }   // submitPost


 

public function loadPostsFriends()
{
      
 


   $str = ""; // string to return
   $time_message="";
   $data = mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC" );
// this above line selects all the posts from the database which are not deleted and saves them in $data variable in descendinjg order 
// that is the latest post is saved first and old posts are saved in last

      while($row = mysqli_fetch_array($data))
      { // this above line one by one gets all the posts saved in the $data variable , latest post first and old post later .
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added']; // DATE and time when the post was added

       // making user_to string to be used even if the post is done on ourselves that is when user_to ="none"
       // $row['user_to] gives the username 
       if($row['user_to'] == "none")
       $user_to ="";
       else
       {
         $user_to_obj = new User($con,$row['user_to']);
         $user_to_name = $user_to_obj->getFirstAndLastName();
         $user_to = " to <a href='".$row['user_to']."'>".$user_to_name."</a>" ;

       }
       // check if the user who posted has their account closed 
       $added_by_obj = new User($this->con,$added_by);
       if($added_by_obj->isClosed())
       {
           continue;
       }     
      $user_details_query = mysqli_query($this->con,"SELECT first_name,last_name,profile_pic FROM users WHERE username = '$added_by' ");
      $user_row = mysqli_fetch_array($user_details_query);
      $first_name = $user_row['first_name'];
      $last_name = $user_row['last_name'];
      $profile_pic = $user_row['profile_pic'];

      //Timeframe
      $date_time_now = date("Y-m-d H:i:s");
      $start_date = new DateTime($date_time);// Time of post
      $end_date = new DateTime($date_time_now); // current time
      $interval = $start_date->diff($end_date); // Difference between dates
      // DateTime id the inbuilt class of php , which can ake date-time as argument
      // it performs several tasks like difference of times and dates etc 

      if($interval->y >= 1) // year is more than 1
      {
          if($interval == 1)
          $time_message = $interval->y." year ago";  // 1 year ago
          else
          $time_message = $interval->y." years ago";  // 1+ year ago
      }

      else if($interval->m >= 1)  // month is more than 1
      {
          if($interval->d == 0)
          $days = " ago";
        else  if($interval->d == 1)
          $days = " day ago";
         else if($interval->d >= 1)
          $days = " days ago";


         if($interval->m ==1)
         $time_message = $interval->m." month".$days;
         if($interval->m >=1)
         $time_message = $interval->m." months".$days;
      }

     else if($interval->d >= 1)   // day is more than 1
      {
        if($interval->d == 1)
        $time_message = "yesterday";
        else 
        $time_message = $interval->d." days ago";
      }

      else if($interval->h >= 1)    // hour is more than 1
      {
        if($interval->h == 1)
        $time_message = $interval->h." hour ago";
        else  
        $time_message = $interval->h." hours ago";
      }

      else if($interval->i >= 1)    // minutes is more than 1
      {
        if($interval->i == 1)
        $time_message = $interval->i." minute ago";
        else  
        $time_message = $interval->i." minutes ago";
      }

      else if($interval->s >= 1)     // seconds is more than 1
      {
        if($interval->s <= 30)
        $time_message = " Just now";
        else  
        $time_message = $interval->s." seconds ago";
      }
      
      // "$str.=" implies "$str=$str." 
      $str .="  <div class='status_border'>
                <div class='status_post'>
                <div class='post_profile_pic'>
               <img src='$profile_pic' width='50' >
               </div>

               <div class='posted_by' style='color:grey;margin-bottom:3px;'>
               <a href='added_by' style='color:blue;'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;
               $time_message
               </div>
               
               <div id='post_body'>
                $body
                 <br>
                 <hr style='color:black;'>
               </div>
               </div>
         </div>"; // status-post 
        

      } // while

  echo $str;


} // loadPostsFriends()



} //  class Post
?>