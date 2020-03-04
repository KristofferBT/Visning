<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$server = ".database.windows.net,1433";
$username = "user";
$password = "pass";
$database = "visning";
try
{
    $dbh = new PDO("sqlsrv:server=$server ; Database = $database", $username, $password);
    
}
catch(Exception $e)
{
    die(print_r($e));
    
}
