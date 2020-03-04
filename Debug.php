<?php

include_once 'connectDB.php';
//include_once 'Header.php';


$RemoteAddress = $_SERVER['REMOTE_ADDR'];
$todaysdate = date("Y-m-d");

switch (@$_REQUEST['DebugAction']){
    
    case 'on':
        
            $sql = "SELECT * FROM [Debug] where IP = '$RemoteAddress'";
            $result = $dbh->query($sql);
            
            foreach ($result as $row) {
                
            }   
        if(empty($row)){
            $FullName = 'test'; //$_SESSION['FullName'];
                      $sql = "Insert into [Debug] ([User], IP, Expires, DebugActivated) VALUES ('$FullName','$RemoteAddress', '$todaysdate', '1')";
            
            $stmt = $dbh->query($sql);
            
        header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        }
            foreach ($row as $DebugUsers) {
                
        if($RemoteAddress = @$DebugUsers['IP']){
        
            $sql = "update [Debug] set DebugActivated='1', Expires='$todaysdate' where IP = '$RemoteAddress'";
            
            $stmt = $dbh->query($sql);
            
            header('Location: ' . @$_SERVER['HTTP_REFERER']);
        }
        else {
        
      
            }}
    break;
    

    case 'off':
        
        $sql = "update [Debug] set DebugActivated='0' where IP = '$RemoteAddress'";
        $stmt = $dbh->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    break;
}


$sql = "SELECT * FROM [Debug] where IP = '$RemoteAddress' and Expires >= '$todaysdate' and DebugActivated='1'";

$stmt = $dbh->query($sql);

    foreach ($stmt as $DebugUsers) {
        if($RemoteAddress = $DebugUsers['IP'] and $DebugUsers['DebugActivated'] === '1'){
            $GLOBALS['DebugMode'] = '1';
            ECHO "<b>Debug Activated</b></br>";
            
        }
    }
    
  function DebugEcho($msg) {
      if(@$GLOBALS['DebugMode'] === '1'){

          error_reporting(E_ALL);
            ini_set('display_errors', 1);

            echo "</br>Debug: " . $msg . "</br>";
            }
      
  } 


         




?>

