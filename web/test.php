<?

$newhackedname="eric";

$stats = "./test.json";

$json = file_get_contents($stats); 
$data = json_decode($json,true);
$tocomplete = 0;
$index = 0;
$champagne = 0;
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

	if ($data['users'][$match]['numberofhack'] % 3 == 0 and $data['users'][$match]['numberofhack'] != 1) {
		$champagne = 1;
	}

	array_push($data['users'][$match]['hackdetails'], array('date'=>$todaysdate, 'associatedtext'=>'blabla'));
}else{
	array_push($data['users'], array('id' => 'x', 'username' => $newhackedname, 'numberofhack'=>'1', 'hackdetails' => array(array('date'=> $todaysdate, 'associatedtext' => 'x'))));
}

$arraytosort=array();

foreach ($data['users'] as $user2) {
	$arraytosort[$user2['username']] = $user2['numberofhack'];
	arsort($arraytosort);
}

if ($champagne ==1) {
	$concattext = ":champagne: ";
}

foreach ($arraytosort as $key => $value) {
		$concattext=$concattext.($key." ".$value."\n");
	}

echo $concattext;

unset($file);//prevent memory leaks for large json.
//save the file
file_put_contents('./test.json',json_encode($data));
unset($data);//release memory

?>