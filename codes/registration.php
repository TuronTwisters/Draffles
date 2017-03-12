<?php      
include 'connection.php';

$invalemail="";
$regsuc ="";
$regerr="";
if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
        $regerr = "<script>alertify.alert('Error','Put All Required Fields', function(){alertify.error('Error!');});</script>";
    }else{
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn,$username);
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn,$email);
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn,md5($password));
    $hash = md5(rand(0,1000));
    $epassword = rand(1000,5000);
    
    $to = $email;
    $subject = 'Sign Up | Verification';
    $message ='Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
    ------------------------
    Username: '.$username.'
    Password: '.$password.'
    ------------------------
 
    Please click this link to activate your account:
     http://draffles.site11.com/files/verify.php?email='.$email.'&hash='.$hash.'';
    $headers = 'From:noreply@draflles.site11.com' . "\r\n";
    mail($to, $subject, $message, $headers); // Send our email
    
    
    if(preg_replace("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^","", $email)){
    $invalemail = "<script>alertify.alert('Error','Invalid Email Format', function(){alertify.error('Error!');});</script>";
    }else{
    $query = "INSERT INTO `users`(username,password,email,hash,epassword) VALUES ('$username','$password','$email','$hash','$epassword')";
    $result = mysqli_query($conn,$query);
    if($result){
        $regsuc = "<script>alertify.alert('Success','Please Verify your Email', function(){alertify.success('Success!');});</script>";
    }else{
        echo "Not inserted";
        mysqli_close($conn);
    }
   }
    }
    
   
    
}
?>

