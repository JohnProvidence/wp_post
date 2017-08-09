

$titles = array();


function getPages($rpcurl, $username, $password) {

	global $titles;

	$params = array(1, $username, $password);

	$request = xmlrpc_encode_request('wp.getPageList', $params);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_URL, $rpcurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	$results = curl_exec($ch);

	curl_close($ch);

	$response = xmlrpc_decode($results);

	//var_dump($response);

	foreach($response as $page) {

		$titles[] = array(
			'title'=>$page['page_title'],
			'id'=>$page['page_id'],
			'page_parent_id' => $page['page_parent_id']
			);

	}


}

getPages('http://dev-ppldev.pantheonsite.io/xmlrpc.php', 'jbent', 'Flight714!');

function editPage($page_title, $page_id, $rpcurl, $user, $pass) {	

	$content = array(
		'title'=>$page_title,
		'description'=>'AAGGGGGGGGGGGGGGGGGGGGGGGG'
		);

	$params = array(0, $page_id, $user, $pass, $content, true);

	$request = xmlrpc_encode_request('wp.editPage', $params);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_URL, $rpcurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);
	$results = curl_exec($ch);
	curl_close($ch);
	return $results;

	var_dump($results);

}

$page_title = 'Test Page - PPL';
$page_id = '219';
$rpcurl = 'http://dev-ppldev.pantheonsite.io/xmlrpc.php';
$user = 'jbent';
$pass = 'Flight714!';

editPage($page_title, $page_id, $rpcurl, $user, $pass);






?>
