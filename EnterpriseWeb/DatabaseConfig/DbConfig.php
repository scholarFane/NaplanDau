<?php
$servername="localhost";
$DBusername="root";
$DBpass="";
$DBname="comp1640";

$conn= mysqli_connect($servername,$DBusername,$DBpass,$DBname);
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
?>
<?php
 define('DBINFO', 'mysql:host=localhost;dbname=comp1640');
    define('DBUSER','root');
    define('DBPASS','');

    function fetchAll($query){
        $con = new PDO(DBINFO, DBUSER, DBPASS);
        $stmt = $con->query($query);
        return $stmt->fetchAll();
    }
    function performQuery($query){
        $con = new PDO(DBINFO, DBUSER, DBPASS);
        $stmt = $con->prepare($query);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
?>