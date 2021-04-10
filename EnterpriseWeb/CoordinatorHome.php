<?php 
	session_start();
	include("DatabaseConfig/dbConfig.php");
	if(!isset($_SESSION['id'])){
		echo "<script>window.open('login.php','_self')</script>";

	}else{
		$coordinator_session = $_SESSION['id'];


		$get_coordinator = "select * from user where username = '$coordinator_session'";
		$run_coordinator = mysqli_query($conn,$get_coordinator);
		$row_coordinator = mysqli_fetch_array($run_coordinator);

		$coordinator_name = $row_coordinator['username'];
                $coordinator_id = $row_coordinator['user_id'];
		$coordinator_role = $row_coordinator['user_role'];
		$coordinator_email = $row_coordinator['user_email'];
                $coordinator_faculty = $row_coordinator['faculty_id'];
                if($coordinator_role!='Coordinator'){
                        session_start();
                        session_destroy();
                        echo "<h1>Restricted area, please go back to the login page</h1>";
                        echo "<script>window.open('login.php','_self')</script>";
                }
    if (isset($_POST['checkSelected'])) {
    $post_id=$_POST['postId'];
    $query = "UPDATE post SET selected = '1' WHERE post_id = '$post_id'";
    $prep = $conn->prepare($query);
    $prep->execute();
    header("Location: CoordinatorHome.php");
    die("You've selected the post for publication <a href=' CoordinatorHome.php'>click here</a> to continue.");
    }
if (isset($_POST['checkNotSelected'])) {
    $post_id=$_POST['postId'];
    $query = "UPDATE post SET selected = '0' WHERE post_id = '$post_id'";
    $prep = $conn->prepare($query);
    $prep->execute();
    header("Location: CoordinatorHome.php");
    die("You've unselected the post for publication <a href=' CoordinatorHome.php'>click here</a> to continue.");
    }
            
            
	
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Coordinator Page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="CoordinatorHome.php">Academy</a>
      <i class="fas fa-user-alt"></i>
    </div>
  </nav>

  <!-- Content -->
  <div class="grid-container">
    <div class="sidebar">
      <div class="text-center">
        <img src="img/avatar.png" class="rounded avatar mx-auto img-fluid" alt="...">
        <h2><?php echo"Name: ", $coordinator_name ?></h2>
        <div><?php echo"Email: ",$coordinator_email ?></div>
        <div><?php echo"faculty_id: ",$coordinator_faculty ?></div>
        <div>Phone Number: 923874239</div>
        <a href="logout.php">Log out</a>
      </div>
    </div>
    <?php
      if(isset($_GET['submit-coordinator'])){
        include("submit-coordinator.php");
      }else{
     ?>
    <div class="content">
      <div class="content-stuff">
        <h2>Student Works:</h2>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Student's id</th>
                    <th>Picture</th>
                    <th>Document</th>
                    <th>Term</th>
                    <th>Comment</th>
                    <th>Commented??</th>
                    <th>For publication</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $get_post = "select * from post where faculty_id = '$coordinator_faculty' ";
                $run_post = mysqli_query($conn,$get_post);
                while($row_post = mysqli_fetch_array($run_post)){
                  $post_id = $row_post['post_id'];
                  $term_id=$row_post['term_id'];
                  $student_id = $row_post['user_id'];
                  $post_image = $row_post['post_image'];
                  $post_file = $row_post['post_file'];
                  $post_status = $row_post['selected'];
                  $post_time=$row_post['submit_date'];
              ?>
              <tr>
                <td><?php echo $student_id ?></td>
                <td><?php echo "<img class='img-fluid' src='img/". $post_image . "' height='160' width='160'>" ?></td>
                <td><?php echo "<a href='img/".$post_file." 'target='_blank'>".$post_file."</a>" ?></td>
                <td><?php echo $term_id; ?></td>
                <td> <a href="CoordinatorHome.php?submit-coordinator=<?php echo $post_id; ?>" class="btn btn-outline-dark btn-sm"><i class="fas fa-edit"></i></a></td>
                <td>
                    <?php
                    $commented=null;
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $date_now=date("Y-m-d H:i:s");
                $now= strtotime($date_now);
                $submit_date= strtotime($post_time);
                $gap=abs($submit_date - $now)/60/60/24;
                    $check_comment = "select * from comment where post_id = '$post_id'and user_id='$coordinator_id' ";
                            $run_check_comment = mysqli_query($conn,$check_comment);
                            if(empty($row_check_comment = mysqli_fetch_array($run_check_comment))){
                                if (floor($gap)>14){
                                    $late=floor($gap)-14;
                                    echo "No comment in ".floor($gap)." days (".$late." days late)";
                                }elseif (floor($gap)<14){
                                    $time_left=14-floor($gap);
                                    echo "No comment in ".floor($gap)." days (".$time_left." days left)" ;
                                }
                            }else{
                                echo "Yes";
                            }
                    ?>
                </td>
                <td><form id="selected" action="CoordinatorHome.php" method="POST">
                        <input type="hidden" name="postId" value="<?php echo $post_id ?>" />
                        <input type="checkbox" name="checkSelected" onchange="this.form.submit()"
                          <?php 
                        if($post_status=="1"){
                            echo "checked";
                        }
                        ?>     
                        >Selected
                    </form>
                    <form id="notselected" action="CoordinatorHome.php" method="POST">
                    <input type="hidden" name="postId" value="<?php echo $post_id ?>" />
                    <input type="checkbox" name="checkNotSelected" onchange="this.form.submit()"
                             <?php 
                        if($post_status=="0"){
                            echo "checked";
                        }
                        ?>
                    >Not selected
                    </form>
                </td>
              </tr>
              <?php } ?>
              
            </tbody>
        </table>
      </div>
      </div>
    </div>
  
  </div>
 

  <!-- Footer -->
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
  <?php } ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>


<?php } ?>