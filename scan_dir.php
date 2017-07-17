<?php
require('simplehtmldom/simple_html_dom.php');
require('functions.php');

$dir = 'import';

$scan = preg_grep( '/^([^.])/', scandir($dir) );

$sel = array(
	'p', 
	'table', 
	'td',
	'th',
	'tr',
	'h2',
	'h3', 
	'h4', 
	'h5', 
	'h6', 
	'ul', 
	'ol', 
	'dl', 
	'li', 
	'div',
	'span',
	'font',
	'strong',
	'em'
	 );

$content = array();

foreach($scan as $file):
	
	$html = file_get_html($dir.'/'.$file);

	foreach($sel as $node):
		removeAttr($html, $node);
	endforeach;

	$title = $html->find('title', 0)->plaintext;

	$rmTitle = $html->find('h1', 0);

	$rmTitle->outertext = ' ';

	$html->save();

	$body = $html->find('div', 0)->innertext;

	$post_content[] = array(
		'title'=>$title,
		'body'=>$body
		);


endforeach;

foreach($post_content as $page):

	echo $page['title'];

	$title = $page['title'];
	$body = $page['body'];
	$rpcurl = 'http://dev-ppl-sandbox.pantheonsite.io/xmlrpc.php';
	$username = 'ppl-devel';
	$password = 'rz@e9Aet6JZJ0fA5E1';
	$category = 'test';
	
	if($title != '' && $body != ''):
		$chk = post_to_wordpress($title, $body, $rpcurl, $username, $password, $category, $keywords='', $encoding='UTF-8');
	endif;

	if($chk) {
		echo $chk;
	} else {
		echo 'nope';
	}

endforeach;

?>