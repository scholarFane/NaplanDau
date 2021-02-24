<?php 
	session_start();
	include("DatabaseConfig/dbConfig.php");

	if(!isset($_SESSION['id'])){
		echo "<script>window.open('login.php','_self')</script>";

	}else{
		$user_session = $_SESSION['id'];

		$get_user = "select * from user where username = '$user_session'";
		$run_user = mysqli_query($conn,$get_user);
		$row_user = mysqli_fetch_array($run_user);

		$user_name = $row_user['username'];
		$user_role = $row_user['user_role'];
	
 ?>
<h1><?php echo $user_role," ", $user_name, " here" ?></h1>
<a href="logout.php">Log out</a>

<?php } ?>