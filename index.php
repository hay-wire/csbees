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

require_once('includes.php');

//retrieve the user
$authMan = new AuthManager();
$csbeesMan = new CSBeesManager();


//ENSURE USER IS LOGGED IN
//$authMan->restrictedPage('login.php');


// output buffer
$buffer = NULL;


/********************************************    GENERATE HEADER   *******************************************************/

$HTMLheaderParams = array (
			'isloggedIn'		=>	$authMan->socialuser->isloggedIn(),
			'title'				=>	'Neurals',
			'includedHeadLinks'	=>	NULL,
			'userfullname'		=>	$authMan->socialuser->getName(),
			'logoutURL'			=>	$authMan->socialuser->getlogoutURL(),
			'loginURL'			=>	$authMan->socialuser->getfbloginURL() 
			);
			
$sideBarParams = array();
			

if(empty($_GET[__PAGE_VIEW_KEYWORD]) || !isset($_GET[__PAGE_VIEW_KEYWORD]) )
{
	$customisedDownloadingSelections = array (	'college'	=>	$authMan->socialuser->getColl(),
							'course'	=>	$authMan->socialuser->getCourse(),
							'dept'		=>	$authMan->socialuser->getBranch(),
							'semester'	=>	$authMan->socialuser->getSem()
							);
	$buffer.= loadView('generateAllDownloadsList', $customisedDownloadingSelections);

}
else
{	
	switch(cleanString($_GET[__PAGE_VIEW_KEYWORD]))		//this get variable has been used in generateAllDownloadsList.php also.
	{
		case __FILEDETAILS_PAGE_KEYWORD:
						 $uploadDetailsParams['fileid'] = (int) $_GET['fileid']; 
						$HTMLheaderParams['title'] = 'Notes Details: '.$uploadDetailsParams['fileid'];
						
						$fxnResult.= loadView('uploadDetails',  $uploadDetailsParams);
						$sideBarParams['notif'] = array (	'heading' => 'Notes Details',
											'content' => '	<ul>
														<li><b>Icon Images In The Left</b> enable you to vote up/down, download and share your notes.
														  </li>
														  <li> <b>Vote Up</b> Cick this button to vote up a note. Voting up increases uploader\'s reputation. Its like saying thanks to the uploader for his contribution to the community :-)
														  </li>
														  
														  <li><b>Vote Down</b> helps to tell the uploader that the quality of his note is not good and it needs some improvement. Vote Down decreases uploader\'s reputation.
														  </li>
														  
														  <li><b>Download</b> button helps you to save the notes in your computer, probably the mostly used button ;-)
														  </li>
														  
														  <li><b>Share</b> option gives you the link url which you can share with your friends to share the notes you find useful.
														  </li>
													</ul>'
										);
										
										
						break;	

						/*********************************************************************************/


		case __UPLOAD_PAGE_KEYWORD:	if(!$authMan->socialuser->isloggedIn())
						{	header('Location: '.__LOGIN_PAGE_URL);
							die('<a href="'.__LOGIN_PAGE_URL.'">login first</a>');
						}
						
						$HTMLheaderParams['title'] = 'New Upload';
												
						$uploadBoxParams = array();
						$newUploadMsgs = NULL;
						if(isset($_POST["uploadAttempted"]))
						{	$newUploadMsgs = $csbeesMan->uploadNewNote($authMan->socialuser->getRefID());
							if(!empty($newUploadMsgs['shareUpload']))
							{	$shareLink = 'http://csbees.neurals.in#'.$newUploadMsgs['shareUpload']['id'];
								$authMan->announceNewUploadPublicly($newUploadMsgs['shareUpload']['topic'], $shareLink);
							}
						}
						$customisedDownloadingSelections = array (
									'college'	=>	$authMan->socialuser->getColl(),
									'course'	=>	$authMan->socialuser->getCourse(),
									'dept'		=>	$authMan->socialuser->getBranch(),
									'semester'	=>	$authMan->socialuser->getSem()
									);
						$uploadBoxParams = $csbeesMan->getAllUploadBoxDetails($customisedDownloadingSelections);
						$uploadBoxParams['isloggedIn'] = $authMan->socialuser->isloggedIn();
						$uploadBoxParams['error'] = $newUploadMsgs['error'];
						$uploadBoxParams['msg'] = $newUploadMsgs['msg'];
						$fxnResult.= loadView('taggedUploadBox', $uploadBoxParams);
						//$buffer.= loadView('uploadBox', $uploadBoxParams);
						$sideBarParams['newTagsBox'] = TRUE;
						
						$sideBarParams['notif'] = array (	'heading' => 'How to Upload',
											
															'content' => '	<ul>
																		<li><b>Tags</b> are generally the subjects, colleges, topics etc related to your notes. Type in a few letters of your subject\/topic or college to see the available tags and choose those you need. In case there is no specific tag to describe your needs, you can create a new tag also. Example: type in "in" to choose from available tags with "in" like <b>in</b>dustrial management, eng<b>in</b>eering, etc.
																		</li>
																		
																		<li><b>Title</b> is a short sentence of your notes which tells everybody what is your notes about. For example: "Red Black Trees in Algorithms". It tells other users that the notes are about Red Black Trees which you study in algorithms.
																		</li>
																		
																		<li><b>Description</b> is brief description of your notes, that is, what is topics have been covered in your notes, if it is specific to your class only, etc etc.
																		</li>
																		
																		<li><b>File</b> Click on this button to navigate to and choose your notes file. For the list of valid file formats (extensions), <a href="'.__WIKI_PAGE_URL.'#rules"> click here</a>														
																		</li>
																	</ul>
																	Then Click on "Upload My Notes" to upload your notes.'
										);
							break;
			
				
						/*********************************************************************************/					

		case __HOME_PAGE_KEYWORD:	if(!$authMan->socialuser->isloggedIn())
						{	header('Location: '.__LOGIN_PAGE_URL);
							die('<a href="'.__LOGIN_PAGE_URL.'">login first</a>');
						}
						$customDownload = array (	'isloggedIn'	=>	$authMan->socialuser->isloggedIn(),
										'refID'		=>	$authMan->socialuser->getRefID(),
										'college'	=>	$authMan->socialuser->getColl(),
										'course'	=>	$authMan->socialuser->getCourse(),
										'dept'		=>	$authMan->socialuser->getBranch(),
										'semester'	=>	$authMan->socialuser->getSem(),
										'userTagsList' => 	$authMan->socialuser->getUserTags()
									);

						$HTMLheaderParams['title'] = 'Subscription Notes';
						
						$fxnResult.= loadView('generateAllDownloadsList', $customDownload);
						$sideBarParams['notif'] = array (	'heading' => 'Subscribed Notes',
											'content' => 'Welcome home!<br/>
													Here you will find latest notes which contain tags which you have subscribed for. You can always modify your tags list <a href="'.__PROFILE_PAGE_URL.'#mytags">here</a>
													'
										);
						break;
						/*********************************************************************************/					
	
		case __MY_UPLOADS_PAGE_KEYWORD:	if(!$authMan->socialuser->isloggedIn())
						{	header('Location: '.__LOGIN_PAGE_URL);
							die('<a href="'.__LOGIN_PAGE_URL.'">login first</a>');
						}
						$myUploads = array (	'isloggedIn'	=>	$authMan->socialuser->isloggedIn(),
										'refID'		=>	$authMan->socialuser->getRefID(),
										'userTagsList' => 	$authMan->socialuser->getUserTags()
									);
						$HTMLheaderParams['title'] = 'My Notes';
						
						$fxnResult.= loadView('generateAllDownloadsList', $myUploads);
						$sideBarParams['notif'] = array (	'heading' => 'Notes You Have Uploaded',
											'content' => 'This is the list of notes which you have uploaded on CSBees. Uploading helps you to keep an online backup of your notes which can be accessble from anywhere. It helps the community as well! :)'
										);

						break;
						

						/*********************************************************************************/					

		case __PROFILE_PAGE_KEYWORD:	$HTMLheaderParams['title'] = 'My Profile';
						if(!$authMan->socialuser->isloggedIn())
						{	header('Location: '.__LOGIN_PAGE_URL);
							die('<a href="'.__LOGIN_PAGE_URL.'">login first</a>');
						}
						$profileParams = array();
						if(isset($_POST['updateTags']))
						{	$tagsIDString = cleanString($_POST['updateTags']);
							$tagsIDArray = explode(',', $tagsIDString);
							$tmp = $authMan->userTagsEditor($tagsIDArray);
							$profileParams['msg'] = $tmp['msg'];
							$profileParams['error'] = $tmp['error'];
							//var_dump($tmp);
						}
						if(!$authMan->socialuser)
							$authMan = new AuthManager();
						//echo 'dumping user details: '.var_dump($authMan->socialuser);
						$profileParams['name'] = $authMan->socialuser->getName();
						//$profileParams['selectedCollege'] = $authMan->socialuser->getColl();
						//$profileParams['selectedCourse'] = $authMan->socialuser->getCourse();
						//$profileParams['selectedDept']	= $authMan->socialuser->getBranch();
						//$profileParams['selectedSemester'] = $authMan->socialuser->getSem();
						$profileParams['userTagsList']= $authMan->socialuser->getUserTags();
						
						$profileParams['editMode']= FALSE;
						if( isset($_GET['edit']) && ($_GET['edit']==TRUE))
						{	$profileParams['editMode']= TRUE;
						}
						$fxnResult .= loadView('profileBox', $profileParams);
						$sideBarParams['notif'] = array (	'heading' => 'Hello!',
											'content' => 'Its your profile. You can choose a nick for yourself and subscribe to various <a href="#tags">tags</a> too.'
										);

						break;
						
						/***************************************************************************/				
		case __SEARCH_PAGE_KEYWORD:	$searchParams = array();
		
						$HTMLheaderParams['title'] = 'Search Results';
						$result = array(	'error' => FALSE,
											'msg'	=> 'Unable to find any matching notes!<br/>How about trying some other keywords?',
											'searchResultHTML' => 'Unable to find any matching notes! How about trying some other keywords?'
									);
						
						if(isset($_GET['q']))
							$searchParams['query'] = cleanString($_GET['q']);

						
						//strip "," and multiple spaces and tabs and html entities in the form "&#ab3;" from the input
						$wordsList = str_replace(",", " ", $searchParams['query'] );
						$wordsList = preg_replace("/&#?[a-z0-9]{2,8};/i","",$wordsList);
						$wordsList = preg_replace('!\s+!', ' ', $wordsList);
						
						$wordsListArray = explode(" ", $wordsList);
						$searchParams['tags'] = explode("@", $wordsList);
												
						$wordsList = str_replace(" ", "* ", $wordsList);
						
						$wordsList = $wordsList.'*';
						
						//echo $wordsList;
						
						$fxnResult .= loadView('generateAllDownloadsList', array('searchStr'=> $wordsList));
						//var_dump($result);
						$sideBarParams['notif'] = array (	'heading' => 'Search Tips',
											'content' => 'Search feature is still under development. '
										);
						break;
						
		case __WIKI_PAGE_KEYWORD:	$HTMLheaderParams['title'] = 'Wiki';
						$fxnResult .= loadView('wiki');
						$sideBarParams['notif'] = array (	'heading' => 'Quick Contact',
											'content' => 'Prashant Dwivedi: +91-8826319519'
										);
						break;
						
		case __ERROR_PAGE_KEYWORD:	$HTMLheaderParams['title'] = 'Error!';
						$fxnResult .= loadView('error');
						break;
	}

	if($fxnResult!=FALSE)
	{	$buffer .= $fxnResult;
	}
	else
	{	$buffer .= loadView('notFoundError');
	}
}


//$buffer1 .=  ;
$buffer = loadView('headerHTML', $HTMLheaderParams) . $buffer;

$sideBarParams['tagsList'] = array( 'tags' => $authMan->db->getTags('newest', 50)
			);
$buffer .= loadView('sideBar',  $sideBarParams);
						
//$buffer .= loadView('adsBox');


//flush output
echo $buffer;


?>