<?php

session_start();
include 'DatabaseConfig/DbConfig.php';
$id = $_SESSION["uid"];
?>
<div id="upload_div">
    <a href="StudentHome.php">Close</a>
    <form id="upload_form" action="Upload.php" method="post" enctype="multipart/form-data">
        <label for="file" id="file_icon" name="filelabel"> select image </label>
        <input type="file" name="imageFile" id="file">
        <label for="file" id="file_icon" name="filelabel"> select file </label>
        <input type="file" name="documentFile" id="file">
        <input type="submit" value="submit" name="submit" id="submit">

        <div class="bar" id="bar">
            <span class="bar-fill" id="pb">
            </span>
        </div>
    </form>
</div>

<?php
if(isset($_POST['submit'])){

    $ImageFile = $_FILES['imageFile']['name'];
    $DocuFile = $_FILES['documentFile']['name'];
    // This lines of codes gets the details of the file been uploaded
    $ImageTempLocation= $_FILES['imageFile']['tmp_name'];
    $DocuTempLocation = $_FILES['documentFile']['tmp_name'];
    $ImageSize = $_FILES['imageFile']['size'];
    $DocuSize = $_FILES['documentFile']['size'];
    $ImageUploadStatus=$_FILES['imageFile']['error'];
    $DocutUploadStatus=$_FILES['documentFile']['error'];
    $ImageNameExpload = explode('.', $ImageFile);
    $DocuNameExpload = explode('.', $DocuFile);
    $ImageExt = strtolower(end($ImageNameExpload));
    $DocuExt = strtolower(end($DocuNameExpload));
    $ImageClear=false;
    $DocuClear=false;
    // Type of file supported
    $supportedImgFormat = array('jpg', 'jpeg', 'png');
    $supportedFileFormat = array('pdf', 'txt', 'docx','doc','zip','rar');
        if( in_array($ImageExt, $supportedImgFormat)){
            if($ImageUploadStatus===0){
                if($ImageSize<50000000){
                    $realImageFile=$ImageFile;
                    $ImagePath="img/$realImageFile";
                    move_uploaded_file($ImageTempLocation, $ImagePath);
                    $ImageClear=true;
                    }
                else{
                     echo '<p>The file size is too big</p>';
                     
                }
            }else{
                echo '<p>There is an error</p>';
                
            }
        } elseif(empty ($ImageFile)){
            echo '<p>Please insert a image file</p>';
        }else{
            echo '<p>The file is not supported</p>';
        }

        
    
    if (in_array($DocuExt, $supportedFileFormat)) {
            if($DocutUploadStatus===0){
               if($DocuSize<50000000){
                    $realDocuFile=$DocuFile;
                    $DocuPath="img/$realDocuFile";
                    move_uploaded_file($DocuTempLocation, $DocuPath);
                    $DocuClear=true;
                    }  
                else{
                    echo '<p>The file size is too big</p>';
                   }      
               }else{
                   echo '<p>There is an error</p>';
                   
               }
        } elseif(empty ($DocuFile)) {
            echo '<p>Please insert a document file</p>';
        } else{
            echo '<p>The document is not supported</p>';
        }
        
    if($ImageClear==true&&$DocuClear==true){
            $sql = "INSERT INTO `post`( `user_id`, `post_image`,`post_file`, `submit_date`) VALUES ( '$id', '$realImageFile','$realDocuFile', CURRENT_TIMESTAMP)";
                    $prep = $conn->prepare($sql);
                    $prep->execute();
                    header("Location: Upload.php?file_upload_sucessful");
        }
}
?>