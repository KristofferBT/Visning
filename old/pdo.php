<?php  
print_r(PDO::getAvailableDrivers()); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$serverName = "(local)\visning";  
  
/* Connect using Windows Authentication. */  
try  
{  
$conn = new PDO( "sqlsrv:server=$serverName ; Database=visning", "", "");  
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
echo "success!";
}  
catch(Exception $e)  
{   
die( print_r( $e->getMessage() ) );   
}  