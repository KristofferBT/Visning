<?php
include_once '../Header.php';
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

 error_reporting(E_ALL);
            ini_set('display_errors', 1);


    $target_path = "upload/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}


?>

<head>
        
    <!--<script src="/js/RoomCheckListPicture.js"></script>-->   
    
</head>

<form action="RoomCheckListPicture.php" method="post" enctype="multipart/form-data">

  <input type="file" name="uploadedfile" accept="image/*" capture="camera">

  <input type="submit" value="Upload">

</form>
    


