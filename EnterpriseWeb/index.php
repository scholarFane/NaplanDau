<?php
    include 'header.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
  if (isset($_SESSION['id'])){
      echo '<p>You are logged in</p> ';
  } else{
      echo '<p>You are logged out</p>';
  }
?>
    </body>
</html>
