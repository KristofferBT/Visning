<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$server = "SERVERNAME.database.windows.net,1433";
$username = "username";
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

//Azure BLOB connection

require_once 'vendor/autoload.php';
use WindowsAzure\Common\ServicesBuilder;            
use MicrosoftAzure\Storage\Common\ServiceException;

$connectionString = 'DefaultEndpointsProtocol=https;AccountName=SERVERNAME;AccountKey=12345';

$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);


//SendGrid mail ext
