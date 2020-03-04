<style>
    @page {
        size: A4 portrait;
    }
    @page :left {
         margin-left: 1cm;
    }

    @page :right {
         margin-right: 1cm;
    }
    
    table {
        width: 730px !important;
        
        
    }
    
    
</style>

<?php

 error_reporting(E_ALL);
            ini_set('display_errors', 1);

include_once '../ConnectDB.php';
include_once '../inc/incFunctions.php';
include_once '../inc/incBootstrap.inc';

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */





    
    
    if(isset($_REQUEST['PropertyID'])){

        $PropertyID = $_REQUEST['PropertyID'];
        //$UserID = $_SESSION['UserID'];
        
        $sqlGetUserID = "select UserID from Properties where PropertyID = :PropertyID";
        
        $stmtUserID = $dbh->prepare($sqlGetUserID);
        $stmtUserID->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
        $UserID = $stmtUserID->fetchColumn();
        
        
        
        
        
        $sqlall = "select
	* 
from 
	properties p
		left join
	propertytypes pt on p.propertytypeid = pt.propertytypeid
		left join
	[User] U on P.userID = U.UserID

where
	propertyID = :PropertyID";
        
        $stmtall = $dbh->prepare($sqlall);
        $stmtall->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
        $stmtall->Execute();
        
        foreach ($stmtall as $row) {
            echo "<table border='1' width='1024' id='Property'>"
            . "<tr><td colspan='4'><h2>Visningsrapport for ".$row['StreetAddress'].", ". $row['PostalCode'] ." " .$row['City']. " </h2></td></tr>"
            . "<tr><td><b>Navn: </b></td><td>".$row['PropertyName']."</td></tr>"
            . "<tr><td><b>Type:  </b></td><td>".$row['PropertyTypeName']."</td></tr>"
            . "<tr><td><b>Adresse:   </b></td><td>".$row['StreetAddress'].", ". $row['PostalCode'] ." " .$row['City']. " </td></tr>"
            . "<tr><td><b>Beskrivelse:   </b></td><td>".$row['PropertyShortDescription']."</td></tr>"
            . "</table>"
                    . "<br></br>";
        }
//RomListe    
$sqlrooms = "select
	*
from
		Properties P
		left join
	Room R on P.PropertyID = R.PropertyID
		left join
	RoomTypes RT on R.RoomType = RT.RoomTypeID
                left join
	CustomerRoomCheckListComment CRCLC on CRCLC.RoomID = R.RoomID
where
	P.PropertyID = :PropertyID";        
        
$stmtrooms = $dbh->prepare($sqlrooms);
$stmtrooms->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
$stmtrooms->Execute();
        echo "<h3>Romoversikt</h3>";
        echo "<table border='1' width='1024' id='Rooms'>"
                . "<tr>"
                    . "<td>Navn</td>"
                    . "<td>Type</td>"
                    . "<td>Beskrivelse</td>"
                . "</tr>";
foreach ($stmtrooms as $rowrooms) {
        echo "<tr>"
                . "<td>".$rowrooms['RoomName']."</td>"
                . "<td>".$rowrooms['RoomTypeName']."</td>"
                . "<td>".$rowrooms['RoomDescription']."</td>"
            . "</tr>";
    }
        echo "</table>";
//END Romliste       

        
//RomDetaljer
        
        $stmtrooms2 = $dbh->prepare($sqlrooms);
        $stmtrooms2->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
        $stmtrooms2->Execute();
            //Loope gjennom rom
        foreach ($stmtrooms2 as $rowrooms2) {
            
            
            echo "<table id='Room'>"
            . "<tr><h3>".$rowrooms2['RoomName']. "(" . $rowrooms2['RoomTypeName'].")</h3></tr>"
            . "<tr><td>Kommentar: ".$rowrooms2['Comment']."</td></tr>"
            . "</table>";
            
            $sqlRoomDetails = "select
	*
from
	Properties P
		left join
	Room R on P.PropertyID = R.PropertyID
		left join
	RoomTypes RT on R.RoomType = RT.RoomTypeID
		left join
	CustomerRoomCheckList CRCL on CRCL.CustomerRoomID = R.RoomID
		outer apply
			(
			select 
				CRCLM.MediaCustomerRoomCheckListID
				,count(*) as MediaCount
				 from CustomerRoomCheckListMedia CRCLM
			where CRCLM.MediaCustomerRoomCheckListID = CRCL.CustomerRoomCheckListID
			group by CRCLM.MediaCustomerRoomCheckListID

			) as MediaCount
where
        CRCL.CustomerRoomCheckListEvaluation is not null
            and
	CRCL.CustomerRoomID = :RoomID";
         
         $RoomID =  $rowrooms2['RoomID'];
            
        $stmtRoomDetails = $dbh->prepare($sqlRoomDetails);
        $stmtRoomDetails->BindValue(':RoomID', $RoomID , PDO::PARAM_INT);
        $stmtRoomDetails->Execute();
            echo "<table border='1' width='1024' id='RoomDetails'>"
                . "<tr>"
                    . "<td>Tittel</td>"
                    . "<td>Vurdering(1 er best, 3 er verst.)</td>"
                    . "</tr>";
        foreach ($stmtRoomDetails as $rowRoomDetail) {
                
            
            echo "<tr>"
                    . "<td><b>".$rowRoomDetail['CustomerRoomCheckListTitle']."</b></td>"
                    . "<td>".$rowRoomDetail['CustomerRoomCheckListEvaluation']."</td>"
            . "</tr>"
            . "<tr>"
                    . "<td colspan='2'>".$rowRoomDetail['CustomerRoomCheckListText']."</td>"
            . "</tr>";
            
            if($rowRoomDetail['MediaCount'] > '0') {
                
                $sqlGetMedia = "select * from CustomerRoomCheckListMedia where MediaCustomerRoomCheckListID = :MediaCustomerRoomCheckListID";
    
                $CheckListID = $rowRoomDetail['MediaCustomerRoomCheckListID'];
                
                $stmt = $dbh->prepare($sqlGetMedia);
                $stmt->BindValue(':MediaCustomerRoomCheckListID', $CheckListID, PDO::PARAM_STR);
                $stmt->Execute();
                
                foreach ($stmt as $row) {
                    
                    $mediaID = $row['MediaID'];
                    
                    grab_image_room_checklist($mediaID, $dbh);
                echo "<tr>"
                . "<td colspan='2'>"
                        . "<img src='../pdfimage/".$row['MediaFile']."' alt='Bilde' style='width:640px;height:480px;'>"
                        . "</td>"
                . "</tr>";
                    
                }
                
                
            }
                
            

        }
            echo "</table>";
            
            echo "</table>";
            
            
            
        }
        
//END RomdDetaljer
        
        
    //End Report   
    }

    
  //End Access Check  
        