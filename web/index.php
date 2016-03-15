<?php

# Grab some of the values from the slash command, create vars for post back to Slack
$token = $_POST['token'];
$responseurl=$_POST["response_url"];
$username=$_POST["user_name"];
$userid=$_POST["user_id"];
$text = $_POST['text'];
$champagne = 0;
$concattext="Standing : \n";

if ($token=='hnG9yd4m1yl4nZM0SZjz3uzl') {


########################################################################################################################################################

$stats = "./hnG9yd4m1yl4nZM0SZjz3uzl.json";

$json = file_get_contents($stats); 
$data = json_decode($json,true);
$tocomplete = 0;
$index = 0;
$todaysdate=date('Ymd_h:i:s');

	foreach ($data['users'] as $user) {
		++$index;
		if ($user['username']==$username){
			++$tocomplete;
			$match=$index-1;
		}
	}

	if ($tocomplete==1) {
		$data['users'][$match]['numberofhack']=$data['users'][$match]['numberofhack']+1;

	if ($data['users'][$match]['numberofhack'] % 3 == 0 and $data['users'][$match]['numberofhack'] != 1) {
			$champagne = 1;
		}

		array_push($data['users'][$match]['hackdetails'], array('date'=>$todaysdate, 'associatedtext'=> $text));
	}else{
		array_push($data['users'], array('id' => $userid, 'username' => $username, 'numberofhack'=>'1', 'hackdetails' => array(array('date'=> $todaysdate, 'associatedtext' => $text))));
	}

	$arraytosort=array();

	foreach ($data['users'] as $user2) {
		$arraytosort[$user2['username']] = $user2['numberofhack'];
		arsort($arraytosort);
	}

	if ($champagne ==1) {
		$concattext = ":champagne: *shower !* \n";
	}

	foreach ($arraytosort as $key => $value) {
			$concattext=$concattext.($key." ".$value."\n");
		}

	unset($file);//prevent memory leaks for large json.
	file_put_contents($stats,json_encode($data));//save the file
	unset($data);//release memory

	$jsonData = [
		"response_type" => "in_channel",//if you want to set this message to private
		"text" => "@channel : ".$username." has been *poneyhacked* :smirk: ".$text,
		'attachments' => [[
			'text' => $concattext,
			'color' => '#AED3FF'  
		]]//end attachments
	];


########################################################################################################################################################
      
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

}else{
	echo "No able to use this service :joy:";
}

?>