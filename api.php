<?php
 
$strAccessToken = "mgdv3EKByCK+cQoaMC91XwpjTsAFsp2G3DbVME0dqUcZJaCVt6UetZ0s1nsOpNypU7DGGBL8jtm4G1vBVRFkfZ1eLtyA/gJx3cy2WBQKqjrQbezRW6TZgilx1cZoqSosoilmyjlFBz5NLO838gLb3QdB04t89/1O/w1cDnyilFU=";
//$proxy = 'velodrome.usefixie.com:80';
//$proxyauth = 'fixie:k1McVV5HMlWJRdF';

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);
 
$strUrl = "https://api.line.me/v2/bot/message/reply";
 
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$_msg = $arrJson['events'][0]['message']['text'];
 
 
$api_key="fwSteo00yZkgXR0OurKQLJXfUUm9BXdK";
$url = 'https://api.mlab.com/api/1/databases/mistermhoo/collections/linebot?apiKey='.$api_key.'';
$json = file_get_contents('https://api.mlab.com/api/1/databases/mistermhoo/collections/linebot?apiKey='.$api_key.'&q={"question":"'.$_msg.'"}');
$data = json_decode($json);
$isData=sizeof($data);
 
if (strpos($_msg, 'สอนมิสเตอร์หมู') !== false) {
  if (strpos($_msg, 'สอนมิสเตอร์หมู') !== false) {
    $x_tra = str_replace("สอนมิสเตอร์หมู","", $_msg);
    $pieces = explode("|", $x_tra);
    $_question=str_replace("[","",$pieces[0]);
    $_answer=str_replace("]","",$pieces[1]);
    //Post New Data
    $newData = json_encode(
      array(
        'question' => $_question,
        'answer'=> $_answer
      )
    );
    $opts = array(
      'http' => array(
          'method' => "POST",
          'header' => "Content-type: application/json",
          'content' => $newData
       )
    );
    $context = stream_context_create($opts);
    $returnValue = file_get_contents($url,false,$context);
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = 'ขอบคุณที่สอนมิสเตอร์หมู';
  }
}else{
  if($isData >0){
   foreach($data as $rec){
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = $rec->answer;
   }
  }else{
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = 'อู๊ดดด คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนหมู[คำถาม|คำตอบ]';
  }
}
 
 
$channel = curl_init();
curl_setopt($channel, CURLOPT_URL,$strUrl);
curl_setopt($channel, CURLOPT_HEADER, false);
curl_setopt($channel, CURLOPT_POST, true);
curl_setopt($channel, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($channel, CURLOPT_RETURNTRANSFER,true);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($channel);
curl_close ($channel);
?>
