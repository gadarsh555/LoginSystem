<?php
include("includes/header.php"); // this brings the code from header fle to this file
include("includes/classes/User.php"); // this connects User.php to this files
include("includes/classes/Post.php"); // this connects Post.php to this files

if(isset($_POST['post'])) // just after clicking the post button this is invoked 
{
    $post = new Post($con,$userLoggedIn); // constructor of Post funtion is called
    $post->submitPost($_POST['post_text'],'none');
}
?>
     

    <div class="user_details column">
    <a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>
    <div class="user_details_left_right">
    <a href="<?php  echo $userLoggedIn;?>"><?php echo $user['first_name']." ".$user['last_name']; ?></a>
    <br>
    <?php echo "Posts :".$user['num_posts']."<br>"?>
    <?php echo "Likes :".$user['num_likes'];?>
   
</div>
</div>

<div class="main_column">
 <form class="post_form" action="index.php" method="POST">
<textarea name="post_text" id="post_text" placeholder="Got something to say!" onclick="show()"></textarea> <!-- when the textarea is clicked this show function is called -->
<input type="submit" id="post_button" name="post" value="Post" onclick="hide()" > <!-- when the button is pressed this hide function is called -->
</form>

<div  class="posts_area" style="width:100%;height:100%;"><?php $post->loadPostsFriends() ?></div> <!-- DIV CONTAINING POSTS-->
<img id="loading" src="assets/images/icons/loading.gif" >

</div> 
</div><!--parallav-->
<!-- ajax calls the database without having to load the page again, it helps in infifnite scrolling property -->
    
<script>
var userLoggedIn = '<?php echo $userLoggedIn; ?>';

$(document).ready(function() {

    $('#loading').show();

    //Original ajax request for loading first posts 
    $.ajax({
        url: "includes/handlers/ajax_load_posts.php",
        type: "POST",
        data: "page=1&userLoggedIn=" + userLoggedIn,
        cache:false,

        success: function(data) {
            $('#loading').hide();
            $('.posts_area').html(data); // this means rhat whenm the loading is complete hide the loading gif and put the data into
                                         // the posts_area div 
        }
    });

    $(window).scroll(function() {
      var height = $('.posts_area').height(); // div containing posts
      var = scroll_top = $(this).scrollTop();
      var page = $('posts_area').find('.nextPage').val();
      var noMorePosts = $('.posts_area').find('.noMorePosts').val();
      
      if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false')
      {
        $('#loading').show();
           //Original ajax request for loading first posts 
      var ajaxReq =  $.ajax({
        url: "includes/handlers/ajax_load_posts.php",
        type: "POST",
        data: "page="+ page +"&userLoggedIn=" + userLoggedIn,
        cache:false,

        success: function(response) {
            $('.posts_area').find('.nextPage').remove(); // removes current .nextPage
            $('.posts_area').find('.noMorePosts').remove(); // removes current .nextPage


            $('#loading').hide();
            $('.posts_area').append(response); // this means rhat whenm the loading is complete hide the loading gif and put the data into
                                         // the posts_area div 
        }
    });


      } // end if

      return false;

    }); // end  $(window).scroll(function())

});

</script>




</div>  <!--     closing div for wrapper class of header.php -->

 

 <script>
function show()
 {
    document.getElementById("post_text").style.height = "120px"; // to increase the width of post textarea when clicked
 }
 function hide()
 {
    document.getElementById("post_text").style.height = "40px"; // to decrease the width of post textarea when ost button is clicked
 }
 
</script>

</body>
</html>



