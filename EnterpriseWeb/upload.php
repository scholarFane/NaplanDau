<?php

session_start();
include 'DatabaseConfig/DbConfig.php';
$id = $_SESSION["id"];
$sql = "SELECT student_id FROM student WHERE username = '$id'";
$result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

    if (!$row = $result->fetch_assoc()) {
      //echo '<script>alert("Username or Password is incorrect")</script>';
    } else {
        
        $_SESSION["sid"]=$row['student_id'];
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <article id="post">
    </article>

<div id="upload_div">
    <a href="StudentHome.php">Close</a>
    <form id="upload_form" action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <label for="file" id="file_icon" name="filelabel"> select file </label>
        <input type="submit" value="submit" name="submit" id="submit">

        <div class="bar" id="bar">
            <span class="bar-fill" id="pb">
            </span>
        </div>
    </form>
</div>
<?php
        if(isset($file)){

    // $img = $_POST["img"]

   
    // This lines of codes gets the details of the file been uploaded
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempLocation = $file['tmp_name'];
    $uploadStatus = $file['error'];
    $fileSize = $file['size'];
    $sid = $_SESSION["sid"];

    $fileNameExpload = explode('.', $fileName);
    $fileExt = strtolower(end($fileNameExpload));
    $supportedFileFormat = array('jpg', 'jpeg', 'png', 'pdf', 'txt', 'docx','doc','zip','rar', 'pptx');

    if( in_array($fileExt, $supportedFileFormat) ){
        if($uploadStatus === 0){
            if( $fileSize <= 10000000 ){
                $newFileName = uniqid('', true).".".$fileExt;
                $uploadLocation = "uploads/".$newFileName;

                if(move_uploaded_file($fileTempLocation, $uploadLocation)){
                    $_SESSION["success"] = "Your file has been successfully uploaded";
                    echo($_SESSION["success"]);
                    // exit();

                    require 'db.php';
                    $sql = "INSERT INTO `post`( `student_id`, `post_file`, `submit_date`) VALUES ( '$sid', '$fileName', CURRENT_TIMESTAMP)";
                    $prep = $conn->prepare($sql);
                    $prep->execute();

                    header("Location: upload.php?file_upload_sucessful");
                   
                }
            }else{
                $_SESSION['error'] = "The file is too large";
                // exit();
                echo($_SESSION["error"]);
            }
        }else{
            $_SESSION['error'] = "There was an error uploading your file to the database";
            echo($_SESSION["error"]);
        }
    }else{
        $_SESSION['error'] = "The file you tried uploading is not supported";
        echo($_SESSION["error"]);
    }
}

?>
    </body>
</html>
