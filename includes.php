<?php
/**************************************************************************************/
/**************************************************************************************/
/**********************	Configuration file ********************************************/
/**************************************************************************************/
/**************************************************************************************/

/*	modes used:
		dev
		maintenance
		production
*/
define('__MODE', 'production');

//	hostname where the file is hosted. e.g., www.csbees.neurals.in or mydomain.com (without the http part!)
//	In case port number is something other than 80, use it as:	www.csbees.neurals.in:8080
define('__HOST', 'localhost');

//	relative path of the folder where the files are stored. leave it blank if the files are in document root itself
define('__APP_ROOT', '/csbees');

//	Turn off all errors to be displayed by php
error_reporting(0);


/**************************************************************************************/
/**************************************************************************************/
/**********************	MySQL database configuration **********************************/
/**************************************************************************************/
/**************************************************************************************/

//	hostname for the database. generally it is localhost or something
define('__DBHOST', 'localhost');

//	database name
define('__DBNAME', 'csbees');

//	database user name
define('__DBUSER', 'haywire');

//	password for the above user
define('__DBPASS', 'qw');


/**************************************************************************************/
/**************************************************************************************/
/**********************	Facebook connectivity configuration ***************************/
/**************************************************************************************/
/**************************************************************************************/

//	facebook app id
define('__FB_APP_ID', '47y8ruduy86478weuih346876');

//	facebook app secret
define('__FB_APP_SECRET', '47y8ruduy86478weuih346876');


/**************************************************************************************/
/**************************************************************************************/
/**********************	Reputation Points for users  **********************************/
/**************************************************************************************/
/**************************************************************************************/
define('__REPO_CHANGE_VOTE_UP', 2);
define('__REPO_CHANGE_VOTE_DOWN', -5);
define('__REPO_CHANGE_FLAGGED_UPLOAD', 0);
define('__REPO_CHANGE_UPLOAD_FILE', 10);
define('__REPO_CHANGE_UPLOAD_INAPPROPRIATE', -10);


/**************************************************************************************/
/**************************************************************************************/
/**********************	Miscellaneous Configurations **********************************/
/**************************************************************************************/
/**************************************************************************************/

//in case if you are using SSL, change the line below to have "https" instead of http
define('__BASE_URL', 'http://'.__HOST.__APP_ROOT);

//	default monitoring email. System will send you mail to this id in case of critical failures
define('__CSBEES_MONITOR_EMAIL', 'csbees@neurals.in');

//	this image will be posted to facebook when a user signs up or uploads a new note
define('__FB_POSTS_CSBEES_ICON', __BASE_URL.'/images/fb128.jpg');

//	folders which hold the files uploaded by the users
define('__UPLOADS_FOLDER_PATH_WITH_END_SLASH','uploads/');
define('__UPLOADS_BACKUP_FOLDER_RELATIVE_PATH_WITH_SLASH','uploads2/');

//	Maximum items to be displayed on each page
define('__ITEMS_PER_PAGE', 25);






/**************************************************************************************/
/**************************************************************************************/
/*********	Don't change anything below unless you know what you are doing*************/
/**************************************************************************************/
/**************************************************************************************/


//define('__FILESYSTEM_ABSOLUTE_PATH', '/home/neuralzk/public_html/neurals-webhost/csbees.neurals.in/'. __APP_ROOT);


require_once('AuthManager.class.php');
require_once('DB.class.php');
require_once('SocialUser.class.php');
require_once('CSBeesManager.class.php');
require_once('fb/SocialFB.class.php');
require_once('views/loadView.php');
require_once('functions.php');

define('__FB', 'fb');
define('__STUDENT', 'student');
define('__GUEST_REFID', 0);
define('__GUEST_NAME', 'Guest');
define('__GUEST_TYPE', __STUDENT);


//	Determine the mode of website..whether its online or offline
switch(__MODE)
{	case "dev": 		//define(__BASE_URL, 'http://'.__HOST.__APP_ROOT.'/dev');
				error_reporting(E_ALL);
				break;
}

//	Make sure that the page is accessed only using www.csbees.neurals.in or csbees.neurals.in (or whatever is set as host and base url
//	For security purposes (it will help in avoid cross site referencing attacks)
if( ($_SERVER["HTTP_HOST"]!=__HOST) && ($_SERVER["HTTP_HOST"]!= 'www'.__HOST) )
{	header('Location: '.__BASE_URL);
	echo '<br/>Redirecting you to <a href="'. __BASE_URL .'">NEURALS::CSBEES</a><br/>';
	die();
}


define('__WEBSITE_URL', __BASE_URL.'/');
define('__PAGE_VIEW_KEYWORD', 'P');
define('__HOME_PAGE_KEYWORD', 'Home');
define('__UPLOAD_PAGE_KEYWORD','Upload');
define('__MY_UPLOADS_PAGE_KEYWORD','MyUploads');
define('__FILEDETAILS_PAGE_KEYWORD','Details');
define('__PROFILE_PAGE_KEYWORD','Profile');
define('__LOGIN_PAGE_KEYWORD','Login');
define('__SEARCH_PAGE_KEYWORD','Search');
define('__WIKI_PAGE_KEYWORD','Wiki');
define('__ERROR_PAGE_KEYWORD', 'Error');



define('__MAINTENANCE_PAGE_URL', __BASE_URL.'/maintenance.php');
define('__INDEX_PAGE_URL', __BASE_URL.'/index.php');
define('__LOGOUT_PAGE_URL', __BASE_URL.'/logout.php');
define('__HOME_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__HOME_PAGE_KEYWORD);
define('__UPLOAD_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__UPLOAD_PAGE_KEYWORD);
define('__MY_UPLOADS_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__MY_UPLOADS_PAGE_KEYWORD);

define('__PROFILE_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__PROFILE_PAGE_KEYWORD);
define('__FILEDETAILS_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__FILEDETAILS_PAGE_KEYWORD.'&fileid=');
define('__LOGIN_PAGE_URL', __BASE_URL.'/login.php');
define('__SEARCH_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__SEARCH_PAGE_KEYWORD);
define('__WIKI_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__WIKI_PAGE_KEYWORD);
define('__ERROR_PAGE_URL',__INDEX_PAGE_URL.'?'.__PAGE_VIEW_KEYWORD.'='.__ERROR_PAGE_KEYWORD);




if( __MODE=="maintenance" && (!isset($_GET['down'])) )
{	header('Location: '.__MAINTENANCE_PAGE_URL.'?down');
	echo '<br/>Site under <a href="'. __MAINTENANCE_PAGE_URL .'?down">maintenance</a><br/>';
	die();
}

//	initialising session
session_start();
