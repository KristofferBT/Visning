<?php
include_once '../Header.php';
include_once '../inc/incBootstrap.inc';
 error_reporting(E_ALL);
            ini_set('display_errors', 1);


?>

<head>
        
    <script src="/js/adminPropertyCheckList.js"></script>   
    
</head>

<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

if(isset($_POST['submit'])){
    echo "<br>submitted!</br>";
    //var_dump($_POST);
    
    $Prop = implode(',', $_POST['PropertyTypeID']);
    $cat = $_POST['PropertyCategoryID'];
    $text = $_POST['PropertyCheckListText'];
    $title = $_POST['PropertyCheckListTitle'];
    echo "Prop: " . $Prop;
    echo "cat: " . $cat;
    $sql = "INSERT INTO PropertiesCheckList (PropertyCheckListPropertyTypeID, PropertyCheckListCategory, PropertyCheckListTitle, PropertyCheckListText, PropertyCheckListCreatedDate) "
            . " Values ("
            . ":PropertyCheckListPropertyTypeID, "
            . ":PropertyCheckListCategory, "
            . ":PropertyCheckListTitle, "
            . ":PropertyCheckListText, "
            . "getdate() )";
    echo $sql;
    try {
        echo "<br>";
    $stmtinsert = $dbh->prepare($sql);
    $stmtinsert->BindValue(':PropertyCheckListPropertyTypeID', $Prop);
    $stmtinsert->BindValue(':PropertyCheckListCategory', $cat);
    $stmtinsert->BindValue(':PropertyCheckListTitle', $title);
    $stmtinsert->BindValue(':PropertyCheckListText', $text);
    $stmtinsert->Execute();
    } catch (PDOException $ex) {
        echo "The CheckList could not be added.<br>".$ex->getMessage();
    }
    
  //  print_r($_SERVER);
    //header("Location: ".$_SERVER['HTTP_REFERER']);
    
    echo "<br>lastInsertId:"; $dbh->lastInsertId();
}
//else {
    
echo ""
        . "<table id='PropertyCheckListAdd' class='table table-bordered table-striped' style='clear: both'>"
            . "<tbody class='form-group' id='multiselectForm'>"
                . "<form id='PropertyCheckListAdd' method='post' class='form-horizontal' action='/admin/PropertyCheckListAdd.php'>"
                
                . "<tr>"
                . "<td class='col-md-2'><Label for='PropertyCheckListTitle'>Navn</label></td>"
                . "<td><input type='text' class='form-control' name='PropertyCheckListTitle' id='PropertyCheckListTitle' ></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='PropertyCheckListText'>Beskrivelse</label></td>"
                . "<td><textarea class='form-control' rows='5' name='PropertyCheckListText' id='PropertyCheckListText'></textarea></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='PropertyCheckListPropertyTypeID'>Boligtype</label></td>"
                . "<td>";
                $stmtr = $dbh->Query('select * from PropertyTypes');
                echo "<select class='form-control form-multiple' id='PropertyTypeID' name='PropertyTypeID[]' multiple='true'>";
                foreach ($stmtr as $rowr) {
                        echo "<option value='" . $rowr['PropertyTypeID'] ."'>" . $rowr['PropertyTypeName'] ."</option>";
                    }
                
                echo "</select>";
                echo "</td>"
                . "</tr>"                
                . "</tr>"
                . "<tr>"
                . "<td class='col-md-2'><label for='PropertyCheckListCategories'>Kategori</label></td>"
                . "<td class='form-group'>";
                $stmtp = $dbh->Query('select * from PropertyCheckListCategories');
                echo "<select class='form-control' id='PropertyCategoryID' name='PropertyCategoryID' multiple='true'>";
                foreach ($stmtp as $rowp) {
                        echo "<option value='" . $rowp['PropertyCategoryID'] ."'>" . $rowp['PropertyCheckListCatName'] ."</option>";
                    }

                echo "</select>";
                echo "</td>"
                . "</tr>"
                . "</tr>"
                . "<tr>"
//                . "<td class='col-md-2'><label for='RoomCheckListSortNumber'>Sorteringsnr</label></td>"
//                . "<td><input class='form-control' type='text' id='RoomCheckListSortNumber' name='RoomCheckListSortNumber'></td>"
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