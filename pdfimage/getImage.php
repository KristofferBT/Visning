<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

error_reporting(E_ALL);
            ini_set('display_errors', 1);

            include_once '../inc/incFunctions.php';
            
            
            grab_image_room_checklist('3477', $dbh);