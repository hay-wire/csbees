<?php

//		 csbees/ajaxRequests/newTagsHandler.php
//		============================================


//	SECURITY CHECKS	
require_once('../includes.php');

//retrieve the user
$authMan = new AuthManager();
$csbeesMan = new CSBeesManager();


$result = array (	'msg' => "",
			'error' => false,
			'data' => ""
		);

	//if($authMan->socialuser->getRepo() < __VOTING_REPO_THRESHOLD)
	//	$result['msg'] = "You need atleast ".__VOTING_REPO_THRESHOLD." reputation to vote.";
	//	$result['error'] = TRUE;
	
	$name = cleanString($_GET['tagName']);
	$acronym = cleanString($_GET['tagAcronym']);
	$type = cleanString($_GET['tagType']);
	
	//capitalise name and acronym
	$name = ucwords( strtolower($name));
	$acronym = strtolower($acronym);
	$type = strtolower($type);
	
	if(!$authMan->socialuser->isloggedIn())
	{	$result['msg'] = "Unauthorised Request! Login to create a new tag";
		$result['error'] = true;
		header('Location: '. __LOGIN_PAGE_URL.'?unauthorisedAccess');
		echo json_encode($result);
		die();
	}
	
	if(($type != 'college' && $type != 'subject' && $type != 'topic' ) )
	{	$result['error'] = true;
		$result['msg'] = "Invalid tag type: $type! Please choose a valid tag type from the list.";
		echo json_encode($result);
		die();
	}
	
	$result = $csbeesMan->createNewTag($name, $acronym, $type, $authMan->socialuser->getRefID() );
	$JSON_String = null;
	
	$JSON_String = json_encode($result);
	
	echo $JSON_String;
	die();
	
?>