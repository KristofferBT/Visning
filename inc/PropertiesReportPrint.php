<style>
    @page {
        size: A4 portrait;
    }
    @page :left {
         margin-left: 1cm;
    }

    @page :right {
         margin-left: 1cm;
    }
    
    
    
</style>

<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */



$CheckAccess = CheckAccess();

if($CheckAccess == 'false2'){
    
}



else {
    
    
    if(isset($_REQUEST['PropertyID'])){
        $UserID = $_SESSION['UserID']; 
        $PropertyID = $_REQUEST['PropertyID'];
        
        
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
        //$stmtall->Execute();
        
        foreach ($stmtall as $row) {
            echo "<table border='1' width='1024' id='Property'>"
            . "<tr><td colspan='4'><h2>Visningsrapport for ".$row['StreetAddress'].", ". $row['PostalCode'] ." " .$row['City']. " <h2></td></tr>"
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
where
	P.PropertyID = :PropertyID";        
        
$stmtrooms = $dbh->prepare($sqlrooms);
$stmtrooms->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
//$stmtrooms->Execute();
        echo "<h3>Romoversikt</h3>";
        echo "<table border='1' width='1024' id='Rooms'>"
                . "<thead><th>Navn</th><th>Type</th><th>Beskrivelse</th></thead>";
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
        //$stmtrooms2->Execute();
            //Loope gjennom rom
        foreach ($stmtrooms2 as $rowrooms2) {
            
            
            echo "<table id='Room'><h3>".$rowrooms2['RoomName']. "(" . $rowrooms2['RoomTypeName'].")<h3></table>";
            
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
		left join
	CustomerRoomCheckListMedia CRCLM on CRCLM.MediaCustomerRoomCheckListID = CRCL.CustomerRoomCheckListID
where
        CRCL.CustomerRoomCheckListEvaluation is not null
            and
	CRCL.CustomerRoomID = :RoomID";
         
         $RoomID =  $rowrooms2['RoomID'];
            
        $stmtRoomDetails = $dbh->prepare($sqlRoomDetails);
        $stmtRoomDetails->BindValue(':RoomID', $RoomID , PDO::PARAM_INT);
        //$stmtRoomDetails->Execute();
            echo "<table border='1' width='1024' id='RoomDetails'>"
                . "<thead>"
                    . "<th><h4>Tittel<h4></th>"
                    . "<th><h4>Vurdering(1 er best, 3 er verst.)</h4></th>"
                    . "</thead>";
        foreach ($stmtRoomDetails as $rowRoomDetail) {
                
            
            echo "<tr>"
                    . "<td><b>".$rowRoomDetail['CustomerRoomCheckListTitle']."</b></td>"
                    . "<td>".$rowRoomDetail['CustomerRoomCheckListEvaluation']."</td>"
            . "</tr>"
            . "<tr>"
                    . "<td colspan='2'>".$rowRoomDetail['CustomerRoomCheckListText']."</td>"
            . "</tr>";
            
            if($rowRoomDetail['MediaID'] > '0') {
                echo "<tr>"
                . "<td colspan='2'>"
                        . "<img src='https://tryggvisning.blob.core.windows.net/bilder/".$rowRoomDetail['MediaFile']."' alt='Bilde' style='width:1024px;height:768px;'>"
                        . "</td>"
                . "</tr>";
            }
                
            

        }
            echo "</table>";
            
            echo "</table>";
            
            
            
        }
        
//END RomdDetaljer
        
        
    //End Report   
    }

    
  //End Access Check  
        }