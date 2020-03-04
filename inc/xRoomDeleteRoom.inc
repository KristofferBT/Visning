<?php
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$data = array();

if(isset($_REQUEST['RoomID'])){
    $RoomID = $_REQUEST['RoomID'];
}
else {
    exit;
}

$sql = "delete from [Room] where RoomID = :RoomID";

$stmt = $dbh->prepare($sql);
$stmt->BindValue(':RoomID', $RoomID, PDO::PARAM_INT);
$stmt->Execute();

$data['success'] = 'true';

echo json_encode($data);