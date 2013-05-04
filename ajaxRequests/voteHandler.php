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

//		 csbees/ajaxRequests/voteHandler.php
//		============================================


//	SECURITY CHECKS	
require_once('../includes.php');

//retrieve the user
$authMan = new AuthManager();
$csbeesMan = new CSBeesManager();


$result = array (	'msg' => "",
			'votes' => "X",		// assume that we will get into some error and unable to get votesCount therefore.
			'error' => FALSE
		);

$fileid = cleanString($_GET['fileid']);
$voteNature = cleanString($_GET['voteType']);
$credits=0;						// credit won by uploader of the file

if( !(empty($voteNature) && empty($fileid) ))
{	$voteChange = -5;
	switch($voteNature)
	{	case 'VoteUp':		$voteChange = 1;
					$credits = __REPO_CHANGE_VOTE_UP;
					break;
					
		case 'VoteDown':	$voteChange = -1;
					$credits = __REPO_CHANGE_VOTE_DOWN;
					break;

		case 'Flag':		$voteChange = 0;
					$credits = __REPO_CHANGE_FLAGGED_UPLOAD;		//=0 as users repo in not changed on just by flagging a content
					break;
					
		default:		$result['msg'] = "Invalid Vote! Please refresh the page.";
					$result['error'] = TRUE;

	}
	
	//if($authMan->socialuser->getRepo() < __VOTING_REPO_THRESHOLD)
	//	$result['msg'] = "You need atleast ".__VOTING_REPO_THRESHOLD." reputation to vote.";
	//	$result['error'] = TRUE;

	if( $authMan->socialuser->isloggedIn() && (!$result['error']) )
	{	
		$result = $csbeesMan->voteForUpload($fileid, $voteChange, $authMan->socialuser->getRefID() );
		
	}
	else
	{	if(!$authMan->socialuser->isloggedIn())
		{	$result['msg'] = "Please login to vote for these Notes";
			$result['error'] = TRUE;
		}
	}
	
}
else
{	$result['msg'] = "Wierd Vote :o!! Please refresh the page.";
	$result['error'] = TRUE;
}

if($result['credits']!=0)
{	//echo 'credits='.$credits;	
	$params = array (	'fileID' => $fileid,
				'change' => $credits*$result['credits'],	//as $result['credits'] is always -1,0, or 1
				'type'	=> $voteNature,
				'notify' => FALSE
			);

	loadEvent('changeRepo', $params);
}

if(empty($result['msg']))
	$result['msg']= "";

if(empty($result['error']))
	$result['error'] = false;

echo json_encode($result);

