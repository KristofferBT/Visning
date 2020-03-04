<?php
include_once 'incFunctions.php';
include_once '../ConnectDB.php';
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$data = array();
$error = array();

 error_reporting(E_ALL);
            ini_set('display_errors', 1);

            //echo "<br>POST: " . var_dump($_POST). "<br>";
            //echo "<br>FILES: " . var_dump($_FILES). "<br>";

if(isset($_POST['PropertyID'])){
    
    $data['POST'] = 'OK';
    //var_dump($_FILES);

    $target_path = "../upload/";

$target_path = $target_path . basename( $_FILES['image_data']['name']); 

       $hash = generateRandomString();
       $SaltedFile = $_FILES['image_data']['name'] . $hash;
       $HashedFile = hash('sha256',$SaltedFile);
       $ext = pathinfo($_FILES['image_data']['name'],PATHINFO_EXTENSION);
       $data['EXT'] = $ext;
       $HashedFile = $HashedFile . "." . '.jpg'; //$ext;    

       
$data['FileName'] = $_FILES['image_data']['name'];


$filepath = $_FILES['image_data']['tmp_name'];
$content = fopen($filepath, "r");

$blob_name = $HashedFile;

try {
    //Upload blob
    $blobRestProxy->createBlockBlob("bilder", $blob_name, $content);
    $data['success'] = 'true';
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage(); 
   $error['Ex'] = $code.": ".$error_message;
   $data['success'] = 'false';
}
 
try {
    Echo "SQL Insert";
    $sql = "Insert into CustomerPropertyCheckListMedia "
            . "(CustomerPropertyCheckListMediaFile, CustomerPropertyCheckListMediaCheckListID, CustomerPropertyCheckListMediaCategoryID, CustomerPropertyCheckListMediaPropertyID, CustomerPropertyCheckListMediaCreatedDate) Values ("
            . " :CustomerPropertyCheckListMediaFile,"
            . " :CustomerPropertyCheckListMediaCheckListID,"
            . " :CustomerPropertyCheckListMediaCategoryID,"
            . " :CustomerPropertyCheckListMediaPropertyID,"
            . " getdate() )";
    
    $stmt = $dbh->Prepare($sql);
    $stmt->BindValue(':CustomerPropertyCheckListMediaFile', $blob_name, PDO::PARAM_STR);
    $stmt->BindValue(':CustomerPropertyCheckListMediaCheckListID', $_POST['CheckListID'], PDO::PARAM_INT);
    $stmt->BindValue(':CustomerPropertyCheckListMediaCategoryID', $_POST['CategoryID'], PDO::PARAM_INT);
    $stmt->BindValue(':CustomerPropertyCheckListMediaPropertyID', $_POST['PropertyID'], PDO::PARAM_INT);
    $stmt->Execute();
    echo $sql;
    echo $blob_name;
} catch (PDOException  $e) {
        echo "Shit went wrong..<br>".$e->getMessage();
}
    
    

}


$data['errors'] = $error;
$data['post'] = $_POST;
$data['files'] = $_FILES;
echo json_encode($data);
?>


