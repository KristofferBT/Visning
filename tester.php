<?php


function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

echo file_get_contents('https://www.eiendomsmegler1.no/bolig/kjoepe-bolig/boliger/?rows=25&sort=1&page=1&CATEGORY=homes&lat=&lon=&areaId=20146');

$echo = get_data('https://www.eiendomsmegler1.no/bolig/kjoepe-bolig/boliger/?rows=25&sort=1&page=1&CATEGORY=homes&lat=&lon=&areaId=20146');
echo $echo;


//$test = hash('sha256','test');
//echo $test . "<br>";
//
//function generateRandomString($length = 10) {
//    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//    $charactersLength = strlen($characters);
//    $randomString = '';
//    for ($i = 0; $i < $length; $i++) {
//        $randomString .= $characters[rand(0, $charactersLength - 1)];
//    }
//    return $randomString;
//}
//
//$rand = generateRandomString();
//echo "Rand: " . $rand . "<br>";
//$test2 = 'test' . $rand;
//$test2 = hash('sha256',$test2);
//echo $test2 . "<br>";