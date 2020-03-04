<?php
require_once '../Debug.php';
include_once 'incFunctions.php';
include_once '../ConnectDB.php';

$data                   = array();      // array to pass back data  
$FormErrors             = array();      // array to pass back data  

if(isset($_POST['RoomName'])){$RoomName = $_POST['RoomName'] & $data['RoomName'] = $_POST['RoomName'];}

if(isset($_POST['RoomFloor'])){$RoomFloor = $_POST['RoomFloor'];}
if(!is_numeric($RoomFloor)){
    $FormErrors['RoomFloorError'] = 'Etasje må være ett nummer.';
}
if(isset($_POST['RoomType'])){$RoomType = $_POST['RoomType'];}

if(isset($_POST['RoomDescription'])){$RoomDescription = $_POST['RoomDescription'];}

if(isset($_POST['PropertyID'])){$PropertyID = $_POST['PropertyID'];}

//DebugEcho(var_dump($_POST));

if(!empty($FormErrors)){
    $data['success'] = 'false';
    $data['Errors'] = $FormErrors;
}
else {
    try {
    $sql = "Insert into [Room] (PropertyID, RoomType, RoomName, RoomDescription, CreatedDate, RoomFloor) "
        . "Values ( "
        . ":PropertyID, "
        . ":RoomType, "
        . ":RoomName, "
        . ":RoomDescription, "
        . "getdate(), "
        . ":RoomFloor)";

$stmt = $dbh->prepare($sql);
$stmt->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
$stmt->BindValue(':RoomType', $RoomType, PDO::PARAM_INT);
$stmt->BindValue(':RoomName', $RoomName, PDO::PARAM_STR);
$stmt->BindValue(':RoomDescription', $RoomDescription, PDO::PARAM_STR);

$stmt->BindValue(':RoomFloor', $RoomFloor, PDO::PARAM_INT);
$stmt->Execute();
$RoomID = $dbh->lastInsertId();

}
    
catch (PDOException $ex) {
            echo "DataBase Error: The Room could not be added.<br>".$ex->getMessage();
        }
         catch (Exception $e) {
            echo "General Error: The Room could not be added.<br>".$e->getMessage();
        }
        if(!isset($e)){
            $data['success'] = 'true';
        }
}

//Legge inn sjekkliste ved romopprettelse
generateRoomCheckList($RoomID, $dbh);


echo json_encode($data);