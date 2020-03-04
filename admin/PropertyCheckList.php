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

//echo var_dump($_POST);
if(empty($_POST)){
   
echo "<table>"
    . "<form method='POST' action='/admin/PropertyCheckList.php'>"
        . "<tr>"
        . "<td>Boligtype</td>"
        . "<td>"
        . "<select name='PropertyTypeID' id='PropertyTypeID'>Romtype";
        
        $sql = 'select * from PropertyTypes';
        $stmt=$dbh->query($sql);
        foreach ($stmt as $row) { echo "<option value='". $row['PropertyTypeID'] ."'>".$row['PropertyTypeName']."</option>";     }
        echo "</td>"
        . "</tr>"
        
        . "<tr>"
        . "<td>Kategori</td>"
        . "<td>"
        . "<select name='PropertyCategoryID' id='PropertyCategoryID'>";
        
        $sql = 'select * from PropertyCheckListCategories';
        $stmtp=$dbh->query($sql);
        foreach ($stmtp as $rowp) { echo "<option value='". $rowp['PropertyCategoryID'] ."'>".$rowp['PropertyCheckListCatName']."</option>";     }
        echo "</td>"
        . "</tr>"
        . "<tr><td>Submit</td><td><input type='submit' name='submit'></td>"
                . "</form>"
                . "</table>";
        
        

}
else {
$sql = "select * from PropertiesCheckList where "
        . " :PropertyCheckListPropertyTypeID in (select * from ufn_split(PropertyCheckListPropertyTypeID,',')) "
        . "and :PropertyCheckListCategory in (select * from ufn_split(PropertyCheckListCategory,','))";
$stmt = $dbh->Prepare($sql);
$stmt->BindValue(':PropertyCheckListPropertyTypeID', $_POST['PropertyTypeID']);
$stmt->BindValue(':PropertyCheckListCategory', $_POST['PropertyCategoryID']);
$stmt->Execute();


foreach ($stmt as $row) {
    $cat = explode(',', $row['PropertyCheckListCategory']);
    $PropertyTypes = explode(',', $row['PropertyCheckListPropertyTypeID']);
    echo "Prop: "; var_dump($PropertyTypes);
    echo "Cat: ";var_dump($cat);
    //print_r($row);
            

        echo ""
        . "<table id='PropertyCheckList' class='table table-bordered table-striped' style='clear: both'>"
            . "<tbody class='form-group' id='multiselectForm'>"
                . "<form id='PropertyCheckList' method='post' class='form-horizontal' action='/admin/PropertyCheckListEdit.php'>"
                . "<input type='hidden' id='PropertyCheckListID' name='PropertyCheckListID' value='".$row['PropertyCheckListID']."'>"
                . "<tr>"
                . "<td class='col-md-2'><Label for='PropertyCheckListTitle'>Navn</label></td>"
                . "<td><input type='text' class='form-control' name='PropertyCheckListTitle' id='PropertyCheckListTitle' value='". $row['PropertyCheckListTitle'] ."'></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='PropertyCheckListText'>Tekst</label></td>"
                . "<td><textarea class='form-control' rows='5' name='PropertyCheckListText' id='PropertyCheckListText'>". $row['PropertyCheckListText'] ."</textarea></td>"
                . "</tr>"
                . "<tr>"
                . "<td><label for='PropertyCheckListPropertyTypeID'>Kategori</label></td>"
                . "<td>";
                $stmtr = $dbh->Query('select * from PropertyCheckListCategories');
                echo "<select class='form-control' id='PropertyCategoryID' name='PropertyCategoryID' multiple='true'>";
                foreach ($stmtr as $rowr) {
                    if(in_array($rowr['PropertyCategoryID'], $cat)){
                        echo "<option value='" . $rowr['PropertyCategoryID'] ."' selected='true'>" . $rowr['PropertyCheckListCatName'] ."</option>";
                    }
                    else {
                        echo "<option value='" . $rowr['PropertyCategoryID'] ."'>" . $rowr['PropertyCheckListCatName'] ."</option>";
                    }
                }
                echo "</select>";
                echo "</td>"
                . "</tr>"                
                . "</tr>"
                . "<tr>"
                . "<td class='col-md-2'><label for='PropertyCheckListPropertyTypeID'>Boligtype</label></td>"
                . "<td class='form-group'>";
                $stmtp = $dbh->Query('select * from PropertyTypes');
                echo "<select class='form-control form-multiple' id='PropertyCheckListPropertyTypeID' name='PropertyCheckListPropertyTypeID[]' multiple='true'>";
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
//                . "<td class='col-md-2'><label for='RoomCheckListSortNumber'>Sorteringsnr</label></td>"
//                . "<td><input class='form-control' type='text' id='RoomCheckListSortNumber' name='RoomCheckListSortNumber' value='". $row['RoomCheckListSortNumber'] ."'></td>"
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



