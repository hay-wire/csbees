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



// csbees/auth/logout.php
//=========================

require_once('includes.php');

//retrieve the user
$authMan = new AuthManager();

$authMan->logoutCurrentUser($authMan->socialuser->getUserType());
//if(isset($_GET['troubled']))
//	header('Location: '. __LOGIN_PAGE_URL .'?troubled');
//else

header('Location: '. __INDEX_PAGE_URL .'?loggedOut');

//echo '<a href="http://csbees.neurals.in/auth/login.php?loggedout"> login again</a>';

