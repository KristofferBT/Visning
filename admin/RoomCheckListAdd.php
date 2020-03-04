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

if(isset($_POST['submit'])){
    echo "<br>submitted!</br>";
    var_dump($_POST);
    
    $Prop = implode(',', $_POST['RoomCheckListPropertyTypeID']);
    $Room = implode(',', $_POST['RoomCheckListRoomTypeID']);
    
    $sql = "Insert into RoomCheckList (RoomCheckListRoomTypeID, RoomCheckListPropertyTypeID,RoomCheckListSortNumber,RoomCheckListTitle,RoomCheckListText,RoomCheckListCreatedDate)"
            . "Values ("
            . ":RoomCheckListRoomTypeID, "
            . ":RoomCheckListPropertyTypeID, "
            . ":RoomCheckListSortNumber, "
            . ":RoomCheckListTitle, "
            . ":RoomCheckListText, "
            . "getdate())";
    
    $stmtinsert = $dbh->prepare($sql);
    $stmtinsert->BindValue(':RoomCheckListRoomTypeID', $Room,PDO::PARAM_STR);
    $stmtinsert->BindValue(':RoomCheckListPropertyTypeID',$Prop,PDO::PARAM_STR);
    $stmtinsert->BindValue(':RoomCheckListSortNumber', $_POST['RoomCheckListSortNumber'],PDO::PARAM_INT);
    $stmtinsert->BindValue(':RoomCheckListTitle', $_POST['RoomCheckListTitle'],PDO::PARAM_STR);
    $stmtinsert->BindValue(':RoomCheckListText', $_POST['RoomCheckListText'],PDO::PARAM_STR);
    $stmtinsert->Execute();
  //  print_r($_SERVER);
    //header("Location: ".$_SERVER['HTTP_REFERER']);
}
//else {
    
echo ""
        . "<table id='RoomCheckListAdd' class='table table-bordered table-striped' style='clear: both'>"
            . "<tbody class='form-group' id='multiselectForm'>"
                . "<form id='RoomCheckList' method='post' class='form-horizontal' action='/admin/RoomCheckListAdd.php'>"
                
                . "<tr>"
                . "<td class='col-md-2'><Label for='RoomCheckListTitle'>Navn</label></td>"
                . "<td><input type='text' class='form-control' name='RoomCheckListTitle' id='RoomCheckListTitle' ></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='RoomCheckListText'>Beskrivelse</label></td>"
                . "<td><textarea class='form-control' rows='5' name='RoomCheckListText' id='RoomCheckListText'></textarea></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='RoomCheckListRoomTypeID'>Romtype</label></td>"
                . "<td>";
                $stmtr = $dbh->Query('select * from RoomTypes');
                echo "<select class='form-control form-multiple' id='RoomCheckListRoomTypeID' name='RoomCheckListRoomTypeID[]' multiple='true'>";
                foreach ($stmtr as $rowr) {
                        echo "<option value='" . $rowr['RoomTypeID'] ."'>" . $rowr['RoomTypeName'] ."</option>";
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
                        echo "<option value='" . $rowp['PropertyTypeID'] ."'>" . $rowp['PropertyTypeName'] ."</option>";
                    }

                echo "</select>";
                echo "</td>"
                . "</tr>"
                . "</tr>"
                . "<tr>"
                . "<td class='col-md-2'><label for='RoomCheckListSortNumber'>Sorteringsnr</label></td>"
                . "<td><input class='form-control' type='text' id='RoomCheckListSortNumber' name='RoomCheckListSortNumber'></td>"
                . "</tr>"
                . "<tr>"
                        . "<td><label for='submit'>Lagre</label>"
                        . "<td><input type='submit' class='btn btn-success' id='submit' name='submit'></td>"
                . "</tr>"
                        
            . "</form>"
                
            . "</tbody>"
        . "</table><br>"
        . "";
    
//}