<?php

/* 
 * Visning 2016
 * Kristoffer Versvik Thygesen
 * kristoffervt@gmail.com
 */

if(isset($_REQUEST['KakeSpade'])){
    
    $KakeSpade = $_REQUEST['KakeSpade'];
    $KakeBit = $_REQUEST['KakeBit'];
    setcookie('KakeBit', $KakeBit, time()+60*60*24*365, 'https://www.tryggvisning.no/');
    setcookie('KakeSpade', $KakeSpade, time()+60*60*24*365, 'https://www.tryggvisning.no/');
    var_dump($_REQUEST);
}