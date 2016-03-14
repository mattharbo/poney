<?

$newhackedname="matthieu";

$stats = "./hnG9yd4m1yl4nZM0SZjz3uzl.json";

$json = file_get_contents($stats); 
$data = json_decode($json,true);
$match = 0;

foreach ($data['users'] as $user) {
	if ($user['username']==$newhackedname){
		++$match;
		$user['numberofhack']=0;
	}
}

print_r($data);

echo "is there a match ? ".$match;
if ($match==1) {
	echo "<br>Number of hack for the user match ".$data['users'][0]['numberofhack'];
}


// unset($file);//prevent memory leaks for large json.
// //insert data here
// // $data['users'][0]['id'] = 007;
// // $data['users'][0]['id'] = array('data'=>'some data');
// //save the file
// file_put_contents('./hnG9yd4m1yl4nZM0SZjz3uzl.json',json_encode($data));
// unset($data);//release memory



?>