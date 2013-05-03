<?php

/*
	Licence-Terms
	===============
	
	This project is protected by Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported licence
	Please read the online version of this licence here:
		http://creativecommons.org/licenses/by-nc-sa/3.0/
	
	An offline copy is in the root folder of this project by the name "licence.pdf"

	This licence is to keep the commercial fishes off the waters. Don't be disheartened. I am always an email away :)
		Mail me at: prashant.dwivedi@outlook.com
*/

?>

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
