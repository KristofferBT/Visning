
<?php

 error_reporting(E_ALL);
            ini_set('display_errors', 1);
include_once 'Header.php';
echo "<script src='/js/UserProfile.js'></script>";
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$UserID = $_SESSION['UserID'];

$sqluser = "select * from [User] where UserID = $UserID";
$stmtuser = $dbh->query($sqluser);

echo ""
    . "<div class='col-sm-6'>"
        
    . "<div class='panel panel-default '>"
    . "<div class='panel-heading'>"
    . "<p class='panel-title'>Brukerprofil</p>"
    . "</div>"
    . "<div class='panel-body'>"
    . "<table class='table table-bordered table-striped' style='clear: both'>"
    . "<tbody>";

foreach ($stmtuser as $value) {
    echo ""
        . "<tr>"
            . "<td>"
            . "Fornavn"
            . "</td>"
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['UserFirstName']."' id='UserFirstName'></a>"
        . "</td>"
            . "</tr>"
        . "<tr>"
            . "<td>"
            . "Etternavn"
            . "</td>"
                
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['UserLastName']."' id='UserLastName'></a>"
        . "</td>"
            . "</tr>"
        . "<tr>"
            . "<td>"
            . "Visningsnavn"
            . "</td>"
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['UserDisplayName']."' id='UserDisplayName'></a>"
        . "</td>"
            . "</tr>"
        . "<tr>"
            . "<td>"
            . "Adresse"
            . "</td>"
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['UserAddress']."' id='UserAddress'></a>"
        . "</td>"
            . "</tr>"
        . "<tr>"
            . "<td>"
            . "Postnummer"
            . "</td>"
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['UserZipCode']."' id='UserZipCode'></a>"
        . "</td>"
            . "</tr>"
        . "<tr>"
            . "<td>"
            . "By"
            . "</td>"
        . "<td>"
            . "<a class='UserProfileData' data-type='text' data-url='../inc/UserProfileUpdate.php' data-pk='".$UserID."' data-placeholder='' data-title='' data-value='".$value['userCity']."' id='userCity'></a>"
        . "</td>"
            . "</tr>"            
            
        . "";

}

   echo "</tbody>"
        . "</table>"
. "</div>"        
        . "</div>";