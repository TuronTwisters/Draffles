<?php
session_start();
include 'connection.php';
$usernamerr = "";
$passworderr ="";
$successin = "";
$errorin="";

if(isset($_POST['submit'])){
    if(empty($_POST['usernamein'])){
        $usernamerr = "<script>alertify.alert('Enter Username', 'Please Enter Username', function(){alertify.error('Enter Username')});</script>";
    }
    if(empty($_POST['passwordin'])){
        $passworderr = "<script>alertify.alert('Enter Password', 'Please Enter Password', function(){alertify.error('Enter Password')});</script>";
    } else {
        $username = $_POST['usernamein'];
        $password = md5($_POST['passwordin']);
        
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($conn,$username);
        $password = mysqli_real_escape_string($conn,$password);
        $queryin = mysqli_query($conn, "select * from users where username = '$username' and password='$password' and active = '1'");
        $rows = mysqli_num_rows($queryin);
        if($rows==1){
            $_SESSION['login_user']= $username;
            $successin = "<script>window.location.href = 'Home.php'</script>;";
        }else{
            $errorin="<script>alertify.alert('Enter Correct Username and Password', 'Please Enter Correct Username and Password', function(){alertify.error('Wrong Username or Password')});</script>";
        }
        mysqli_close($conn);
   }
}

