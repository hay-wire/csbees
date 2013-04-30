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

