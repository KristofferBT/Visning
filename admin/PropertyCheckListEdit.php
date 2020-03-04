<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once '../ConnectDB.php';

if(isset($_POST)){
    var_dump($_POST);
    
    $Prop = implode(',', $_POST['PropertyCheckListPropertyTypeID']);
    //$cat = implode(',', $_POST['PropertyCategoryID']);
    
    echo "<br>Prop:" . $Prop;
    try {
        $sql = "Update PropertiesCheckList set "
            . "PropertyCheckListPropertyTypeID = :PropertyCheckListPropertyTypeID, "
            . "PropertyCheckListCategory = :PropertyCheckListCategory, "
            . "PropertyCheckListTitle = :PropertyCheckListTitle, "
            . "PropertyCheckListText = :PropertyCheckListText, "
            . "PropertyCheckListModifiedDate = getdate() "
            . "where PropertyCheckListID = :PropertyCheckListID";
    
    $stmt = $dbh->prepare($sql);
    $stmt->BindValue(':PropertyCheckListPropertyTypeID', $Prop);
    $stmt->BindValue(':PropertyCheckListCategory', $_POST['PropertyCategoryID']);
    $stmt->BindValue(':PropertyCheckListTitle', $_POST['PropertyCheckListTitle']);
    $stmt->BindValue(':PropertyCheckListText', $_POST['PropertyCheckListText']);
    $stmt->BindValue(':PropertyCheckListID', $_POST['PropertyCheckListID']);
    $stmt->Execute();
    
    } catch (Exception $ex) {

    }
    
}