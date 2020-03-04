<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

var_dump($_POST);

include_once '../ConnectDB.php';

$RoomID = $_POST['pk'];

$sql = "select count(*) from CustomerRoomCheckListComment where RoomID = $RoomID";
$stmt = $dbh->query($sql);
$count = $stmt->fetchColumn();

echo "Count: ". $count;

if($count > '0') {
    //Update
    echo "update";
    $pk = $_POST['pk'];
    $Comment = $_POST['value'];
    
    $sqlupdate = "Update CustomerRoomCheckListComment set Comment = :Comment where RoomID = $pk";
    $stmtupdate = $dbh->prepare($sqlupdate);
    $stmtupdate->BindValue(':Comment', $Comment, PDO::PARAM_STR);
    $stmtupdate->Execute();
}

else {
    //Insert
    echo "Insert";
    
    $pk = $_POST['pk'];
    $Comment = $_POST['value'];
    
    $sqlinsert = "Insert into CustomerRoomCheckListComment (RoomID, Comment) Values ("
            . " :pk, "
            . " :Comment )";
    $stmtinsert = $dbh->prepare($sqlinsert);
    $stmtinsert->BindValue(':pk', $pk, PDO::PARAM_INT);
    $stmtinsert->BindValue(':Comment', $Comment, PDO::PARAM_STR);
    $stmtinsert->Execute();
}