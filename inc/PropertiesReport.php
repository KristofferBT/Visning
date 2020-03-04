<script src="/js/PropertiesReport.js"></script>   
<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$CheckAccess = CheckAccess();

if($CheckAccess == 'false'){
    echo "Ingen tilgang.";
}
else {
 
    if(isset($_REQUEST['PropertyID'])){
        $PropertyID = $_REQUEST['PropertyID'];

//Hente ut data fra boligen
//Presentere i eget panel med all informasjon.

        
        $sqlp = "select * from Properties where PropertyID = :PropertyID";
        $stmtp = $dbh->Prepare($sqlp);
        $stmtp->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
        $stmtp->Execute();
        foreach ($stmtp as $rowp) {
            
        echo "<div id='properties'>"
            . "<div class='col-md-6'>"
            . "<div class='panel panel-default'>"
            . "<div class='panel-heading'>"
            . "<h3 class='panel-title'>". $rowp['PropertyName'] ." </h3>"
            . "</div>"
            . "<div class='panel-body'>"
            
            . $rowp['PropertyShortDescription'] . "<br>"
            . "</div>"
            . "</div>";
            
        }
        
//END  Boliginformasjon
        
//Start Rominformasjon
        $sqlr = "select * from Room where PropertyID = :PropertyID";
        $stmtr = $dbh->Prepare($sqlr);
        $stmtr->BindValue(':PropertyID', $PropertyID, PDO::PARAM_INT);
        $stmtr->Execute();
        
        
        
        foreach ($stmtr as $rowr) {
            echo "<div id='room'>"
            . "<div class='panel panel-default'>"
            . "<div class='panel-heading'>"
            . "<h3 class='panel-title'>". $rowr['RoomName'] ." </h3>"
            . "</div>"
            . "<div class='panel-body'>"
            . "<b>Beskrivelse: </b><br>"
            . $rowr['RoomDescription'] . "<br>";
            //. "</div>";
//            . "</div>";
            
            //var_dump($rowr);
//Start Romsjekkliste informasjon            
        $sqlcrcl = "select * from CustomerRoomCheckList crcl "
                . "left join CustomerRoomCheckListMedia crclm on crcl.CustomerRoomCheckListID = crclm.MediaCustomerRoomCheckListID "
                . "where crcl.CustomerRoomID = :RoomID";
        $stmtcrcl = $dbh->Prepare($sqlcrcl);
        $stmtcrcl->BindValue(':RoomID', $rowr['RoomID'], PDO::PARAM_INT);
        $stmtcrcl->Execute();
        
        foreach ($stmtcrcl as $rowcrcl) {
            echo "<b>". $rowcrcl['CustomerRoomCheckListTitle'] ."</b><br> ";
            echo "Vurdering : " . $rowcrcl['CustomerRoomCheckListEvaluation'] . "<br>";
            
            //var_dump($rowcrcl);
        
            $roomId = $rowr['RoomID'];
        $sqlmediaroom = "select * from CustomerRoomCheckListMedia where MediaCustomerRoomID = $roomId";
        $stmtRoomMedia = $dbh->query($sqlmediaroom);
        foreach ($stmtRoomMedia as $rowRoomMedia) {
            echo "<img src='https://tryggvisning.blob.core.windows.net/bilder/".$rowRoomMedia['MediaFile']."' alt='Test' style='width:304px;height:228px;'><br>";
            
        }
        
        }
        
        echo "</div></div></div>"; //END panel.body ROOM
//END romsjekklisteinformasjon
//END Rominformasjon                 
            
        }
        
    $sqlmedia = "select * from CustomerPropertyCheckListMedia where CustomerPropertyCheckListMediaPropertyID = '$PropertyID'";
    $stmtmedia = $dbh->query($sqlmedia);
    
    foreach ($stmtmedia as $rowmedia) {
    
        
        echo "<img src='https://tryggvisning.blob.core.windows.net/bilder/".$rowmedia['CustomerPropertyCheckListMediaFile']."' alt='Test' style='width:304px;height:228px;'><br>";
        
    }
    }
    
}