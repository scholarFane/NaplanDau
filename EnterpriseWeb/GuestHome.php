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
        $email = $row_user['user_email'];
                if($user_role!='Guest'){
                        session_start();
                        session_destroy();
                        echo "<h1>Restricted area, please go back to the login page</h1>";
                        echo "<script>window.open('login.php','_self')</script>";
                }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Guest Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!-- Custom styles for this template -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="GuestHome.php">Academy</a>
            <i class="fas fa-user-alt"></i>
        </div>
    </nav>

    <!-- Content -->
    <div class="grid-container">
        <div class="sidebar">
            <div class="text-center">
                <img src="img/avatar.png" class="rounded avatar mx-auto img-fluid" alt="...">
                <h2><?php echo "Name: ", $user_name ?></h2>
                <div><?php echo "Email: ", $email ?></div>
                
                <a href="logout.php">Log out</a>
            </div>
        </div>
        <div class="content">
            <div class="content-stuff">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#submission">Submission</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="submission" class="container tab-pane active"><br>
                        <h2>Student Works:</h2>
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Student's ID</th>
                                    <th>Image</th>
                                    <th>File</th>
                                    <th>Term ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
				                $get_post = "select * from post where selected='1' ";
				                $run_post = mysqli_query($conn,$get_post);
				                while($row_post = mysqli_fetch_array($run_post)){
				                  $post_id = $row_post['post_id'];
				                  $term_id=$row_post['term_id'];
				                  $student_id = $row_post['user_id'];
				                  $post_image = $row_post['post_image'];
				                  $post_file = $row_post['post_file'];
				                  $post_status = $row_post['selected'];
				              ?>
                                <tr>
                                    <td><?php echo $student_id ?></td>
                                    <td><?php echo "<img class='img-fluid' src='img/". $post_image . "' height='160' width='160'>" ?></td>
                                    <td><?php echo "<a href='img/".$post_file." 'target='_blank'>".$post_file."</a>" ?></td>
                                    <td><?php echo $term_id; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <footer class="footer bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a href="#">About</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Contact</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Terms of Use</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Privacy Policy</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <!-- Footer -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php } ?>
