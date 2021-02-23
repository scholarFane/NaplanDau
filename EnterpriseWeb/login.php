<?php
  include 'DatabaseConfig/DbConfig.php';
  // Configure timeout to 15 minutes
$timeout = 900;

// Set the maxlifetime of session
ini_set( "session.gc_maxlifetime", $timeout );

// Also set the session cookie timeout
ini_set( "session.cookie_lifetime", $timeout );

// Now start the session 
session_start();

// Update the timeout of session cookie
$sessionName = session_name();

if( isset( $_COOKIE[ $sessionName ] ) ) {

	setcookie( $sessionName, $_COOKIE[ $sessionName ], time() + $timeout, '/' );
}
?>
<html>
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="css/login.css" rel="stylesheet">
    </head>
    <body>
        

      <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">

        <div class="container">
          <div class="card login-card">
            <div class="row no-gutters">
              <div class="col-md-5">
                <img src="images/login.jpg" alt="login" class="login-card-img">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <div class="brand-wrapper">
                    <img src="images/logo.png" alt="logo" class="logo">
                  </div>
                  <p class="login-card-description">Sign into your account</p>
                  <form action="#!" method="POST">
                      <div class="form-group">
                        <label  class="sr-only">Username</label>
                        <input  name="userid"  class="form-control" placeholder="Email address">
                      </div>
                      <div class="form-group mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                      </div>
                      <?php
                          if(isset($_POST['submit'])) {

                          $username = $_POST['userid'];
                          $pass = $_POST['password'];

                          $sql = "SELECT * FROM account WHERE username = '$username' AND password = '$pass'";
                          $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

                          if (!$row = $result->fetch_assoc()) {
                            echo ' <div class="alert alert-danger alert-dismissible fade show ">
                              <small><strong>Error!</strong> Wrong account or password.</small>
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>';
                            
                          }
                        }
                      ?>
                      <input name="submit" type="submit" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">

                    </form>
                    <a href="#!" class="forgot-password-link">Forgot password?</a>
                    <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                    <nav class="login-card-footer-nav">
                      <a href="#!">Terms of use.</a>
                      <a href="#!">Privacy policy</a>
                    </nav>
                </div>
              </div>
            </div>
          </div>   

      </main>
      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


      <?php
        if(isset($_POST['submit'])) {

          $username = $_POST['userid'];
          $pass = $_POST['password'];

          $sql = "SELECT * FROM account WHERE username = '$username' AND password = '$pass'";
          $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

          if (!$row = $result->fetch_assoc()) {
            //echo '<script>alert("Username or Password is incorrect")</script>';
          } else {
        
            $_SESSION['id'] = $row['username'];

            if($row['role_id'] == '1' || $row['role_id'] == '2' || $row['role_id'] == '3' || $row['role_id'] == '4' || $row['role_id'] == '5') {

              $_SESSION['role_id'] = $row['role_id'];

              if(isset($_SESSION['role_id'])) {
                if($_SESSION['role_id'] == '1') {
                  header("Location: AdminHome.php");
                }
                else if($_SESSION['role_id'] == '2') {
                  header("Location: CoordinatorHome.php");
                }
                else if($_SESSION['role_id'] == '3') {
                  header("Location:StudentHome.php");
                }
                else if($_SESSION['role_id'] == '4') {
                  header("Location:StudentHome.php");
                }
                else if($_SESSION['role_id'] == '5') {
                  header("Location:GuestHome.php");
                }
              }
            }
            else {
              echo "Role not found.";
            }
          }
        }
      ?>
    </body>
</html>
