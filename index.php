<?php

// parameters

$access_token = "EAAZAYXcihWGoBAPtSX1pCBH7K6nN6MN1olKDEdB0U4aliU6hCaR2d9CgMacaHUsGbYFF7pdXzREttaIi2YSSnakO8BFP2qUdKi91L0RgoUJMF3RsB9afq9jQgKxnXpzg5ZAqfszwe5CEsqewhyp02f8ZBohiI0U6fgo4ZA4gWxFCpJNCIakB";
	$verify_token="digi_lib";
	$hub_verify_token = null;

	if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode']=='subscribe') {
		$challenge = $_REQUEST['hub_challenge'];
		$hub_verify_token = $_REQUEST['hub_verify_token'];
		
		if ($hub_verify_token === $verify_token) 
		{
			echo $challenge;
			die;
		}
	}
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = isset($input['entry'][0]['messaging'][0]['message']['text'] )? $input['entry'][0]['messaging'][0]['message']['text'] : ' ';
if($messageText){
//$response = null;
$answer="";
if($messageText == "hey") {
    $answer = "Hello";
}
 else {
$answer="by";    
}
//send message to facebook bot
$response = '{
			"recipient":{
				"id":"'.$senderId.'"
			},
			"message":{
				"text":"'.$answer.'"
			}
		}';
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,1);
if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
}
curl_close($ch);
}
?>