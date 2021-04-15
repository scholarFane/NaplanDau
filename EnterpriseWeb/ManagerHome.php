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
                if($user_role!='Manager'){
                        session_start();
                        session_destroy();
                        echo "<h1>Restricted area, please go back to the login page</h1>";
                        echo "<script>window.open('login.php','_self')</script>";
                }
    
if (isset($_POST['selectTerm'])) {
    if(!empty($filterTerm)) {
        $filterTerm=$_POST['selectTerm'];
    }else{
        $filterTerm=$tID;
    }
    $filterTerm=$_POST['selectTerm'];
    header("Location: ManagerHome.php#stats");
    die("Term filtered");
}

function zipFilesAndDownload($term_id)
{
    include("DatabaseConfig/dbConfig.php");
    $file_names = array();
    $get_file = "select * from post where term_id=$term_id";
    $run_file = mysqli_query($conn,$get_file);
	while($row_file = mysqli_fetch_array($run_file)){
	$post_image = $row_file['post_image'];
	$post_file = $row_file['post_file'];
        array_push($file_names, $post_file);
        array_push($file_names, $post_image);
    }
    $archive_file_name='Submission.zip';
    $file_path='img/';
        //echo $file_path;die;
    $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }
    //add each files of $file_name array to archive
    foreach($file_names as $files)
    {
        $zip->addFile($file_path.$files,$files);
        //echo $file_path.$files,$files."

    }
    $zip->close();
    //then send the headers to force download the zip file
    header("Content-type: application/zip"); 
    header("Content-Disposition: attachment; filename=$archive_file_name");
    header("Content-length: " . filesize($archive_file_name));
    header("Pragma: no-cache"); 
    header("Expires: 0");
    ob_clean();
	flush();
    readfile("$archive_file_name");
    unlink($archive_file_name);
    exit;
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Download']))
    {
        $term_id=$_POST['selectDownloadTerm'];
        zipFilesAndDownload($term_id);
    }

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Page</title>

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
            <a class="navbar-brand" href="ManagerHome.php">Academy</a>
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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#stats">Statistics</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="submission" class="container tab-pane active"><br>
                        <h2>Student Works:</h2>
                        <form action="ManagerHome.php" method="POST">
                            <label for="selectDownloadTerm">Choose which term's posts you want to download:</label>
                            <select name="selectDownloadTerm" id="selectTerm">
                                <?php 
                            $query = "SELECT * FROM term";
                            $terms = mysqli_query($conn,$query);
                        while ($term= mysqli_fetch_array($terms)) {
                            $tId = $term['0'];
                            echo "<option value='$tId' selected >$tId</option>";
                        }   
                                ?>
                            </select>
                        <input type="hidden" name="termID" value="<?php echo $tId; ?>">
                        <button class="btn btn-outline-dark btn-sm" type="submit" name="Download"><i class="fas fa-download"></i>Download all</button>
                        </form>
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
				                $get_post = "select * from post ";
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
                    <!-- Chart-->
                    <div id="stats" class="container tab-pane fade"><br>
                        <h2>Total of post submitted</h2>
                        <div>
                            <form name="filterTerm" method="POST" action="ManagerHome.php#stats">
                            <select name="selectTerm" id="selectTerm" onchange="this.form.submit()">
                                <?php 
                    $query = "SELECT * FROM term";
                    $terms = mysqli_query($conn,$query);
                        while ($term= mysqli_fetch_array($terms)) {
                        $tId = $term['0'];
                        echo "<option value='$tId' selected >$tId</option>";
                    }
                                ?>
                            </select>
                            <input type="hidden" name="termID" value="<?php echo $tId; ?>">  
                        </form>        
                            <canvas id="chart1"></canvas>
                        </div>
                        <h2>Total of students</h2>
                        <div>
                            <canvas id="chart2"></canvas>
                        </div>
                        <h2>Total of post submitted by each faculty</h2>
                        <div>
                            <canvas id="chart3"></canvas>
                        </div>
                        <h2>Total of post selected by each faculty</h2>
                        <div>
                            <canvas id="chart4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart script-->
    <!-- Just copy more if u u more charts-->
    <script>
    	<?php
                $filterTerm=$tId;
		$test = "SELECT count(post_id) as total FROM post where term_id='$filterTerm'";
		$result = mysqli_query($conn,$test);
		$values = mysqli_fetch_assoc($result);
		$num_rows = $values['total'] ;
                $selected_num = "SELECT count(post_id) as total FROM post where selected='1' and term_id='$filterTerm'";
		$selected_result = mysqli_query($conn,$selected_num);
		$selected = mysqli_fetch_assoc($selected_result);
		$selected_rows = ($selected['total']/$num_rows)*100 ;
                $notselected_num = "SELECT count(post_id) as total FROM post where selected='0'and term_id='$filterTerm'";
		$notselected_result = mysqli_query($conn,$notselected_num);
		$notselected = mysqli_fetch_assoc($notselected_result);
		$notselected_rows = ($notselected['total']/$num_rows)*100 ;
    	 ?> 
        // Chart 1
        let chart1 = document.getElementById('chart1').getContext('2d');
        
        let circleChart = new Chart(chart1, {
            type: 'pie', // bar, horizontal
            data: {
                labels: ['Selected Post', 'Not Selected Post'],
                datasets: [{
                    label: 'Student Submission Chart',
                    data: [
                        <?php echo $selected_rows; ?>,
                        <?php echo $notselected_rows; ?>
                    ],
                    backgroundColor: [
                        '#a3ddcb', 
                        '#e5707e'
                    ]
                }],
            },
            options: {
                title: {
                    display: true,
                    text: '<?php echo $num_rows." posts"; ?>',
                    fontSize: 18
                },
                legend: {
                    position: 'bottom'
                }
            }
        })
        <?php 
                $get_users = "SELECT count(user_id) as total from user where user_role='Student'";
		$run_users = mysqli_query($conn,$get_users);
		$row_users = mysqli_fetch_assoc($run_users);
                $num_users = $row_users['total'] ;
                $IT_query = "SELECT count(user_id) as total FROM user where faculty_id='1' and user_role='Student'";
		$IT_result = mysqli_query($conn,$IT_query);
		$ITstudent = mysqli_fetch_assoc($IT_result);
		$ITstudent_rows = ($ITstudent['total']/$num_users)*100 ;
                $Busi_query = "SELECT count(user_id) as total FROM user where faculty_id='2' and user_role='Student'";
		$Busi_result = mysqli_query($conn,$Busi_query);
		$BusiStudent = mysqli_fetch_assoc($Busi_result);
		$BusiStudent_rows = ($BusiStudent['total']/$num_users)*100 ;
                $Event_query = "SELECT count(user_id) as total FROM user where faculty_id='3' and user_role='Student'";
		$Event_result = mysqli_query($conn,$Event_query);
		$EventStudent = mysqli_fetch_assoc($Event_result);
		$EventStudent_rows = ($EventStudent['total']/$num_users)*100 ;
        ?>
        // Chart 2
        let chart2 = document.getElementById('chart2').getContext('2d');

        let circleChart2 = new Chart(chart2, {
            type: 'pie', // bar, horizontal
            data: {
                labels: ['IT Students', 'Business Student','Event Student'],
                datasets: [{
                    label: 'Student Chart',
                    data: [
                        <?php echo $ITstudent_rows; ?>,
                        <?php echo $BusiStudent_rows; ?>,
                        <?php echo $EventStudent_rows; ?>
                    ],
                    backgroundColor: [
                        '#a3ddcb', 
                        '#e5707e',
                        '#fcf695'
                    ]
                }],
            },
            options: {
                title: {
                    display: true,
                    text: '<?php echo $num_users." students"; ?>',
                    fontSize: 18
                },
                legend: {
                    position: 'bottom'
                }
            }
        })
                
        <?php 
            $ITpost_query = "SELECT count(post_id) as total FROM post where faculty_id='1' and term_id='$filterTerm'";
            $ITpost_result = mysqli_query($conn,$ITpost_query);
            $ITpost = mysqli_fetch_assoc($ITpost_result);
            $ITpost_rows = ($ITpost['total']/$num_rows)*100 ;
            $BusiPost_query = "SELECT count(post_id) as total FROM post where faculty_id='2' and term_id='$filterTerm'";
            $BusiPost_result = mysqli_query($conn,$BusiPost_query);
            $BusiPost = mysqli_fetch_assoc($BusiPost_result);
            $BusiPost_rows = ($BusiPost['total']/$num_rows)*100 ;
            $EventPost_query = "SELECT count(post_id) as total FROM post where faculty_id='3' and term_id='$filterTerm'";
            $EventPost_result = mysqli_query($conn,$EventPost_query);
            $EventPost = mysqli_fetch_assoc($EventPost_result);
            $EventPost_rows = ($EventPost['total']/$num_rows)*100 ;
        ?>
        let chart3 = document.getElementById('chart3').getContext('2d');
        let circleChart3 = new Chart(chart3, {
            type: 'pie', // bar, horizontal
            data: {
                labels: ['IT Students', 'Business Student','Event Student'],
                datasets: [{
                    label: 'Post by each faculty Chart',
                    data: [
                        <?php echo $ITpost_rows; ?>,
                        <?php echo $BusiPost_rows; ?>,
                        <?php echo $EventPost_rows; ?>            
                    ],
                    backgroundColor: [
                        '#a3ddcb', 
                        '#e5707e',
                        '#fcf695'
                    ]
                }],
            },
            options: {
                title: {
                    display: true,
                    text: '<?php echo $num_rows." posts"; ?>',
                    fontSize: 18
                },
                legend: {
                    position: 'bottom'
                }
            }
        })
        <?php        
            $ITpostSelected_query = "SELECT count(post_id) as total FROM post where faculty_id='1' and term_id='$filterTerm' and selected='1'";
            $ITpostSelected_result = mysqli_query($conn,$ITpostSelected_query);
            $ITpostSelected = mysqli_fetch_assoc($ITpostSelected_result);
            $ITpostSelected_rows = ($ITpostSelected['total']/$num_rows)*100 ;
            $BusiPostSelected_query = "SELECT count(post_id) as total FROM post where faculty_id='2' and term_id='$filterTerm'and selected='1'";
            $BusiPostSelected_result = mysqli_query($conn,$BusiPostSelected_query);
            $BusiPostSelected = mysqli_fetch_assoc($BusiPostSelected_result);
            $BusiPostSelected_rows = ($BusiPostSelected['total']/$num_rows)*100 ;
            $EventPostSelected_query = "SELECT count(post_id) as total FROM post where faculty_id='3' and term_id='$filterTerm'and selected='1' ";
            $EventPostSelected_result = mysqli_query($conn,$EventPostSelected_query);
            $EventPostSelected = mysqli_fetch_assoc($EventPostSelected_result);
            $EventPostSelected_rows = ($EventPostSelected['total']/$num_rows)*100 ;
        ?>
        let chart4 = document.getElementById('chart4').getContext('2d');
        let circleChart4 = new Chart(chart4, {
            type: 'pie', // bar, horizontal
            data: {
                labels: ['IT Students', 'Business Student','Event Student'],
                datasets: [{
                    label: 'Post by each faculty Chart',
                    data: [
                        <?php echo $ITpostSelected_rows; ?>,
                        <?php echo $BusiPostSelected_rows; ?>,
                        <?php echo $EventPostSelected_rows; ?>            
                    ],
                    backgroundColor: [
                        '#a3ddcb', 
                        '#e5707e',
                        '#fcf695'
                    ]
                }],
            },
            options: {
                title: {
                    display: true,
                    text: '<?php echo $num_rows." posts"; ?>',
                    fontSize: 18
                },
                legend: {
                    position: 'bottom'
                }
            }
        })
    </script>
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
