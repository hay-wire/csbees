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

class AuthClass {

	
	private $userName;
	private $isLoggedIn;
	private $table;
	private $userIdField;
	private $pwdField;
	private $authCookieField;
	
	public function cleanCookie($cookie)
	{	return cleanString($cookie);
	}
	
	public function __construct($conn, $tableName, $userIdField, $sessionCookieField) 
	{		if(!$conn || !$tableName || !$userIdField || !$sessionCookieField)
				return FALSE;
	}
	
	
	public function signup($conn, $table, $username, $email, $pwd)
	{		$res = $conn->query('INSERT INTO '.$table. ' ')
	}
	
	public function isLoggedIn()
	{	if(isset($_COOKIE['authToken']) && isset($_COOKIE['authHandle']))
		{	$auth = new array(	'authHandle'	=>	$_COOKIE['authHandle'],
								'authToken'		=>	$_COOKIE['authToken'];
							);
			return $auth;
		}

		return FALSE;
	}
	
	
	public function checkDatabase($conn)
	{	$res = $conn->query('SELECT * FROM authClass where handle="'.$handle.'" and ')
	}	




}

?>
