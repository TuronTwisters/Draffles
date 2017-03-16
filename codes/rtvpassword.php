<?php
include ('connection.php');
$successent="";

if(isset($_POST['submit'])){
if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = mysqli_escape_string($conn,$_POST['email']); // Set email variable
    
    $search = mysqli_query($conn,"SELECT email, hash, active FROM users WHERE email='".$email."'");
    $match  = mysqli_num_rows($search);
    
     if($match > 0){
        $to = $email;
        $subject = 'Retrieve | Password';
        $message ='Forgot Password?
        Your can reset your account password by pressing the url below. 
        Please click this link to activate your account:
        http://draffles.site11.com/files/renewpass.php?email='.$email.'';
        $headers = 'From:noreply@draflles.site11.com' . "\r\n";
         mail($to, $subject, $message, $headers); // Send our email
         $successent = "<script>alertify.alert('Success','Check Email', function(){alertify.success('Success!');});</script>";
         }
    }   
}
