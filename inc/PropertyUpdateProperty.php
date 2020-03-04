<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

include_once '../ConnectDB.php';

$data = array();

echo var_dump($_POST);
//$data = $_POST;
//echo json_encode($data);

echo "<br>value: " . $_POST['value'] . "<br>";
echo "<br>pk: " . $_POST['pk'] . "<br>";

if($_POST['name'] == 'RoomName'){
    //sql update RoomName
    $sql = "Update Room set RoomName = :RoomName, modifieddate = getdate() where RoomID = :RoomID";
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':RoomName', $_POST['value'], PDO::PARAM_STR);
    $stmt->BindValue(':RoomID', $_POST['pk'], PDO::PARAM_INT);
    $stmt->Execute();
}

if($_POST['name'] == 'RoomDescription'){
    //sql update RoomDescription
    $sql = "Update Room set RoomDescription = :RoomDescription, modifieddate = getdate() where RoomID = :RoomID";
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':RoomDescription', $_POST['value'], PDO::PARAM_STR);
    $stmt->BindValue(':RoomID', $_POST['pk'], PDO::PARAM_INT);
    $stmt->Execute();
}
