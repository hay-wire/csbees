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



class DB
{	public $conn;
	public $date;
	public $time;
	public $ip;


	public function __construct()
	{	if($this->conn)
			return TRUE;
		
		$dbhost=__DBHOST;	//'localhost';//atercy25_aterc with password aterc@124.
		$dbuser=__DBUSER;	//'scamolni_csbees';				//has permission only to insert, select, delete, & update
		$dbpass=__DBPASS;	//'csbees@321';
		$database=__DBNAME;	//'scamolni_csbees';				//contains all the tables with suffix "pd_"
		
		$this->date = new DateTime(null, new DateTimeZone('Asia/Calcutta'));
		$this->time = $this->date->format('Y-m-d H:i:s');
	
		$this->conn= new mysqli($dbhost, $dbuser, $dbpass, $database);
		if(!$this->conn)
		{	die('error connecting to database!!');
			return FALSE;
		}
		
		$this->ip = $this->getRealIpAddr();
		
		return TRUE;
		
	}
	
	
	function getRealIpAddr()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
	
	
	public function updateDateTime()
	{	$this->date = new DateTime(null, new DateTimeZone('Asia/Calcutta'));
		$this->time = $this->date->format('Y-m-d H:i:s');
		//return $this->time;
	}
	
	public function __destruct()
	{	if($this->conn)
			$this->conn->close();
	}
	
	public function manageUserLogin($socialdata)
	{	$refID = $socialdata['refID'];
		//echo '<br/>From manageUserLogin (DB): getting user details';
		$dbdata = $this->getUserDetails($refID);
		//if first time user, create a new user
		if(empty($dbdata['refID']))
		{	//echo '<br/>From manageUserLogin (DB): CREATING NEW USER';
			
			//if some how new users registration fails,
			if(!$this->createNewUser($socialdata))
			{	//redirect to error page showing a database error
				$dbdata['error'] = TRUE;
			}
			else
			{	//new user has been registered successfully! get user's $dbprofile. 
				$dbdata = $this->getUserDetails($refID);

			}
			$dbdata['newUser']=TRUE;
		}
		//echo '<br/>From manageUserLogin (DB): updating log table';
		$this->updateLog($refID, $SERVER['REMOTE_ADDR']);
		//var_dump($dbdata);
		//echo '<br/><br/>end';
		//die();
		return $dbdata;
			
	}
	
	public function getUserDetails($refID)
	{	$query = 'SELECT * FROM users WHERE refID="'.$refID.'" and blocked!=1';
		$result = $this->conn->query($query);
		if(!$result)
			return FALSE;
		else
		{	$data = $result->fetch_assoc();
			$data['userTagsList'] = $this->getUserTags($refID);
			//print_r($data);
			return $data;
		}
	}
	
	
	public function getUserSubjects($refID)
	{	$query = 'SELECT sid, subject FROM usersSubjectsView WHERE userID="'.$refID.'" ';
		$result = $this->conn->query($query);
		if(!$result)
			return FALSE;
		else
		{	$i=0;
			$data = array();
			while(true)
			{	$row = $result->fetch_assoc();
				if($row)
					$data[$i] = $row;
				else
					break;
				$i++;
				
			}
			return $data;
		}
	}
		
	public function setUserSubjects($refID, $subsArray)
	{	$query = 'DELETE FROM users_subjects WHERE userID="'. $refID .'"';
		$result = $this->conn->query($query);
		//printf("Error - Error %s.\n", $this->conn->error);
		//echo '<br/>result='.var_dump($result);
		
		if($subsArray[0]=="")
				return TRUE;
			
			$query = 'INSERT INTO users_subjects (userID, subjectid) VALUES ';
			for($i=0; $i<sizeof($subsArray); $i++)
			{	$query .= '("'. $refID .'", "'. $subsArray[$i] .'")';
				if($i!=sizeof($subsArray)-1)
				{	$query .=', ';
				}
			}
			//echo $query;
			$result = $this->conn->query($query);
			
			//var_dump($result);
			if(!$result)
				return FALSE;
			else
				return TRUE;
	
		
	
	}
	
	public function createNewUser($details)
	{	if(empty($details['course']))
			$details['course']='1';
		
		if(empty($details['college']))
			$details['college']='1';
		
		if(empty($details['branch']))
			$details['branch']='1';
		
		if(empty($details['semester']))
			$details['semester']='5';
			
		$query = 'INSERT INTO users (name, email, profileURL, course, college, branch, semester, refID) values ("'.$details['name'].'", "'.$details['email'].'", "'.$details['profileURL'].'", "'.$details['course'].'", "'.$details['college'].'", "'.$details['branch'].'", "'.$details['semester'].'", "'.$details['refID'].'")';
		
		$result = @$this->conn->query($query);
		//echo '<br/><br/>user creatiion query:'.$query.'<br/><br/>error='.$this->conn->errno;
		
		if(!$result)
			return FALSE;
		else
			return TRUE;
	}
	
	public function updateUser($refID, $details)
	{
		$query = <<< _QUERY
UPDATE users SET name="{$details['name']}", course="{$details['course']}" , branch="{$details['branch']}", semester={$details['semester']}, college="{$details['college']}" WHERE refID="{$refID}";
_QUERY;
		
		//echo $query;
		$result = $this->conn->query($query);
		return $result;

	}
	
	public function checkUsernameExists($name, $refID=0)
	{	$query = 'SELECT name FROM users WHERE name="'.$name.'" AND refID != "'. $refID .'"';
		$result = $this->conn->query($query);
		if($result)
		{	$data = @$result->fetch_assoc();
			if($data['name'] == $name)
				return TRUE;
		}
		
		return FALSE;
	}
	
	public function updateLog($refID)
	{	$userAgentt = $_SERVER['HTTP_USER_AGENT'];
		$this->updateDateTime();
		//$ip = $_SERVER['REMOTE_ADDR'];
		$query = 'INSERT INTO log (time, ip, userAgent, refID) VALUES ("'.$this->time.'", "'.$this->ip.'","'.$userAgentt.'", "'. $refID .'")';
		$result = @$this->conn->query($query);
		if(!$result)
			return FALSE;
		else
			return TRUE;
	}
	
	public function getTags($orderBy, $limit=0, $offset=0)
	{	switch($orderBy)
		{	case 'newest':	$orderBy = 'addedOn DESC';
					break;
			default:	$orderBy = 1;
			
		}
		
		$query = "SELECT acronym, name, id, type FROM tagsAvailable ORDER BY $orderBy LIMIT $offset, $limit";
		$result = $this->conn->query($query);
		if($result)
		{	$i=0;
			$tagsData = array();
			while(TRUE)
			{	$data = @$result->fetch_assoc();
				if(!$data)
					break;
				$tagsData[$i] = $data;
				$i++;
			
			}
			return $tagsData;
		}
		
		return FALSE;
	}
	
	
	public function getUserTags($refID)
	{	
		$query = "SELECT * FROM usersTagsView WHERE userID='$refID' ORDER BY name";
		$result = $this->conn->query($query);
		if($result)
		{	$i=0;
			$tagsData = array();
			while(TRUE)
			{	$data = @$result->fetch_assoc();
				if(!$data)
					break;
				$tagsData[$i] = $data;
				$i++;
			
			}
			return $tagsData;
		}
		
		return FALSE;
	}
	
	public function setUserTags($refID, $tagsArray)
	{	
		$this->conn->autocommit(false);
		$query="DELETE FROM usersTags WHERE userID='$refID'";
		$a = $this->conn->query($query);
		$b=1;
		if(!empty($tagsArray[0]))		//if firstElement is empty, then either user is trying to empty tags list or its a malformed request
		{	$query = "INSERT INTO usersTags (userID, tagID) VALUES ";
			for($i=0; $i<sizeof($tagsArray); $i++)
			{	$query .= '("'. $refID .'", "'. $tagsArray[$i] .'")';
				if($i!=sizeof($tagsArray)-1)
				{	$query .=', ';
				}
			}
			//echo $query."<br/>";
			$b = $this->conn->query($query);
		}
		if($a && $b)
		{	$this->conn->commit();
			$this->conn->autocommit(true);
			return TRUE;
		}
		else
		{	$this->conn->rollback();
			$this->conn->autocommit(true);
			return FALSE;
		}
	}
	

}