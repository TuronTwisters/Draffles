<?php      
include 'connection.php';
//Some Variables
$invalemail="";
$userexist="";
$emailexist ="";
$regsuc ="";
$regerr="";
$cap="";
//Start of POST SUBMIT
if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
        //IF Required fields are empty this will be shown
        $regerr = "<script>alertify.alert('Error','Put All Required Fields', function(){alertify.error('Error!');});</script>";
    }else{
    //Captcha Validations start   
    if(isset($_POST['g-recaptcha-response'])){
    //Variables from POST FORM Index.php
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn,$username);
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn,$email);
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn,md5($password));
    $hash = md5(rand(0,1000));
    $epassword = rand(1000,5000);
    
    //Start ng Captcha Validations 
    $secret="6Lci5BgUAAAAABQSVbaaRyGD445pxwQ2Z_F_QrsE";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");    
    $arr = json_decode($rsp,TRUE);
    //If Captcha is success 
    if($arr['success'])
    {
    //Email Validations
    if(preg_replace("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^","", $email)){
    $invalemail = "<script>alertify.alert('Error','Invalid Email Format', function(){alertify.error('Error!');});</script>";
    }else{
        //Start of username validations
    $querusername = mysqli_query($conn,"Select username from users where username='$username'");
    $userrows = mysqli_num_rows($querusername);
    if($userrows > 0){
         $userexist = "<script>alertify.alert('Error','Username had been used', function(){alertify.error('Error!');});</script>";
    }else{
        //START of EMAIL VALIDATIONS
        $queremail = mysqli_query($conn, "Select email from users where email ='$email'");
        $emailrows = mysqli_num_rows($queremail);
        if($emailrows > 0){
        $emailexist = "<script>alertify.alert('Error','Email has been used', function(){alertify.error('Error!');});</script>";
    }else{
      
    //If all Required are true this will insert into database
    $query = "INSERT INTO `users`(username,password,email,hash,epassword,ipadd) VALUES ('$username','$password','$email','$hash','$epassword','$ip')";
    $result = mysqli_query($conn,$query);
    if($result){
        
        //Email Sending
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
         //End of Email Sending and a pop will show
        $regsuc = "<script>alertify.alert('Success','Please Verify your Email', function(){alertify.success('Success!');});</script>";
    }else{
        //if not inserted in database this will be shown
        echo "Not inserted";
        mysqli_close($conn);
    }
   } //END OF INSERTING DATA
    }//END OF EMAIL Duplicate checking
    }//END OF Username Duplicate Checking
    }else
    {
       $cap = "<script>alertify.alert('Error','Check Captcha Validations', function(){alertify.error('Error!');});</script>";
    }
    }//End of Captcha Validations

    }
}//End of POST SUBMIT
?>

