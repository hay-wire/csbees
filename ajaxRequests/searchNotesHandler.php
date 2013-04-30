<?php
/*
require_once('../includes.php');
//retrieve the user
$authMan = new AuthManager();
$csbeesMan = new CSBeesManager();

$result = array(	'error' => FALSE,
			'msg'	=> 'Unable to find any matching notes!<br/>How about trying some other keywords?',
			'searchResultHTML' => 'Unable to find any matching notes! How about trying some other keywords?'
	);

//strip "," and multiple spaces and tabs and html entities in the form "&#ab3;" from the input
$wordsList = str_replace(",", " ", cleanString($_GET['search']) );
$wordsList = preg_replace("/&#?[a-z0-9]{2,8};/i","",$wordsList);
$wordsList = preg_replace('!\s+!', ' ', $wordsList);
$wordsList = str_replace(" ", "* *", cleanString($_GET['search']) );
$wordsList = '*'.$wordsList.'*';


$result = $csbeesMan->searchNotes($wordsList);

if(!$results['error'])
	$results = loadView('searchPage', $results[''])

var_dump($result);
//echo json_encode($result);
*/
?>	
