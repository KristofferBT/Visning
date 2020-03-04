<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */
include_once 'ConnectDB.php';

function CheckAccess() {
    global $dbh;
    $Access = 'false';
    //var_dump($_SESSION);
    
        if(isset($_SESSION['LoggedIn'])){
        
    
    if($_SESSION['LoggedIn'] == 'true'){
        $Access = 'true';
  
    
    if(isset($_REQUEST['PropertyID'])&& isset($_SESSION['PropertyID'])){
        //Sjekke om $_Req ligger i Session array
        if(!in_array($_REQUEST['PropertyID'], $_SESSION['PropertyID'])){
            $Access = 'false';
            
            
        }
        else {
            $_SESSION['SelectedPropertyID'] = $_REQUEST['PropertyID'];
        }
        
    }
    
    if(isset($_REQUEST['RoomID']) && isset($_SESSION['RoomID'])){
        if(!in_array($_REQUEST['RoomID'], $_SESSION['RoomID'])){
            $Access = 'false';
            
        }
        else {
            $_SESSION['SelectedRoomID'] = $_REQUEST['RoomID'];
        }
    }
    
      }
   
    }

    if($Access == 'false'){
        include_once 'index.php';
    }
    return $Access;
}

