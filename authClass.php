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
