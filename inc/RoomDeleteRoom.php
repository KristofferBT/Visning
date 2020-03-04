<?php
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once '../ConnectDB.php';

error_reporting(E_ALL);
            ini_set('display_errors', 1);

$data = array();

if(isset($_POST['RoomID'])){
    $RoomID = $_POST['RoomID'];
}
else {
    exit;
}

$sql = "update Room set DeletedDate = getdate() where RoomID = :RoomID";

$stmt = $dbh->prepare($sql);
$stmt->BindValue(':RoomID', $RoomID, PDO::PARAM_INT);
$stmt->Execute();

$sql = "update CustomerRoomCheckList set DeletedDate = getdate() where CustomerRoomID = :RoomID";
$stmt->BindValue(':RoomID', $RoomID, PDO::PARAM_INT);
$stmt->Execute();

$data['success'] = 'true';

echo json_encode($data);