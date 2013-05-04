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
//this script sees if a user is logged in, then returns the user details in an array, else, return a false value

//	csbees/auth/fb/SocialFB.class.php
//	================================

//error_reporting(E_ALL);
require_once('fb-sdk/facebook.php');

class SocialFB
{
	private $facebook;
	private $loginParams;
	public $loginURL;
	private $appId;
	private $appSecret;

	public function __construct()
	{	//echo 'fb created';		
		
		$this->facebook = new Facebook(array( 
							'appId'  => __FB_APP_ID,
							  'secret' => __FB_APP_SECRET
						));

		$this->loginParams = array( 'scope' => 'email,user_about_me, publish_stream',
									'redirect_uri' => __LOGIN_PAGE_URL.'?postsociallogin=fb'
						);
		$this->loginURL = $this->facebook->getLoginUrl($this->loginParams);	
	}
	
	public function getFBLoginURL()
	{	//echo '<br/>login by fblohinurl:  '.$this->facebook->getLoginUrl($this->loginParams);
		return $this->facebook->getLoginUrl($this->loginParams);
	}
	
	public function verifyFBUserLoggedIn($refID)
	{	$required_profile = $this->getFBUser();
		if($required_profile['loggedIn'] && ($refID == $required_profile['refID']) )
		{	//echo '<br/><br/>Login status = '.$this->getLoginStatus();
			//die('prashanttt');
			return TRUE;
		}
		//otherwise user is not loggedin.. 
		return FALSE;
	}
	
	public function getFBUser()
	{		
		// See if there is a user from a cookie
		$user_id = $this->facebook->getUser();
		//echo '<br/><br/>Found this user from cookie!! userid='.$user_id;
		$user_profile=null;
		//die();
		try
		{	if($user_id) 
			{     // We have a user ID, so probably a logged in user.
			      // If not, we'll get an exception, which we handle below.
			      try 
			      {
			        $user_profile = $this->facebook->api('/me');
	       			$logoutparams = array(
					'next' => __LOGOUT_PAGE_URL.'?fb'
					);
			        $required_profile['loggedIn'] = TRUE;
			        $required_profile['refID'] = $user_profile['id'];
				$required_profile['email'] = $user_profile['email'];		
				$required_profile['name'] = $user_profile['name'];
				$required_profile['type'] = "fb";	
				$required_profile['profileURL'] = $user_profile['link'];
			        $required_profile['logoutURL'] = $this->facebook->getLogoutUrl($logoutparams);
			      // echo "Inside SocialFB: getFBUser() first if user_profile = " . var_dump($user_profile);
			
			      } 
			      catch(FacebookApiException $e) 
			      {
			        // If the user is logged out, you can have a 
			        // user ID even though the access token is invalid.
			        // In this case, we'll get an exception, so we'll
			        // just ask the user to login again here.
				$user_id=0;
				$this->facebook->destroySession();
				
				$require_profile['refID'] = null;
			        $required_profile['fbloginURL'] = $this->getFBLoginURL();
			        $required_profile['loggedIn'] = FALSE;
			       // echo 'Please <a href="' . $login_url . '">login.</a>';
			        error_log($e->getType());
			        error_log($e->getMessage());
				        
			        return $required_profile;
			      } 
			      catch(Exception $e)
				{	$this->facebook->destroySession();
					die('<div style="margin-top:100px;">
						<ul>
							<li>You need to allow our facebook app to use fb.csbees login. Click <a href="'. $this->getFBLoginURL() .'">here</a> to continue.</li>
						</ul>
						
						');
				}
			} 
			else
			{	// No user, print a link for the user to login
				$this->facebook->destroySession();
				
				$require_profile['refID'] = null;
			        $required_profile['loggedIn'] = FALSE;
				$required_profile['fbloginURL'] = $this->getFBLoginURL();
				$user_id=0;
				//echo '<br/><br/><br/>no user found!!';
				//echo 'Please <a href="' . $required_profile['fbloginURL']. '">login.</a>';
				
	
			}
		}
		catch(FacebookException $e) 
		{	error_log($e->getType());
			error_log($e->getMessage());
			$this->facebook->destroySession();
			$require_profile['refID'] = null;
		        $required_profile['loggedIn'] = FALSE;
			$required_profile['fbloginURL'] = $this->getFBLoginURL();
			$user_id=0;
		}   
		
		return $required_profile;
		//echo '<html><body><div>';
		//print_r($user_profile);
		//echo '</div></body></html>';
	}
	
	public function logout()
	{	$fb_key = 'fbs_'.$this->appId;
		setcookie($fb_key, '', time() - 3600, '', '/', '');
		unset($_SESSION['fb_uid']);
		$this->facebook->destroySession();
	}
	
	
	public function publishOnWall($data, $USER_ID="me")
	{
		//$USER_ID = '100002258311547'; // Connected once to your APP and not necessary logged-in at the moment
		/*$data = array(
		    'message'   => 'We go Social!',
		    'link'      => 'http://csbees.neurals.in/',
		    'caption'   => 'Share your notes, Reduce exam preparation time ;-)'
		);
		*/
		try
		{	
			//$post_id = $this->facebook->api("/".$USER_ID."/feed", "post", $data);
			$post_id = $this->facebook->api("/me/feed", "post", $data);
			return $post_id;
		}
		catch(FacebookException $e) 
		{	error_log($e->getType());
			error_log($e->getMessage());
			//var_dump($e);
			//echo '<br/><br/>';
		} 
		catch(Exception $e)
		{	die('<div style="margin-top:100px;">
				<ul>
					<li>You need to allow our facebook app to login. Click <a href="'. $this->getFBLoginURL() .'">here</a> to continue.</li>
				</ul>
				
				');
		}
		//var_dump($e);
		//die($post_id);
	}
	

	
}	


/*		
echo '<br/><br/><br/>pl2<br/><br/><br/>';		

$sf = new SocialFB();
$sf2 =  $sf->getFBUser();
echo '<br/>POst id  = '.$sf->publishOnWall("178689582268824", null);
$sf2 =  SocialFB::getFBLoginURL()

echo '<br/><br/><br/>pl1<br/><br/><br/>';

*/	
		


?>
