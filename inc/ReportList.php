<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

$sqlReports = "select 
	* 
from 
	PropertyReport PR
		left join
	Properties P on PR.PropertyReportPropertyID = P.PropertyID"
        . " where PropertyReportPropertyID in (select PropertyID from Properties where UserID = :UserID) order by PropertyReportCreateDate desc";

$stmt = $dbh->Prepare($sqlReports);
$stmt->BindValue(':UserID', $_SESSION['UserID'], PDO::PARAM_INT);
$stmt->Execute();

echo ""
    . "<div class='panel panel-default'>"
    . "<div class='panel-heading' id='Reports'>"
        . "<h3 class='panel-title'> Boligrapporter </h3>"
    . "</div>"
        . "<div class='panel-body'>";
        
echo "<table class='table table.bordered table-striped' style='clear: both'>"
    . "<thead>"
        . "<th>Eiendom</th>"
        . "<th>Rapport Dato</th>"
        . "<th>Last ned</th>"
    . "</thead>";
foreach ($stmt as $row) {
    echo ""
        . "<tr>"
            . "<td>".$row['PropertyName']."(".$row['StreetAddress'].")</td>"
            . "<td>".$row['PropertyReportCreateDate']."</td>"
            . "<td><a href='https://tryggvisning.blob.core.windows.net/pdf/".$row['PropertyReportFile']."'>Link</a></td>"
        . "</tr>";
        
}

echo "</table>"
    . "</div>"
    . "</div>";