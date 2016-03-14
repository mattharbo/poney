<?php

# Grab some of the values from the slash command, create vars for post back to Slack
$token = $_POST['token'];
$responseurl=$_POST["response_url"];
$username=$_POST["user_name"];
$userid=$_POST["user_id"];
$text = $_POST['text'];

$jsonData = [
	"response_type" => "in_channel",//if you want to set this message to private
	"text" => "@channel : ".$username." has been *poneyhacked* :smirk: ".$text,
	'attachments' => [[
		'text' => 'Text 1',
		'color' => '#F35A00'  
	]]//end attachments
];
      
//Initiate cURL.
$ch = curl_init($responseurl);

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
         
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
         
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
         
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
         
//Execute the request
$result = curl_exec($ch);

?>