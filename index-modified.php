<?php


require_once('includes.php');

//	retrieve the user
$authMan = new AuthManager();
$csbeesMan = new CSBeesManager();



// output buffer
$buffer = NULL;


if(isset($_GET[__PAGE_VIEW_KEYWORD]))
{	switch($_GET[__PAGE_VIEW_KEYWORD])
	{	case __FILEDETAILS_PAGE_KEYWORD: $uploadDetailsParams['fileid'] = (int) $_GET['fileid']; 
						 $buffer.= loadView('uploadDetails',  $uploadDetailsParams);
						 break;	


						/*********************************************************************************/


		case __UPLOAD_PAGE_KEYWORD:	$contentParams = array();
						if(isset($_POST["uploadAttempted"]))
						{	$newUploadMsgs = $csbeesMan->uploadNewFile($authMan->socialuser->getRefID());
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
						$contentParams = $csbeesMan->getAllUploadBoxDetails($customisedDownloadingSelections);
						$contentParams['isloggedIn'] = $authMan->socialuser->isloggedIn();
						$contentParams['error'] = $newUploadMsgs['error'];
						$contentParams['msg'] = $newUploadMsgs['msg'];
						$buffer.= loadView('uploadBox', $contentParams);
						break;
					

						/*********************************************************************************/					
					
		case __HOME_PAGE_KEYWORD:	$customisedDownloadingSelections = array (
									'isloggedIn'	=>	$authMan->socialuser->isloggedIn(),
									'refID'		=>	$authMan->socialuser->getRefID(),
									'college'	=>	$authMan->socialuser->getColl(),
									'course'	=>	$authMan->socialuser->getCourse(),
									'dept'		=>	$authMan->socialuser->getBranch(),
									'semester'	=>	$authMan->socialuser->getSem(),
									'userSubjectsList' => 	$authMan->socialuser->getUserSubjects()
									);
						$buffer.= loadView('generateAllDownloadsList', $customisedDownloadingSelections);
						break;

						/*********************************************************************************/					
					
		//else load the index page				
		default:			$customisedDownloadingSelections = array (
									'college'	=>	$authMan->socialuser->getColl(),
									'course'	=>	$authMan->socialuser->getCourse(),
									'dept'		=>	$authMan->socialuser->getBranch(),
									'semester'	=>	$authMan->socialuser->getSem()
									);
					
						$buffer.= loadView('generateAllDownloadsList', $customisedDownloadingSelections);
						break;

	}


}


$sideBarParams = array( 'tags' => $authMan->db->getTags('newest', 50)
			);
			
$buffer .= loadView('sideBar',  $sideBarParams);
						
$buffer .= loadView('adsBox');





//flush output

echo $buffer;












/*************************************************************************************************************************/
/*************************************************************************************************************************/
/********************************************    NOW UPLOAD BOX  *******************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/




/*************************************************************************************************************************/
/*************************************************************************************************************************/
/********************************************    NOW DOWNLOAD BOX  *******************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/




/*************************************************************************************************************************/
/********************************************    NOW SIDEBAR  *******************************************************/
/*************************************************************************************************************************/


/*************************************************************************************************/
/*********************Go home shaun.. i want to click an ad***************************************/
/*************************************************************************************************/
?>
