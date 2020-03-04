<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once '../ConnectDB.php';

if(isset($_POST)){
    var_dump($_POST);
    
    $Prop = implode(',', $_POST['RoomCheckListPropertyTypeID']);
    $Room = implode(',', $_POST['RoomCheckListRoomTypeID']);
    
    echo "<br>Prop:" . $Prop . "<br>Room:" . $Room . "<br>";
    try {
        $sql = "Update RoomCheckList set "
            . "RoomCheckListRoomTypeID = :RoomCheckListRoomTypeID, "
            . "RoomCheckListPropertyTypeID = :RoomCheckListPropertyTypeID, "
            . "RoomCheckListTitle = :RoomCheckListTitle, "
            . "RoomCheckListText = :RoomCheckListText, "
            . "RoomCheckListModifiedDate = getdate() "
            . "where RoomCheckListID = :RoomCheckListID";
    
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':RoomCheckListRoomTypeID', $Room);
    $stmt->BindValue(':RoomCheckListPropertyTypeID', $Prop);
    $stmt->BindValue(':RoomCheckListTitle', $_POST['RoomCheckListTitle']);
    $stmt->BindValue(':RoomCheckListText', $_POST['RoomCheckListText']);
    $stmt->BindValue(':RoomCheckListID', $_POST['RoomCheckListID']);
    $stmt->Execute();
    
    } catch (Exception $ex) {

    }
    
}