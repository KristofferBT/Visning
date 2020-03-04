<body>
<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
if(!$_REQUEST[''] == 'RoomDelete' ){
    include_once 'Header.php';
}
include_once 'ConnectDB.php';




switch ($_REQUEST['Action']) {
    case 'List':
        include_once 'inc/PropertiesList.inc';
        break;
case 'Details':
        include_once 'inc/PropertiesDetails.inc';
        break;
    default:
        break;
    
    case 'RoomDelete':
        include_once 'inc/RoomDeleteRoom.php';
        break;
    case 'RoomCheckList':

        include_once 'inc/RoomCheckList.php';
        break;
    
    case 'Report':
        include_once 'inc/PropertiesReport.php';
        break;
    
    case 'PropertyCheckList':
        include_once 'inc/PropertiesCheckList.php';
        break;
    
    case 'ReportPrint':
        include_once 'inc/PropertiesReportPrint.php';
        break;
    
    case 'ReportList':
        include_once 'inc/ReportList.php';
        break;
}

include_once 'Footer.php';
?>

    </body>