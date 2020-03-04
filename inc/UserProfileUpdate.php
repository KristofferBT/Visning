<?php
 error_reporting(E_ALL);
            ini_set('display_errors', 1);
/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

include_once '../ConnectDB.php';

print_r($_POST);
$value = $_POST['value'];
$name = $_POST['name'];
$pk = $_POST['pk'];

$sql = "update [user] set $name = :value, UserLastUpdated = getdate() where UserID = '$pk'";

$stmt = $dbh->prepare($sql);

//$stmt->BindValue(':name', $name);
$stmt->BindValue(':value', $value, PDO::PARAM_STR);
//$stmt->BindValue(':pk', $pk);


$stmt->Execute();
var_dump($stmt);
