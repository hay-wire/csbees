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

//	csbees/auth/AuthManager.class.php
//	=================================


require_once('includes.php');


class AuthManager
{	public $socialuser;
	public $db;
	public $fbClassObj;
	public $newUserSignupFlag;
	
	public function __construct()
	{	$this->fbClassObj = new SocialFB();
		if(!($this->db = new DB()))
			die('<br/>Oops! Something went wrong! Try refreshing the browser or closing and reopening it again!<br/>');
		
		
		//try to retrieve previously saved user from session
		if(isset($_SESSION['user']))
		{	//echo 'constructor: got session user'; 
			$this->socialuser = $_SESSION['user'];
			//if profile was changed in previous request, update it from the database.
			if($this->socialuser->profileNeedsRefresh())
			{	$type = $this->socialuser->getUserType();
				if($type != $this->generateNewSocialUser($type))
				{	$error .= '<li>Sorry! Something went wrong with your session.</li>
						  <li>Try logging out and relogin again.</li>';
				}
				
				//echo '<br/><br/>authman constructor Generating socialuser';
				$this->socialuser = $this->generateNewSocialUser($type);
			}
		}
		else
		{	//echo 'constructor: got guest user'; 
			//construct a guest user, as passing nothing in generateNewUser will cause it to create default user (guest)
			//echo 'creating guest user';
			$this->generateNewSocialUser(null);
		}
	}
	
	public function announceNewUploadPublicly($uploadtitle, $link)
	{	if($this->socialuser->getUserType()=="fb")
		{	$data = array(	
							'message'   => 'I uploaded "'. $uploadtitle .'" on CSBEES! Click the link below to access it',
							'name'      => 'CSBEES',
							'link'      => $link,
							'description'=> 'CSBEES helps u to download & create digital backup of your notes + a lot more!',
							'picture'   => __FB_POSTS_CSBEES_ICON, //'http://csbees.neurals.in/images/class_notes.jpg',
							'caption'   => 'Class Notes Management & Sharing Portal | CSBEES',
								
						);
			$this->fbClassObj->publishOnWall($data);
			//die('-------new user flag true--------');
		}
		
	}
	
	public function announceNewUserPublicly()
	{	if($this->newUserSignupFlag==TRUE)
		{	
			if($this->socialuser->getUserType()=="fb")
			{	$data = array(	
						'message'   => 'I use CSBEES :)',
						'name'      => 'CSBEES',
						'link'      => 'csbees.neurals.in',
						'description'=> 'CSBEES is a network of students and professors who share classroom notes!',
						'picture'   => __FB_POSTS_CSBEES_ICON,	//'http://csbees.neurals.in/images/class_notes.jpg',
						'caption'   => 'Class Notes Anytime | CSBEES',
							
					);
				$this->fbClassObj->publishOnWall($data);
				//die('-------new user flag true--------');
			}
		}
		//die('from newUserSignedUP() :D');
		$this->newUserFlag=FALSE;
	} 

	//this function sets into $this->socialuser, a new user of type defined by $type (default is guest user)
	public function generateNewSocialUser($type)
	{	$this->socialuser = null;
		//session_unset();
		//session_destoy();
		switch($type)
		{	case "fb":		$user_profile = $this->getProfileOfFBUserLoggedin();
						//echo '<br/><br/>generateNewSocialUser:: user_profile (fb) = ';
						//var_dump($user_profile);
						if($user_profile['loggedIn'])
						{	$user_profile['type'] = "fb";
							$dbprofile = $this->db->manageUserLogin($user_profile);
							//print_r($dbprofile);
							//die('inside generateNewSocialUser--type=fb');
							if($dbprofile['newUser'])
							{	$this->newUserSignupFlag = TRUE;
								if($dbprofile['error'] == TRUE)
									$user_profile['msg'] .= '<li>Error in registration! Please try again.</li>';
								else
									$user_profile['msg'] .= '<li>Welcome! Please complete your profile <a href="'.__PROFILE_PAGE_URL.'">here</a> for a better experience!</li>'; 
							}
							$user_profile['name'] = $dbprofile['name'];
							$user_profile['college'] = $dbprofile['college'];
							$user_profile['semester'] = $dbprofile['semester'];
							$user_profile['branch'] = $dbprofile['branch'];
							$user_profile['course'] = $dbprofile['course'];
							$user_profile['reputation'] = $dbprofile['reputation'];
							$user_profile['userTagsList'] = $dbprofile['userTagsList'];
							
							/*echo '<br/><br/>AuthMan.php in generateSocialUser: $dbprofile::<br/>';
							var_dump($dbprofile);
							echo '<br/><br/>AuthMan.php in generateSocialUser: $user_profile::<br/>';
							var_dump($user_profile);
							*/
							
							$this->socialuser = new SocialUser($user_profile);
							
							//echo '<br/><br/>AuthMan.php in Generated SocialUser: $$this->socialuser::<br/>';
							//var_dump($dbprofile);
							
							
						}
						else
						{	//echo '<br/><br/>inside generateNewSocialUser: getProfileOfFBUserLoggedin() returns: '.var_dump($user_profile);
							//die();
							return FALSE;
						}
						
						break;

			default:		$params = array (
							'fbloginURL' => $this->fbClassObj->getFBLoginURL()
							);
						//echo 'default user creating';
						$this->socialuser = SocialUser::generateGuestUser($params);
						break;
		}
		$this->db->updateLog($this->socialuser->getRefID());
		if($this->newUserSignupFlag==TRUE)
		{	$this->announceNewUserPublicly();
		}
		$_SESSION['user'] = &$this->socialuser;
		return $type;
	}
	

	public function getProfileOfFBUserLoggedin()
	{	$user_profile = $this->fbClassObj->getFBUser();
		
		//only valid for simulating a facebook login while in development mode!
		/*if(__SIMULATE_FB_LOGIN)
		{	$user_profile['loggedIn'] = TRUE;
			$user_profile['refID'] = __SIMULATE_FB_LOGIN;
		}
		*/

		if($user_profile['loggedIn'] == TRUE)
			return $user_profile;
		else
			return FALSE;
	}
	


	public function logoutCurrentUser($type)
	{	switch($type)
		{	case "fb":	$this->fbClassObj->logout();
					break;
		}
		//unset($_SESSION);
		session_unset();
		session_destroy();
		//session_start();
	}
		
	public function manageSocialLogin($type)
	{	$this->socialuser = null;
		//url where user will be redirected after this function
		$redirectURL = 'unknown';
		//create new social user of type $type.. if this method returns false, user of asked $type is not logged in! in that case, redirect to login page to choose login option
		
		
		if( $this->generateNewSocialUser($type)!= $type)
		{	//login failed.. redirecting to login page with error message
			//$this->logoutCurrentUser($type);
			
			$_SESSION['loginError'] = 'invalid login';
			$redirectURL = __LOGIN_PAGE_URL;	//'/login.php';
		}
		else
		{	//user has successfully logged in.. send him to his destined page..
			$redirectURL = __INDEX_PAGE_URL;	'/index.php?loggedIn';
		}
		
		//echo '<br/><br/><br/><br/>After processing, socialuser object = <br/>'.var_dump($this->socialuser);
		//echo '<br/><br/><br/>returned type is: '.var_dump($type);
		//echo '<br/><br/>and session variable=<br/>'.var_dump($_SESSION);
		//die('<br/>by manageSocialLogin, you are being redirected to: <a href="'.$redirectURL .'">'.$redirectURL.'</a>');
		
		header('Location: '.$redirectURL);
			
	}	
	
	public function verifySocialUserLoggedIn($type)
	{	switch($type)
		{	case "fb":	if($this->fbClassObj->verifyFBUserLoggedIn($this->socialuser->getRefID()))
						return TRUE;

		}
		return FALSE;
	}
	
	public function isUserLoggedIn()
	{	if($this->socialuser->isloggedIn() == TRUE)
		{	if($this->verifySocialUserLoggedIn($this->socialuser->getUserType()))
					return TRUE;
		}
		
		//in all other casese return false
		return FALSE;		
	}
	
	
	public function restrictedPage($redirectUrl, $accessLevel=null)
	{
		if($this->isUserLoggedIn())
		{	// user is safely logged in
			if($accessLevel!=null)
				if($this->socialuser->getUserAccessLevel() == $accessLevel)
					return TRUE;
		}
		else
		{	// not logged in.. redirect to the url given
			//die('<br/>AuthMan::restrictedPage()-  Restricted area.. redirecting to <a href="'. $redirectUrl .'">here</a>' );
			header('Location: '.$redirectUrl);
		}
	}

	
	public function profileEditor($newDetails)
	{	if($this->socialuser->isloggedIn())
		{	$error = $this->db->checkUsernameExists($newDetails['name'], $this->socialuser->getRefID());
			if($error)
			{	$result['error'] = '<li>Username Already Taken. Try Something Different!</li>';
				return $result;
			}
			//echo '<userId=> '.$this->socialuser->getRefID();
			$success = $this->db->updateUser($this->socialuser->getRefID(), $newDetails);
			if($success)
			{	$msg .= '<li>Profile Updated!</li>
					';
				$type = $this->socialuser->getUserType();
				//echo '<br/>user type= '.$type;
				if($type != $this->generateNewSocialUser($type))
				{	$error .= '<li>Sorry! Something went wrong with your session.</li>
						  <li>Try logging out and relogin again.</li>';
				}
				
			}
			else
			{	$error .= '<li>Sorry! Something went wrong while updating! Please try again or contact us.</li>';
			}
			$result['error']=$error;
			$result['msg'] = $msg;
			return $result;
		}
	}
	
	public function userTagsEditor($tagsIDArray)
	{	$msg; $error=FALSE;
		if($this->socialuser->isloggedIn())
		{	
			if($this->db->setUserTags($this->socialuser->getRefID(), $tagsIDArray))
			{	$msg .= '<li>Subscription Tags Successfully Updated!</li>';
				$type = $this->socialuser->getUserType();
				if($type != $this->generateNewSocialUser($type))
				{	$msg .= '<li>Sorry! Something went wrong with your session.</li>
						  <li>Try logging out and relogin again.</li>';
					$error = TRUE;
				}
				
			}
			else
			{	$msg .= '<li>Sorry! Error updating your Tags.</li>
					<li>Please try again or contact us.</li>';
				$error = TRUE;
			}
			//$this->socialuser->forceProfileRefresh(True);
		}
		$result['error']=$error;
		$result['msg'] = $msg;
		return $result;
	
	}
	
	
	
/*	
	public function retrieveUser($type)
	{	if($this->socialUser->isloggedIn() == FALSE)
		{	if($this->socialuser == null)
			{	$profile = new SocialFB();
				$this->socialuser = new SocialUser();
				
				$refID = $profile['refID'];
				if( ($this->db = new DB()) )
				{	$profile['DBValues'] = $this->db->getUserDetails($refID);
				}				
			}
			
			$_SESSION['user'] = $this->socialuser;
		}
		return $this->socialuser;
	}
	
	
	//generic function to retrieve the type of user defined by argument..by default, it is facebook user
	public function retrieveSocialUser($type="fb")
	{	if(!$this->socialuser)
		{	if(isset($_SESSION['user']))
			{	$this->socialuser = $_SESSION['user'];
				if(!isset($this->socialuser->dbprofile))
				{	$refID = $profile['refID'];
					if( ($this->db = new DB()) )
					{	$profile['DBValues'] = $this->db->getUserDetails($refID);
					}
				}
			}
			else
			{	return FALSE
			}
		}
	}
*/	


}
