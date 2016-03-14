<?

$newhackedname="MHA";

$stats = "./hnG9yd4m1yl4nZM0SZjz3uzl.json";

$json = file_get_contents($stats); 
$data = json_decode($json,true);
$tocomplete = 0;
$index = 0;
$todaysdate=date('Ymd_h:i:s');

foreach ($data['users'] as $user) {
	++$index;
	if ($user['username']==$newhackedname){
		++$tocomplete;
		$match=$index-1;
	}
}

if ($tocomplete==1) {
	$data['users'][$match]['numberofhack']=$data['users'][$match]['numberofhack']+1;
	array_push($data['users'][$match]['hackdetails'], array('date'=>$todaysdate, 'associatedtext'=>'blabla'));
}else{
	array_push($data['users'], array('id' => 'x', 'username' => $newhackedname, 'numberofhack'=>'1', 'hackdetails' => array(array('date'=> $todaysdate, 'associatedtext' => 'x'))));
}

// print_r($data['users']);

foreach ($data['users'] as $user2) {
		$concattext=$concattext.($user2['username']." ".$user2['numberofhack']."\n");
	}

echo $concattext;

unset($file);//prevent memory leaks for large json.
//save the file
file_put_contents('./hnG9yd4m1yl4nZM0SZjz3uzl.json',json_encode($data));
unset($data);//release memory

?>