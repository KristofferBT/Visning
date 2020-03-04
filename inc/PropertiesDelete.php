<?php
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once '../ConnectDB.php';

error_reporting(E_ALL);
            ini_set('display_errors', 1);

$data2 = array();

//var_dump($_POST);

if(isset($_POST['PropertyID'])){
    $PropertyID = $_POST['PropertyID'];
    $data['PropertyID'] = $PropertyID;
    
}
else {
    exit;
}

try {
    
    //Slette Rom sjekklister
$stmtcrc = $dbh->prepare('update CustomerRoomCheckList set DeletedDate = getdate() where CustomerPropertyID = :PropertyID');
$stmtcrc->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
$stmtcrc->Execute();

//Slette Rom
$stmtr = $dbh->prepare('update Room set DeletedDate = getdate() where PropertyID = :PropertyID');
$stmtr->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
$stmtr->Execute();

//Slette Eiendom
$stmtp = $dbh->prepare('update Properties set DeletedDate = getdate() where PropertyID = :PropertyID');
$stmtp->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
$stmtp->Execute();

    
} catch (PDOException $ex) {
        echo "Shit went wrong..<br>".$ex->getMessage();
}




$data2['success'] = 'true';

echo json_encode($data2);