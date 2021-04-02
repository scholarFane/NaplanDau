<?php
$servername="localhost";
$DBusername="root";
$DBpass="";
$DBname="comp1640";

$conn= mysqli_connect($servername,$DBusername,$DBpass,$DBname);
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
function passwordToToken($password){
    global $salt1;
    global $salt2;
    $token = hash ("ripemd128", "$salt1$password$salt2");
    return $token;
}

?>