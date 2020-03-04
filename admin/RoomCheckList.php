<?php
include_once '../Header.php';
include_once '../inc/incBootstrap.inc';
 error_reporting(E_ALL);
            ini_set('display_errors', 1);


?>

<head>
        
    <script src="/js/adminRoomCheckList.js"></script>   
    
</head>

<?php


/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

echo var_dump($_POST);
if(empty($_POST)){
   
echo "<table>"
    . "<form method='POST' action='/admin/RoomCheckList.php'>"
        . "<tr>"
        . "<td>RomType</td>"
        . "<td>"
        . "<select name='RoomType' id='RoomType'>Romtype";
        
        $sql = 'select * from RoomTypes';
        $stmt=$dbh->query($sql);
        foreach ($stmt as $row) { echo "<option value='". $row['RoomTypeID'] ."'>".$row['RoomTypeName']."</option>";     }
        echo "</td>"
        . "</tr>"
        
        . "<tr>"
        . "<td>Boligtype</td>"
        . "<td>"
        . "<select name='PropertyType' id='PropertyType'>";
        
        $sql = 'select * from PropertyTypes';
        $stmtp=$dbh->query($sql);
        foreach ($stmtp as $rowp) { echo "<option value='". $rowp['PropertyTypeID'] ."'>".$rowp['PropertyTypeName']."</option>";     }
        echo "</td>"
        . "</tr>"
        . "<tr><td>Submit</td><td><input type='submit' name='submit'></td>"
                . "</form>"
                . "</table>";
        
        

}
else {
$sql = "select * from RoomCheckList where "
        . " :PropertyTypeID in (select * from ufn_split(RoomCheckListPropertyTypeID,',')) "
        . "and :RoomTypeID in (select * from ufn_split(RoomCheckListRoomTypeID,','))";
$stmt = $dbh->Prepare($sql);
$stmt->BindValue(':PropertyTypeID', $_POST['PropertyType']);
$stmt->BindValue(':RoomTypeID', $_POST['RoomType']);
$stmt->Execute();


foreach ($stmt as $row) {
    $RoomTypes = explode(',', $row['RoomCheckListRoomTypeID']);
    $PropertyTypes = explode(',', $row['RoomCheckListPropertyTypeID']);
    //var_dump($RoomTypes);
            

        echo ""
        . "<table id='RoomCheckList' class='table table-bordered table-striped' style='clear: both'>"
            . "<tbody class='form-group' id='multiselectForm'>"
                . "<form id='RoomCheckList' method='post' class='form-horizontal' action='/admin/RoomCheckListEdit.php'>"
                . "<input type='hidden' id='RoomCheckListID' name='RoomCheckListID' value='".$row['RoomCheckListID']."'>"
                . "<tr>"
                . "<td class='col-md-2'><Label for='RoomCheckListTitle'>Navn</label></td>"
                . "<td><input type='text' class='form-control' name='RoomCheckListTitle' id='RoomCheckListTitle' value='". $row['RoomCheckListTitle'] ."'></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='RoomCheckListText'>Romtype</label></td>"
                . "<td><textarea class='form-control' rows='5' name='RoomCheckListText' id='RoomCheckListText'>". $row['RoomCheckListText'] ."</textarea></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='RoomCheckListRoomTypeID'>Romtype</label></td>"
                . "<td>";
                $stmtr = $dbh->Query('select * from RoomTypes');
                echo "<select class='form-control form-multiple' id='RoomCheckListRoomTypeID' name='RoomCheckListRoomTypeID[]' multiple='true'>";
                foreach ($stmtr as $rowr) {
                    if(in_array($rowr['RoomTypeID'], $RoomTypes)){
                        echo "<option value='" . $rowr['RoomTypeID'] ."' selected='true'>" . $rowr['RoomTypeName'] ."</option>";
                    }
                    else {
                        echo "<option value='" . $rowr['RoomTypeID'] ."'>" . $rowr['RoomTypeName'] ."</option>";
                    }
                }
                echo "</select>";
                echo "</td>"
                . "</tr>"                
                . "</tr>"
                . "<tr>"
                . "<td class='col-md-2'><label for='RoomCheckListPropertyTypeID'>Boligtype</label></td>"
                . "<td class='form-group'>";
                $stmtp = $dbh->Query('select * from PropertyTypes');
                echo "<select class='form-control form-multiple' id='RoomCheckListPropertyTypeID' name='RoomCheckListPropertyTypeID[]' multiple='true'>";
                foreach ($stmtp as $rowp) {
                    if(in_array($rowp['PropertyTypeID'], $PropertyTypes)){
                        echo "<option value='" . $rowp['PropertyTypeID'] ."' selected='true'>" . $rowp['PropertyTypeName'] ."</option>";
                    }
                    else {
                        echo "<option value='" . $rowp['PropertyTypeID'] ."'>" . $rowp['PropertyTypeName'] ."</option>";
                    }
                }
                echo "</select>";
                echo "</td>"
                . "</tr>"
                . "</tr>"
                . "<tr>"
                . "<td class='col-md-2'><label for='RoomCheckListSortNumber'>Sorteringsnr</label></td>"
                . "<td><input class='form-control' type='text' id='RoomCheckListSortNumber' name='RoomCheckListSortNumber' value='". $row['RoomCheckListSortNumber'] ."'></td>"
                . "</tr>"
                . "<tr>"
                        . "<td><label for='submit'>Lagre</label>"
                        . "<td><input type='submit' class='btn btn-success' id='submit' name='submit'></td>"
                . "</tr>"
                        
            . "</form>"
                
            . "</tbody>"
        . "</table><br>"
        . "";
}
    
}



