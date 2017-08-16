<?php
$access_token = 'mgdv3EKByCK+cQoaMC91XwpjTsAFsp2G3DbVME0dqUcZJaCVt6UetZ0s1nsOpNypU7DGGBL8jtm4G1vBVRFkfZ1eLtyA/gJx3cy2WBQKqjrQbezRW6TZgilx1cZoqSosoilmyjlFBz5NLO838gLb3QdB04t89/1O/w1cDnyilFU=';
$proxy = 'velodrome.usefixie.com:80';
$proxyauth = 'fixie:k1McVV5HMlWJRdF';
$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// add proxy
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
