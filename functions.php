<?php
function removeAttr($html, $sel) { // remove all attributes from Quip html documents in directory

	foreach($html->find($sel) as $s):

		if($s):
			foreach($s->getAllAttributes() as $attr => $val):
				$s->removeAttribute($attr);
			endforeach;
		endif;
	endforeach;

}

/*************************************************************
* Push documents from array to Wordpress Install
************************************************************/


function post_to_wordpress($title, $body, $rpcurl, $username, $password, $category='Uncategorized', $keywords='', $encoding='UTF-8') { 

	$title = htmlentities($title, ENT_NOQUOTES, $encoding);
	$keywords = htmlentities($keywords, ENT_NOQUOTES, $encoding);

	$content = array(
		'title'=>$title,
		'description'=>$body,
		'mt_allow_comments'=>0,
		'mt_allow_pings'=>0,
		'post_type'=>'page',
		'post_parent'=>10,
		'mt_keywords'=>$keywords,
		'categories'=>array($category)
		);

	$params = array(0, $username, $password, $content, true);

	$request = xmlrpc_encode_request('metaWeblog.newPost', $params);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	curl_setopt($ch, CURLOPT_URL, $rpcurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 1);

	$results = curl_exec($ch);
	curl_close($ch);

	return $results;

} 

?>