<?php
include 'connection.php';
$sucpass="";
$enterpass="";
$errpass="";
if(isset($_GET['email']) && !empty($_GET['email'])){
    
    $email = mysqli_escape_string($conn,$_GET['email']); // Set email variable
    $search = mysqli_query($conn,"SELECT email FROM users WHERE email='".$email."'");
    $match  = mysqli_num_rows($search);
    if($match > 0){
        if(isset($_POST['submit'])){
            if(empty($_POST['password'])){
                $enterpass = "<script>alertify.alert('Error','Please Enter New Password', function(){alertify.error('Error!');});</script>";
            }else{
                $password = $_POST['password'];
                $password = mysqli_real_escape_string($conn,md5($password));
                $query = mysqli_query($conn,"UPDATE users SET password='$password' WHERE email='".$email."'");
                if(mysqli_query($conn, $query)){
                    
                $sucpass = "<script>alertify.alert('Success','Password Successfully Changed', function(){alertify.success('Success!');});</script>";
            }else{
                $errpass = "<script>alertify.alert('Error','Password Not Changed', function(){alertify.Error('Success!');});</script>";
            }
           }
        }
       
       
    }
    
}
