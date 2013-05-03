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

//	csbees/auth/login.php
//	=======================
//
//	create a AuthManager object (authMan).. see if an existing non-guest user is logged in, if yes, redirect back to home.
//	else if set $_GET['login'], then according to switch($_GET['login']) option, redirect him to respective login url, for eg
//			$_GET['login'] == 'fb', then send to $authMan->socialuser->fbloginURL
//
//
require_once('includes.php');

//retrieve the user
$authMan = new AuthManager();

//require_once('fb/fb-sdk/facebook.php');


//$fbManager= new Facebook(array( 	'appId'  => '304223549689012',
//				  'secret' => '2eb4f16a086a592819c71a7a4cca86c8'
//				));

if($authMan->isUserLoggedIn() == TRUE)
{	//echo '<br/>You are already logged in as '.$authMan->socialuser->getName().' of type '.$authMan->socialuser->getUserType();
	//echo '<br/>Click here to logout: <a href="'. $authMan->socialuser->getlogoutURL() . '">logout</a> <br/>';
	
	// redirect to home page
	//die('<br/>redirecting to home page..you are logged in!<br/>');
	header('Location: '. __HOME_PAGE_URL .'&alreadyLoggedIn');
}
else
{	// now we do not have any logged in user.. so first we check if user has been returned by fb or twitter after logging into app
	if(isset($_GET['postsociallogin']))
	{	//echo '<br/>login.php line34--';
		//var_dump($_GET);
		
		switch($_GET['postsociallogin'])
		{	// considering fb login case,
			
			case "fb":	//echo '<br>login from '.$_GET['postsociallogin'].'..<br/>now managesociallogin..<br/>';
					$authMan->manageSocialLogin("fb");				
					break;
		}
	}
	else
	{	//user is not logged in, neither he has been returned by fb or twitter..show options to login now
		//$authMan->logoutCurrentUser($authMan->socialuser->getUserType());
		//session_start();
		$HTMLheaderParams = array (
			'isloggedIn'		=>	$authMan->socialuser->isloggedIn(),
			'title'			=>	'Login',
			'includedHeadLinks'	=>	NULL,
			'userfullname'		=>	$authMan->socialuser->getName(),
			'logoutURL'		=>	'/auth/logout.php',
			'loginURL'		=>	$authMan->socialuser->getfbloginURL(),
			'msg'			=>	isset($authMan->socialuser->msg)?$authMan->socialuser->msg:NULL,
		
			);

		echo loadView('headerHTML', $HTMLheaderParams);
		echo '<br/><br/><br/><br/><br/><br/>
			You are not logged in. To connect your facebook account with CSBEES,  ';
		echo '<a href="'. $authMan->socialuser->getfbloginURL() .'">Click Here.</a>';
		echo '<br/><br/><br/>If you are having trouble logging in, <a href="'. __LOGOUT_PAGE_URL .'&troubled">click here</a> and choose to login again.
			<br/><br/>
			<br/>We do not spam your wall or friends or groups or anywhere, nor do we share your data with anyone :-)
			<br/>We only post on your behalf when you upload a file on CSBEES and when you signup with us for the first time.
			<br/><br/>We love to hear from you.
			<br/>Call us on: +91-8826319519 
			<br/>Or mail us at: csbees@neurals.in
			<br/>Team Neurals.
		';
	}
	
}

//echo '<br/>login.php 74: --  ';
//var_dump($authMan->socialuser);
