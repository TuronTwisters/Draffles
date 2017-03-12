<?php
$hostname = "localhost" ;
$usernamedb ="root" ;
$passworddb ="" ;
$dbname ="raffle";
//connection
$conn =  mysqli_connect($hostname,$usernamedb,$passworddb,$dbname) or die ("Connection not established");
?>

