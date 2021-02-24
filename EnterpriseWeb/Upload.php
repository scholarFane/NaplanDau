<?php


session_start();
include 'DatabaseConfig/DbConfig.php';
$id = $_SESSION["uid"];
?>
<div id="upload_div">
    <a href="StudentHome.php">Close</a>
    <form id="upload_form" action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file" id="file_icon" name="filelabel"> select files </label>
        <input type="file" name="file[]" id="file" multiple>
        <label for="file" id="file_icon" name="filelabel"> select files </label>
        <input type="file" name="file[]" id="file" multiple>
        <input type="submit" value="submit" name="submit" id="submit">

        <div class="bar" id="bar">
            <span class="bar-fill" id="pb">
            </span>
        </div>
    </form>
</div>

<?php
if(isset($_POST['submit'])){

    $fileName = $_FILES['file']['name'][$i];
    $realFileName="";
    // This lines of codes gets the details of the file been uploaded
    $fileTempLocation = $_FILES['file']['tmp_name'][$i];
    $fileSize = $_FILES['file']['size'][$i];
    $uploadStatus=$_FILES['file']['error'][$i];
    $fileNameExpload = explode('.', $fileName);
    $fileExt = strtolower(end($fileNameExpload));
    // Type of file supported
    $supportedImgFormat = array('jpg', 'jpeg', 'png');
    $supportedFileFormat = array('pdf', 'txt', 'docx','doc','zip','rar',);
        if( in_array($fileExt, $supportedImgFormat) ){
            if($uploadStatus===0){
               if($fileSize<2000000){
                   $realFileName=$fileName;
                   $filePath="img/$realFileName";
                   if(move_uploaded_file($fileTempLocation, $filePath)){
                    $sql = "INSERT INTO `post`( `user_id`, `post_image`, `submit_date`) VALUES ( '$id', '$fileName', CURRENT_TIMESTAMP)";
                    $prep = $conn->prepare($sql);
                    $prep->execute();

                    header("Location: upload.php?file_upload_sucessful");
                   }
                   
               }else{
                   echo '<p>The file size is too big</p>';
               }
            }else{
                echo '<p>There was an error</p>';
            }
        } elseif (in_array($fileExt, $supportedFileFormat)) {
            if($uploadStatus===0){
               if($fileSize<50000000){
                   $realFileName=$fileName;
                   $filePath="img/$realFileName";
                   if(move_uploaded_file($fileTempLocation, $filePath)){
                    $sql = "INSERT INTO `post` where user_id='$id'(`post_file`) VALUES ('$fileName')";
                    $prep = $conn->prepare($sql);
                    $prep->execute();

                    header("Location: upload.php?file_upload_sucessful");
                   }
                   
               }else{
                   echo '<p>The file size is too big</p>';
               }
        } else {
            echo '<p>The file is not supported</p>';
        }

    }
}
?>
