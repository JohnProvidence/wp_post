<?php
$ch = curl_init();

$url = 'https://platform.quip/com/1/websockets/new';

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$resp = curl_exec($ch);

if(!$resp) {
	dir('Error: '.curl_error($curl).'" - Code: '. curl_errno($curl));
} else {
	return $resp;
}



?>