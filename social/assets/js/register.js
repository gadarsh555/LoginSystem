$(document).ready(function() {
    
    
// on click sign up button , hide login and show registration
$("#signup").click(function(){
  $("#first").slideUp("slow", function(){
    $("#second").slideDown("slow");
    
       });    
    });

// on click sign in button , hide registration and show login
$("#signin").click(function(){
  $("#second").slideUp("slow", function(){
    $("#first").slideDown("slow");
    
       });    
    });

    
});