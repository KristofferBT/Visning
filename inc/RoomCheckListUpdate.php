<?php
          error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

            
$data = array();
            
include_once '../ConnectDB.php';

//echo var_dump($_POST);

if(isset($_POST['tg1'])){$tg = '1';}
if(isset($_POST['tg2'])){$tg = '2';}
if(isset($_POST['tg3'])){$tg = '3';}
if(isset($_POST['CustomerRoomCheckListID'])){$CustomerRoomCheckListID = $_POST['CustomerRoomCheckListID'];}

$data['success'] = 'true';

try {
$sql = "Update CustomerRoomCheckList set CustomerRoomCheckListEvaluation = :tg where CustomerRoomCheckListID = :CustomerRoomCheckListID";
$stmt = $dbh->prepare($sql);
$stmt->BindValue(':tg', $tg, PDO::PARAM_INT);
$stmt->BindValue(':CustomerRoomCheckListID', $CustomerRoomCheckListID, PDO::PARAM_INT);
$stmt->Execute();
    
} catch (Exception $ex) {
    $data['success'] = 'false';
}

echo json_encode($data);