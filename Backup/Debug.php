<?php

include_once 'connectDB.php';
//include_once 'Header.php';


$RemoteAddress = $_SERVER['REMOTE_ADDR'];
$todaysdate = date("Y-m-d");

switch (@$_REQUEST['DebugAction']){
    
    case 'on':
        
            $sql = "SELECT * FROM Debug where IP = '$RemoteAddress'";

            $result = mysql_query($sql);

            if($result === FALSE) { 
                die(mysql_error()); 
            }
            $result_list = array();
    while($row = mysql_fetch_array($result)) {
        $result_list[] = $row;
    }
    DebugEcho(var_dump($result_list));
        if(empty($result_list)){
            $FullName = $_SESSION['FullName'];
                      $sql = "Insert into Debug (User, IP, Expires, DebugActivated) VALUES ('$FullName','$RemoteAddress', '$todaysdate', '1')";
            $result = mysql_query($sql);

            if($result === FALSE) { 
                die(mysql_error()); 
            
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        }
            foreach ($result_list as $DebugUsers) {
                
        if($RemoteAddress = $DebugUsers['IP']){
        
            $sql = "update Debug set DebugActivated='1', Expires='$todaysdate' where IP = '$RemoteAddress'";
            $result = mysql_query($sql);

            if($result === FALSE) { 
                die(mysql_error()); 
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else {
        
      
            }}
    break;
    

    case 'off':
        
        $sql = "update Debug set DebugActivated='0' where IP = '$RemoteAddress'";
        $result = mysql_query($sql);

            if($result === FALSE) { 
                die(mysql_error()); 
            
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    break;
}


$sql = "SELECT * FROM Debug where IP = '$RemoteAddress' and Expires >= '$todaysdate' and DebugActivated='1'";

$result = mysql_query($sql);

if($result === FALSE) { 
    die(mysql_error()); 
}

$result_list = array();
    while($row = mysql_fetch_array($result)) {
        $result_list[] = $row;
    }
    
    
    
    foreach ($result_list as $DebugUsers) {
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

