<?php
$servername="localhost";
$DBusername="root";
$DBpass="";
$DBname="enterprisewebapp";

$conn= mysqli_connect($servername,$DBusername,$DBpass,$DBname);
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
?>


