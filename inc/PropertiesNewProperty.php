<?php
include_once '../ConnectDB.php';
include_once 'incFunctions.php';
session_start();
//var_dump($_SESSION);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

//echo var_dump($_POST);

$data                   = array();      // array to pass back data  
$FormErrors             = array();      // array to pass back data  

//$data = $_POST;
if(isset($_POST['PropertyName'])){$PropertyName = $_POST['PropertyName'];}

if(strlen($PropertyName) < '5'){
    $FormErrors['PropertyNameError'] = 'Navn må være flere enn 4 tegn.';
}


if(!empty($FormErrors)){
    $data['success'] = 'false';
    $data['Errors'] = $FormErrors;
}
else {
    $data['success'] = 'true';
    $UserID = $_SESSION['UserID'];
//SQL insert Property her
    
$sqlp = "Insert into [Properties] (PropertyName, PropertyTypeID, PropertyShortDescription, PropertyCreatedDate, UserID, StreetAddress, City, PostalCode, FinnCode) Values "
        . "( "
        . ":PropertyName, "
        . ":PropertyTypeID, "
        . ":PropertyDescription, "
        . "getdate(), "
        . ":UserID, "
        . ":StreetAddress, "
        . ":City, "
        . ":PostalCode, "
        . ":FinnCode)";

$stmt = $dbh->prepare($sqlp);
$stmt->BindValue(':PropertyName', $_POST['PropertyName'], PDO::PARAM_STR);
$stmt->BindValue(':PropertyTypeID', $_POST['PropertyTypeID'], PDO::PARAM_INT);
$stmt->BindValue(':PropertyDescription', $_POST['PropertyDescription'], PDO::PARAM_STR);
$stmt->BindValue(':StreetAddress', $_POST['StreetAddress'], PDO::PARAM_STR);
$stmt->BindValue(':City', $_POST['City'], PDO::PARAM_STR);
$stmt->BindValue(':PostalCode', $_POST['PostalCode'], PDO::PARAM_INT);
$stmt->BindValue(':FinnCode', $_POST['FinnCode'], PDO::PARAM_INT);
$stmt->BindValue(':UserID', $UserID, PDO::PARAM_STR);
$stmt->Execute();
$PropertyID = $dbh->lastInsertId();


//Legge til PropertyID i Sessions['PropertyID']

    array_push($_SESSION['PropertyID'], $PropertyID);


generatePropertyCheckList($PropertyID, $dbh);
//echo "Nye PropertyID: " . $PropertyID;

//SQL insert Rooms her
//Loope gjennom alle form inputs

foreach($_POST as $key=>$value)
{
    //Fjerne RoomTypeName fra string så vi sitter igjen med RoomTypeID til sql insert.
    $RoomTypeID = str_replace('RoomTypeName','',$key);
    if(is_numeric($RoomTypeID)){
        
        $sql = "Select RoomTypeName from [RoomTypes] where RoomTypeID = $RoomTypeID";
        $stmt = $dbh->query($sql);
        $RoomTypeName = $stmt->fetchColumn();
        //Looper gjennom antallet rom.
        for ($i = 1; $i <= $value; $i++){
            //echo "Legge inn rom(" .$RoomTypeName. ") på RoomTypeID: " . $RoomTypeID . "<br>";
            $RoomTypeNameI = $RoomTypeName . $i;
            $sql = "Insert into [Room] (PropertyID, RoomType, RoomName, CreatedDate) Values "
                    . "("
                    . ":PropertyID, "
                    . ":RoomType, "
                    . ":RoomName, "
                    . "getdate())";
            
            $stmtr = $dbh->prepare($sql);
            $stmtr->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
            $stmtr->BindValue(':RoomType', $RoomTypeID, PDO::PARAM_INT);
            $stmtr->BindValue(':RoomName', $RoomTypeNameI, PDO::PARAM_STR);
            $stmtr->Execute();
            $RoomID = $dbh->lastInsertId();
            
            //Legge inn Sjekkliste tilhørende det nyopprettede rommet.
            generateRoomCheckList($RoomID, $dbh);
            
            
        }
    }
}
}




$data['test'] = 'testtekst';
echo json_encode($data);