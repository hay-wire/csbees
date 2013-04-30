<?php
	require_once('functions.php');
	
	//	SECURITY CHECKS	
	require_once('includes.php');
	
	//retrieve the user
	$authMan = new AuthManager();
	

	$err = TRUE;
	$fileHREF = '#';
	
	if(isset($_GET['downloadId']))
	{	$downloadId = cleanString($_GET['downloadId']);
		$conn = dbconnect();
		$query = 'Update uploads Set downloadCount=downloadCount+1 where id="'.$downloadId.'"';
		$result = $conn->query($query);
		//var_dump($c);
		$query = 'Select path, id from uploads where id="'.$downloadId.'" and allowed=1';
		$result = $conn->query($query);
		if($result)
		{	$data = $result->fetch_assoc();
			if($data)
			{	//header('Location: http://csbees.neurals.in/'.$data['path']);
				if(!file_exists($data['path']))
				{
					$pathArray = explode("/", $data['path']);
					$folder = $pathArray[0];
					$fileName = $pathArray[1];
					//var_dump($pathArray);
					$path = __UPLOADS_BACKUP_FOLDER_RELATIVE_PATH_WITH_SLASH.$fileName;
					
					if(!file_exists($path))
					{	$to = __CSBEES_MONITOR_EMAIL;
						$subject = "CSBEES:: Non Existent File Queried from database (No backup even)!";
						$message = "A successful query ran for a non existing file (which is not even present in backup) with details:
	FILE ID: ".$data['id']."
	FILE PATH: ".$data['path'];
								
						$from = "no_reply_csbees@neurals.in";
						$headers = "From:" . $from;
						@mail($to,$subject,$message,$headers);
						die('404 - Either wrong file name or file has been removed.');
					}
					
					$data['path'] = $path;
					$to = __CSBEES_MONITOR_EMAIL;
					$subject = "CSBEES:: Non Existent File Queried from database!";
					$message = "A successful query ran for a non existing file (which is available in backup :-) ) with details:
	FILE ID: ".$data['id']."
	FILE PATH: ".$data['path'];
							
					$from = "no_reply_csbees@neurals.in";
					$headers = "From:" . $from;
					@mail($to,$subject,$message,$headers);
					
				}		
				
				//echo '<br/><br/>path='.$path;
				//die();
				//header('Content-disposition: attachment; filename='.$data['path']);
				//header('Content-type: '.$data['path']);
				//readfile($data['path']);
				header('Location: '.__WEBSITE_URL.$data['path']);
				$fileHREF = '<a href="'.$data['path'].'">Download Here</a>';
				$err=FALSE;
			}
		}

		
	}




/*************************************************************************************************************************/
/*************************************************************************************************************************/
/********************************************    GENERATE HEADER   *******************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/


	$HTMLheaderParams = array (
				'isloggedIn'		=>	$authMan->socialuser->isloggedIn(),
				'title'			=>	'Welcome',
				'includedHeadLinks'	=>	NULL,
				'userfullname'		=>	$authMan->socialuser->getName(),
				'logoutURL'		=>	$authMan->socialuser->getlogoutURL(),
				'loginURL'		=>	$authMan->socialuser->getfbloginURL()
				);
				
	

	if($err)
		header('Location: '. __ERROR_PAGE_URL);
	else
		echo '<div style="margin-top:100px;"><br/>If file downloading does not starting automatically, please click <a href="'. $fileHREF .'">here.</a><br/></div>';
	
	
		
	
	//header('Location: http://csbees.neurals.in');

?>
	
	
	