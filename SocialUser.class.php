<?php


//	csbees/auth/SocialUser.class.php
//	================================

require_once('includes.php');

class SocialUser
{	private $refID;
	private $name;
	private $type;			//fb, twitter, openAuth, native, etc
	public  $dbprofile;		//true if the user has already registered on our website previously. false if the user has first time logged in
	private $branch;
	private $course;
	private $sem;
	private $coll;
	private $ip;
	private $lastActivity;
	private $userAccessLevel;
	private $loggedIn;
	private $logoutURL;
	private $fbloginURL;
	private $reputation;
	private $userTagsList;
	private $profileEdited;
	private $msgs;

	public function SocialUser($details) //$name='Guest', $branch=1, $course=1, $sem=5, $coll=1, $type="NATIVE", $loggedIN=0, $db)
	{	$this->refID = $details['refID'];
		$this->name = $details['name'];
		$this->type = $details['type'];			
		$this->branch = $details['branch'];
		$this->course = $details['course'];
		$this->sem = $details['semester'];
		$this->coll = $details['college'];
		$this->ip = $_SERVER['REMOTE_ADDR'];
		//$this->lastActivity;
		$this->userAccessLevel = $details['userAccessLevel'];
		$this->setloggedIn($details['loggedIn']);
		$this->dbprofile = $details['dbprofile'];
		$this->logoutURL = $details['logoutURL'];
		$this->fbloginURL = $details['fbloginURL'];
		$this->reputation = $details['reputation'];
		$this->userTagsList = $details['userTagsList'];
		$this->profileEdited = FALSE;
		$this->msg = empty($details['msg']) ? null: $details['msg'];
		//echo '<br/><br/>SocialUser.php in constructor: $details::<br/>';
		//var_dump($details);
	}
	
	public static function generateGuestUser($params = null)
	{	$details = array (
				'refID'		=>	__GUEST_REFID,
				'name'		=>	__GUEST_NAME,
				'type'		=>	__GUEST_TYPE,
				'college'	=>	'1',
				'semester'	=>	'5',
				'course'	=>	'1',
				'branch'	=>	'1',
				'useraccessLevel'=>	__STUDENT,
				'loggedIn'	=>	FALSE,
				'logoutURL'	=>	null,
				'userType'	=>	'',
				'fbloginURL'	=>	$params['fbloginURL'],
				'reputation'	=>	0,
				'userTagsList' =>	FALSE
				);
		$su = new SocialUser($details);
		return $su;
	}
	
	public function setloggedIn($value=FALSE) 
	{	if($value == TRUE)
			$this->loggedIn = TRUE;
		else
			$this->loggedIn = FALSE;
	}
	public function isloggedIn()
	{	return $this->loggedIn;
	}
	
	public function setRepo($val) 
	{	$this->reputation = $this->validate($val);
	}
	public function getRepo()
	{	return $this->reputation;
	}
	
	public function setName($name) 
	{	$this->name = $this->validate($name);
	}
	public function getName()
	{	return $this->name;
	}
	
	public function setBranch($branch) 
	{	$this->branch = $this->validate($branch);
	}
	public function getBranch()
	{	return $this->branch;
	}
	
	public function setSem($sem) 
	{	$this->sem = $this->validate($sem);
	}
	public function getSem()
	{	return $this->sem;
	}

	public function setCourse($c) 
	{	$this->course = $this->validate($c);
	}
	public function getCourse()
	{	return $this->course;
	}
	
	public function setColl($coll) 
	{	$this->coll = $this->validate($coll);
	}
	public function getColl()
	{	return $this->coll;
	}
	
	public function setIP($ip) 
	{	$this->ip = $ip;
	}
	public function getIP()
	{	return $this->ip;
	}

	public function setUserType($type) 
	{	$this->type = $type;
	}
	public function getUserType()
	{	return $this->type;
	}

	public function setAct($lastActivity) 
	{	$this->lastActivity = $lastActivity;
	}
	public function getAct()
	{	return $this->lastActivity;
	}
	
	public function setlogoutURL($url) 
	{	$this->logoutURL = $url;
	}
	public function getlogoutURL()
	{	return $this->logoutURL;
	}

	public function setfbloginURL($url) 
	{	$this->fbloginURL = $url;
	}
	public function getfbloginURL()
	{	return $this->fbloginURL;
	}

	public function setUserAccessLevel($level) 
	{	$this->userAccessLevel = $level;
	}
	public function getUserAccessLevel()
	{	return $this->userAccessLevel;
	}

	public function setRefID($id) 
	{	$this->ip = $id;
	}
	public function getRefID()
	{	return $this->refID;
	}

	public function getUserTags()
	{	return $this->userTagsList;
	}
	
	public function forceProfileRefresh($status)
	{	$this->profileEdited = ($status) ? TRUE : FALSE;
	}
	
	public function profileNeedsRefresh()
	{	return $this->profileEdited;
	}
	
	public function getMessages()
	{	return $this->msg;
	}

	public function setMessages($msgs)
	{	$this->msg = $msgs;
	}

}


/*


$params = array (
	'fbloginURL' => 'sjdkhd'
	);
$socialuser = SocialUser::generateGuestUser($params);

var_dump($socialuser);


*/