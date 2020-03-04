<?php

error_reporting(E_ALL);
            ini_set('display_errors', 1);

include_once 'ConnectDB.php';

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function generateRoomCheckList($RoomID, $dbh) {
    
    
try {
    $sql = "Insert into CustomerRoomCheckList
(CustomerRoomID,CustomerPropertyID,CustomerRoomCheckListSortNumber,CustomerRoomCheckListTitle,CustomerRoomCheckListText,CustomerRoomCheckListCreatedDate)
SELECT
	R.RoomID
	,P.PropertyID
	,RCL.RoomCheckListSortNumber
	,RCL.RoomCheckListTitle
	,RCL.RoomCheckListText
	,Getdate()

FROM
	Properties P
		left join
	Room R on P.PropertyID = R.PropertyID
		inner join
	RoomCheckList RCL 
		on 
		R.RoomType in (select * from ufn_split(RCL.RoomCheckListRoomTypeID, ',')) 
			and 
		P.PropertyTypeID in  (select * from ufn_split(RCL.RoomCheckListPropertyTypeID, ','))
where
	R.RoomID = :RoomID";
    $stmt = $dbh->Prepare($sql);
    $stmt->BindValue(':RoomID', $RoomID, PDO::PARAM_INT);
    $stmt->Execute();
    
    
} catch (Exception $ex) {

}
    
    
}

function generatePropertyCheckList($PropertyID, $dbh) {
    
    
try {
    $sql = "Insert into CustomerPropertyCheckList
(CustomerPropertyCheckListPropertyID,CustomerPropertyCheckListPropertyCategoryID,CustomerPropertyCheckListTitle,CustomerPropertyCheckListText,CustomerPropertyCheckListCreatedDate)
select
	P.PropertyID
	,PCL.PropertyCheckListCategory
	,PCL.PropertyCheckListTitle
	,PCL.PropertyCheckListText
	,getdate()
from
	Properties P
		left join
	PropertiesCheckList PCL ON P.PropertyTypeID in (select * from ufn_split(PCL.PropertyCheckListPropertyTypeID, ','))
where
	P.PropertyID = :PropertyID";
    $stmt = $dbh->Prepare($sql);
    $stmt->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
    $stmt->Execute();
    
    
} catch (Exception $ex) {

}
    
    
}

function grab_image_room_checklist($mediaID, $dbh){

    $sql = "select * from CustomerRoomCheckListMedia where mediaID = :mediaID";
    
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':mediaID', $mediaID, PDO::PARAM_INT);
    $stmt->Execute();
    
    foreach ($stmt as $value) {
        
        $url = "https://tryggvisning.blob.core.windows.net/bilder/" . $value['MediaFile'] ."";
        $saveto = "../pdfimage/";

        file_put_contents("../pdfimage/". $value['MediaFile'] ."", fopen($url, 'r'));
    }
    
}