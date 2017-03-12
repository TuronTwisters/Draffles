<?php
include 'connection.php';
$error="";
$errors1="";
$success1="";
$error2="";
$errors2="";
$success="";
$error1="";
$option1="";
$option2="";
      
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = mysqli_escape_string($conn,$_GET['email']); // Set email variable
    $hash = mysqli_escape_string($conn,$_GET['hash']); // Set hash variable
                 
    $search = mysqli_query($conn,"SELECT email, hash, active FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'");
    $match  = mysqli_num_rows($search);
                 
    if($match > 0){
        // We have a match, activate the account
        mysqli_query($conn,"UPDATE users SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'");
       $success = "<script>alertify.alert('Success','Successfully Registered', function(){alertify.success('Success!');});</script>";
       $success1="Successfully Registered";
       $option2 = "Success:";
    }else{
        // No match -> invalid url or account has already been activated.
       $error1 = "<script>alertify.alert('Error','The url is either invalid or you already have activated your account', function(){alertify.error('Error!');});</script>";
       $errors1 = 'The url is either invalid or you already have activated your account';
       $option2 = "Error:";
       
    }
                 
}else{
    // Invalid approach
  $error2= "<script>alertify.alert('Error','Invalid approach, please use the link that has been send to your emails', function(){alertify.error('Error!');});</script>";
  $errors2 ='Invalid approach, please use the link that has been send to your emails.';
  $option2 = "Error:";
}