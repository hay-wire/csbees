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

class CSBeesManager
{	public $conn;
	public $date;
	public $time;
	public $ip;

	public function __construct()
	{	if($this->conn)
			return TRUE;
			
		$dbhost=__DBHOST;	
		$dbuser=__DBUSER;	
		$dbpass=__DBPASS;	
		$database=__DBNAME;	
		
		$this->date = new DateTime(null, new DateTimeZone('Asia/Calcutta'));
		$this->time = $this->date->format('Y-m-d H:i:s');
		$this->ip = $_SERVER['REMOTE_ADDR'];
	
		$this->conn= new mysqli($dbhost, $dbuser, $dbpass, $database);
		if(!$this->conn)
		{	die('error connecting to database!!');
			return FALSE;
		}
		return TRUE;
	}
	public function getCurrentTime()
	{	$this->time = $this->date->format('Y-m-d H:i:s');
		return $this->time;
	}
	
	public function __destruct()
	{	if($this->conn)
			$this->conn->close();
	}
	
	public function registerTags($uploadId, $tagsArray)
	{	$tagsInsertString = null;
		if(empty($uploadId) || empty($tagsArray))
			return FALSE;
		
		for($i=0; $i<sizeof($tagsArray); $i++)
		{	$tagsInsertString.= '("'. $uploadId .'", "'. $tagsArray[$i] .'")';
			if($i<sizeof($tagsArray)-1)
				$tagsInsertString.= ', ';
		}
		
		$query = 'INSERT INTO uploadsTags (uploadId, tagId) values '.$tagsInsertString;
		$result = $this->conn->query($query);
		//echo '<br/>'.$query.'<br/>';
		if($result)
			return TRUE;
		else
			return FALSE;
	
	}
	
	
	public function uploadNewNote($uploaderRefID=FALSE)
	{	$returnResult=null;
		$topic = cleanString($_POST['topic']);
		$descr = cleanString($_POST['desc']);
		$tags = cleanString($_POST['tags']);
		
		//convert the comma seperated tagsId(s) into array to save in the database
		$tags = explode(",", $tags);

		
		//declare global vars for this fxn
		$msg; $error; $extension;
		//if user is registered, enter his refID, else, enter his name
		$uploaderName;

		if($uploaderRefID)
		{	$uploaderName = $uploaderRefID;
		}
		else
		{	$uploaderName = null;	//cleanString($_POST['name']);
		}

		$errorCode = $_FILES['upload']['error'];
		
		//if any of the fields is empty, ask to refill again
		if( empty($tags))
		{	$error .= "<li>Please choose atleast one tag!</li>";
			$errorCode = (int) 99991;
		}
		if( empty($topic))
		{	$error .= "<li>Please specify a topic!</li>";
			$errorCode = (int) 99991;
		}

		
		if($errorCode==0)
		{	// define the sent file details into variables 
			$fileName = $_FILES['upload']['name']; 
			$tmp_name = $_FILES['upload']['tmp_name']; 
			$size = $_FILES['upload']['size'];
			$extension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			
			//echo $type;
			// if the extension is anything other than what we specify below, kill it
			if(		$extension=='png' ||
					$extension=='jpg' ||
					$extension=='jpeg' ||
					$extension=='gif' ||
					$extension=='bmp' ||
					$extension=='txt' ||
					$extension=='rtf' ||				
					$extension=='doc' ||
					$extension=='docx' ||
					$extension=='ppt' ||
					$extension=='pptx' ||
					$extension=='xls' ||
					$extension=='zip' ||
					$extension=='rar' ||
					$extension=='7z' ||
					$extension=='pdf' ||
					$extension=='pps'
					
				)
			{
				// if the file size is larger than 30 MB, kill it 
				$size = (float) $size/1024; //converting into KB
				
				if(($size<=30*1024) && $size>0)
				{	
					$path = __UPLOADS_FOLDER_PATH_WITH_END_SLASH; 
					//$fileID = cleanString(basename( $_FILES['upload']['name']));
					// var_dump($size);
					$fileID = '_'.rand(100, 9999).rand(100, 9999);
					
					// replace everything in topic by "_" except alphanumerics and "." and save its first 30 characters in file name
					$fileNewName = preg_replace('#[^A-Za-z0-9-.]#', '_', $topic);
					$fileNewName = substr($fileNewName, 0, 30);
					
					$path .= $fileNewName.'_'.$fileID.'.'.$extension;
					
					//move the uploaded file to uploads folder
					if(move_uploaded_file($_FILES['upload']['tmp_name'], $path))
					{	
						$query1 = 'INSERT INTO uploads (time, topic, descr, fileID, fileSize, path, uploader, ip, extension) VALUES ("'.$this->getCurrentTime().'", "'.$topic.'", "'. $descr .'", "'.$fileID.'", "'.$size.'", "'.$path.'", "'.$uploaderName.'", "'.$this->ip.'", "'. $extension .'")';
						//echo "<br/>".$query;
						$result = @$this->conn->query($query1);
						if(!$result)
						{	$error .= '<li>Database Error 121!! Please try again or call on: +91-8826319519</li>';
						}
						else
						{	$query2 = 'SELECT * FROM uploads where path="'.$path.'"';
							$result = @$this->conn->query($query2);
							if($result)
							{	$data = $result->fetch_assoc();
								//create a method registerTags to register a new set of tags.. use mysql transactions to accomplish this
								if(!$this->registerTags($data['id'], $tags))
									$error .= '<li>There appears to be some problem with your tags! Please add them for this file from your uploads page.</li>';
								
								$msg .= "<li>Thanks a ton! You just saved the world with your invaluable notes on: ".$topic."</li>";
								$msg .= '<li><a href="'.__BASE_URL.'/share.php?id='.$data[id].'">Tell the world not to worry! You saved them! :-)</a> </li>';
								$returnResult['shareUpload'] = $data;
								
							}
							
						}	
									
					}
					else
					{	$error .= "<li>There was an error uploading the file!</li>";
					}
				}
				else
				{	if($size > 30*1024)
						$error.= "<li>".$name . " is over 30MB! Please keep it within 30 MB.</li>";
					else if($size < 0)
						$error.= "<li>".$name . " appears to be empty or corrupt! Please check the file or retry.s</li>";
				}
 			}
 			else
 			{	$error .= '<li>File is not in a acceptable format('.$type.'). We accept only images, documents and zipped files.</li>
 						<li>Alternatively, you may compress and upload the file in .zip/.rar/.7z format.</li>	
 						';
 			}
		}
		else
		{	$error .= '<li>No file recieved!.</li>';
			//echo 'error='.$_FILES['upload']['error'].'<br/>';
			//var_dump($_FILES);
			
		}
		
		$returnResult['error'] = $error;
		$returnResult['msg'] = $msg;
		
		return $returnResult;
	}
	
	
	
	
	
	public function uploadNewAssignment($uploaderRefID=FALSE)
	{	$returnResult=null;
		$subject = cleanString($_POST['subject']);
		$college = cleanString($_POST['college']);
		$course = cleanString($_POST['course']);
		$department = cleanString($_POST['department']);
		$semester = cleanString($_POST['semester']);
		
		$msg; $error;
		
		$topic = cleanString($_POST['topic']);
		$extension;
		//if user is registered, enter his refID, else, enter his name
		$uploaderName;
		if($uploaderRefID)
		{	$uploaderName = $uploaderRefID;
		}
		else
		{	$uploaderName = null;	//cleanString($_POST['name']);
		}

		$errorCode = $_FILES['upload']['error'];
		
		//if any of the fields is empty, ask to refill again
		if( empty($subject) || empty($course) || empty($college) || empty($department) || empty($semester) || empty($topic) )
		{	$error .= "<li>Please Fill all the fields!</li>";
			$errorCode = (int) 99991;
		}

		if(($errorCode==0)) 
		{	// define the sent file details into variables 
			$name = $_FILES['upload']['name']; 
			$tmp_name = $_FILES['upload']['tmp_name']; 
			$size = $_FILES['upload']['size'];
			$extension = mb_strtolower(pathinfo($name, PATHINFO_EXTENSION));
			
			//echo $type;
			// if the extension is anything other than what we specify below, kill it
			if(		$extension=='png' ||
					$extension=='jpg' ||
					$extension=='jpeg' ||
					$extension=='gif' ||
					$extension=='bmp' ||
					$extension=='txt' ||
					$extension=='rtf' ||				
					$extension=='doc' ||
					$extension=='docx' ||
					$extension=='ppt' ||
					$extension=='pptx' ||
					$extension=='xls' ||
					$extension=='zip' ||
					$extension=='rar' ||
					$extension=='7z' ||
					$extension=='pdf' ||
					$extension=='pps'
					
				)
			{ 
				// if the file size is larger than 30 MB, kill it 
				$size = (float) $size/1024; //converting into KB
				
				if(($size<=30*1024) && $size>0)
				{	
					$path = __UPLOADS_FOLDER_PATH_WITH_END_SLASH; 		//	"../uploads/";
					//$fileID = cleanString(basename( $_FILES['upload']['name']));
					// var_dump($size);
					$fileID = '_'.rand(100, 9999).rand(100, 9999);
					
					// replace everything in topic by "_" except alphanumerics and "." and save its first 30 characters in file name
					$fileNewName = preg_replace('#[^A-Za-z0-9-.]#', '_', $topic);
					$fileNewName = substr($fileNewName, 0, 30);
					
					$path .= $fileNewName.'_'.$fileID.'.'.$extension;
					
					//move the uploaded file to uploads folder
					if(move_uploaded_file($_FILES['upload']['tmp_name'], $path))
					{	
						$query = 'INSERT INTO uploads (time, subjectid, topic, fileID, fileSize, path, uploader, ip, collegeid, departmentid, semesterid, courseid, extension) VALUES ("'.$this->getCurrentTime.'", "'.$subject.'", "'.$topic.'", "'.$fileID.'", "'.$size.'", "'.$path.'", "'.$uploaderName.'", "'.$this->ip.'", "'.$college.'", "'.$department.'", "'.$semester.'", "'.$course.'", "'. $extension .'")';
						
						//echo "<br/>".$query;
						
						$result = @$this->conn->query($query);
				
						if(!$result)
							$error .= '<li>Database Error 121!! Please try again or call on: +91-8826319519</li>';
						else
						{	$query = 'SELECT * FROM uploads where path="'.$path.'"';
							$result = @$this->conn->query($query);
							if($result)
							{	$data = $result->fetch_assoc();
								$msg .= "<li>Your file ".  basename( $_FILES['upload']['name'])." has been uploaded.</li>";
								$msg .= "<li>Your File ID is $fileID</li>";
								$returnResult['shareUpload'] = $data;
								$subject=null;
								$topic=null;
							}
							
						}	
									
					}
					else
					{	$error .= "<li>There was an error uploading the file!</li>";
					}
				}
				else
				{	$error.= "<li>".$name . " is over 30MB or empty! Please keep it within 30 MBs.</li>";
				}
 			}
 			else
 			{	$error .= '<li>File is not in a acceptable format('.$type.'). We accept only images, documents and zipped files.</li>
 						<li>Alternatively, you may upload the file in .zip format.</li>	
 						';
 			}
		}
		else
		{	$error .= '<li>No file recieved!.</li>';
			//echo 'error='.$_FILES['upload']['error'].'<br/>';
			//var_dump($_FILES);
			
		}
		
		$returnResult['error'] = $error;
		$returnResult['msg'] = $msg;
		
		return $returnResult;
	}
	
	
	public function getAllUploadBoxDetails($userDetails)
	{	$params = array();
		$params['collList'] = $this->getAllColleges();
		$params['semList'] = $this->getAllSemesters();		
		$params['courseList'] = $this->getALLCourses();		
		$params['deptList'] = $this->getAllDepartments();
		$params['subjectList'] = $this->getAllSubjects();		
		if(isset($_POST['uploadAttempted']))
		{	$params['selectedSubject'] = cleanString($_POST['subject']);
			$params['selectedCollege'] = cleanString($_POST['college']);
			$params['selectedCourse'] = cleanString($_POST['course']);
			$params['selectedDept'] = cleanString($_POST['department']);
			$params['selectedSemester'] = cleanString($_POST['semester']);
			$params['selectedTopic'] = cleanString($_POST['topic']);
		}

		/*
		if(empty($params['selectedSubject']))
		{	$params['selectedSubject'] = $userDetails['subject'];
		}
		*/
		
		if(empty($params['selectedCollege']))
		{	$params['selectedCollege'] = $userDetails['college'];
		}
		if(empty($params['selectedCourse']))
		{	$params['selectedCourse'] = $userDetails['course'];
		}
		if(empty($params['selectedDept']))
		{	$params['selectedDept'] = $userDetails['dept'];
		}
		if(empty($params['selectedSemester']))
		{	$params['selectedSemester'] = $userDetails['semester'];
		}
			
			
		return $params;
	}
	
	public function getUploaderID($fileID)
	{	$result = $this->conn->query("SELECT uploader FROM uploads WHERE id=$fileID");
		if($result)
		{	$data = $result->fetch_assoc();
			if($data)
			{	return $data['uploader'];
			}		
		}
		return FALSE;		
	
	}

	
	public function getAllColleges()
	{	$query = 'SELECT * FROM colleges order by name';
		$result = @$this->conn->query($query);
		//var_dump($result);
		if($result)
		{	$data = $result->fetch_assoc();
			
			while($data)
			{	$collList['collid'][]=$data['collid'];
				$collList['name'][]=$data['name'];
				//echo '<option value="'.$data['collid'].'" '.(($data['collid']==$college)?'selected="selected"':null).'>'.$data['name'].'</option>';	
				$data = $result->fetch_assoc();	
			}
			return $collList;
		}
		return FALSE;
	}
	
	public function getAllSemesters()
	{	$query = 'SELECT * FROM semesters order by semid';
		$result = @$this->conn->query($query);
		
		if($result)
		{	$data = $result->fetch_assoc();
				
			while($data)
			{	$semList['semid'][] = $data['semid'];
				$semList['semester'][] = $data['semester'];
				//echo '<option value="'.$data['semid'].'" '.(($data['semid']==$semester)?'selected="selected"':null).'>'.$data['semester'].'</option>';	
				$data = $result->fetch_assoc();	
			}
			return $semList;
		}
		return FALSE;
	}
	
	public function getAllCourses()
	{	$query = 'SELECT * FROM courses order by course';
		$result = @$this->conn->query($query);
		
		if($result)
		{	$data = $result->fetch_assoc();
			
			while($data)
			{	$courseList['cid'][] = $data['cid'];
				$courseList['course'][] = $data['course'];
				//echo '<option value="'.$data['cid'].'" '.(($data['cid']==$course)?'selected="selected"':null).'>'.$data['course'].'</option>';	
				$data = $result->fetch_assoc();	
			}
			return $courseList;
		}
		return FALSE;
	}
	
	public function getAllDepartments()
	{	$query = 'SELECT * FROM departments order by department';
		$result = @$this->conn->query($query);
		
		if($result)
		{	$data = $result->fetch_assoc();
			
			while($data)
			{	$deptList['deptid'][] = $data['deptid'];
				$deptList['department'][] = $data['department'];
				//echo '<option value="'.$data['deptid'].'" '.(($data['deptid']==$department)?'selected="selected"':null).'>'.$data['department'].'</option>';	
				$data = $result->fetch_assoc();	
			}
			return $deptList;
		}
		return FALSE;
	}
	
	public function getAllSubjects($subjectName=false)
	{	//$subjectName = mysql_real_escape_string($subjectName);
		if($subjectName)
			$query = 'SELECT sid, subject FROM subjects where subject like "%'. $subjectName .'%" order by subject';
		else
			$query = 'SELECT sid, subject FROM subjects order by subject';
		
		//echo '<br/>Query='.$query;
		$result = @$this->conn->query($query);
		//var_dump($result);
		if($result)
		{	$data = $result->fetch_assoc();
			
			//var_dump($data);
			while($data)
			{	$subjectList['sid'][]=$data['sid'];
				$subjectList['subject'][] = $data['subject'];
				//echo '<option value="'.$data['sid'].'" '.(($data['sid']==$subject)?'selected="selected"':null).'>'.$data['subject'].'</option>';	
				$data = $result->fetch_assoc();	
			}
			return $subjectList;
		}
		return FALSE;
	}
	
	
	public function getAllTags($tagString=false)
	{	//$tagString = mysql_real_escape_string($tagString);
	
		if($tagString)
			$query = 'SELECT id, name, type, acronym FROM tagsAvailable where name like "%'. $tagString .'%" OR acronym like "%'. $tagString .'%" AND valid=1 order by name  LIMIT 50';
		else
			$query = 'SELECT id, name, type, acronym FROM tagsAvailable WHERE valid=1 order by name LIMIT 50';
		
		//echo '<br/>Query='.$query;
		$result = @$this->conn->query($query);
		//var_dump($result);
		if($result)
		{	$data = $result->fetch_assoc();
			
			//var_dump($data);
			$i=0;
			while($data)
			{	$tagsList[$i]['tagId']=$data['id'];
				$tagsList[$i]['tagName'] = $data['name'];
				$tagsList[$i]['tagType'] = $data['type'];
				
				//echo '<option value="'.$data['sid'].'" '.(($data['sid']==$subject)?'selected="selected"':null).'>'.$data['subject'].'</option>';	
				$data = $result->fetch_assoc();	
				$i++;
			}
			return $tagsList;
		}
		return FALSE;
	}
	
	//public function removeInvalidData()
	//{	// write queries to remove voteForUploads rows where fileid or userid is invalid
		// write queris to remove invalid tags from uploadsTags table
	
	//}
	
	
	public function getVotesCount($fileId)
	{
		$query = "SELECT votes FROM uploads WHERE id=$fileId";
		$result = $this->conn->query($query);
		if($result)
		{	$data = $result->fetch_assoc();
			$votes = $data['votes'];
			return $votes;
		}
	}
	
	public function voteForUpload($fileId, $voteNature, $refId)
	{	
		$query = 'SELECT uploaderRefID from validUploadsView WHERE id="'.$fileId.'"';
		$result = $this->conn->query($query);
		if($result)
		{	$data = $result->fetch_assoc();
			if($data['uploaderRefID'] == $refId)
			{		return array(	'votes'	=> 'X',
												'msg'	=> "Good people do not vote for themselves!",
												'error'	=> TRUE,
												'credits'=>	0
											);
			}
		}
		$query = "SELECT * FROM votes WHERE userID=$refId AND uploadID=$fileId";
		$voteNature = (int) $voteNature;
		
		$result = $this->conn->query($query);
		//echo $query;
		if($result)
		{	$returnFlag = false;
			$data = $result->fetch_assoc();
			while(!empty($data))
			{	if($data['voteNature']==$voteNature)	// this guy has already voted for this file, undo his vote
				{	// mysqli transaction begins: 
					$this->conn->autocommit(false);
					$a = $this->conn->query("DELETE FROM votes WHERE id=".$data['id']);
					//if($voteNature>0 || $voteNature<0)
						$voteNature *=-1; 
						$b = $this->conn->query("UPDATE uploads SET votes=votes+($voteNature) where id=".$data['uploadID']);

					if($a && $b)
					{	$this->conn->commit();
						return array(	'msg'	=>	'Your vote has been undone!',
								'error' =>	FALSE,
								'votes'	=>	$this->getVotesCount($fileId),
								'credits'=>	-1
							);
					}
					else
					{	$this->conn->rollback();
						return array(	'msg' =>	'Error in undoing your vote. Please try again.',
								'error' =>	TRUE,
								'votes'	=>	$this->getVotesCount($fileId),
								'credits'=>	0
							);
						
					}	

					$this->conn->autocommit(true);
					//mysql transaction finishes
				}
				else  // this guy has not casted this vote earlier.. see if its an impossible vote
				{	
					//if one of the votes, of an impossible pair, of votes was casted earlier, forbid this guy from creating an impossible pair
					if( ((int)$data['voteNature'])  + $voteNature == 0)
					{	$returnFlag = true;
						return array(	'msg' =>	'<ul><li>You have already voted this note.</li><li>You will have to undo your earlier vote first!</li></ul>',	//'. (($voteNature*(-1))>0) ? '+'. ($voteNature*(-1)) : '-'. ($voteNature*(-1)) .'
								'error' =>	TRUE,
								'votes'	=>	$this->getVotesCount($fileId),
								'credits'=>	0
							);
					}
				}
				/*
				if($returnFlag)
				{	return  array(	'msg' =>	'<li>Something unknown occured!</li>',	//'. (($voteNature*(-1))>0) ? '+'. ($voteNature*(-1)) : '-'. ($voteNature*(-1)) .'
						'error' =>	FALSE,
						'votes'	=>	$this->getVotesCount($fileId)
					);
				}
				*/
				//move to next vote by this person
				$data = $result->fetch_assoc();
			}
			
			// not yet returned! this means this guy is clean to vote..register his vote 
			
			// mysql transaction begins
			$this->conn->autocommit(false);
			$a = $this->conn->query("INSERT INTO votes (userId, uploadId, voteNature) VALUES ($refId, $fileId, $voteNature)");
			//if($voteNature>0 || $voteNature<0)
				$b = $this->conn->query("UPDATE uploads SET votes=votes+$voteNature where id=".$fileId);
			if($a && $b)
			{	$this->conn->commit();				
			}
			else
			{	$this->conn->rollback();
				return array(	'msg' =>	'Error in registering your vote! Please try again',
						'error' =>	TRUE,
						'votes'	=>	$this->getVotesCount($fileId),
						'credits'=>	0
					);
			}
			$this->conn->autocommit(true);
			//mysql transaction finishes
			
			//all done happily, send the votescount
			return array(	'votes'	=> $this->getVotesCount($fileId),
					'msg'	=> "",
					'error'	=> FALSE,
					'credits'=>	1
				);


/*			$query = "SELECT votes FROM uploads WHERE id=$fileId";
			$result2 = $this->conn->query($query);
			if($result2)
			{	$data = $result2->fetch_assoc();
				$votes = $data['votes'];
				return $votes;
			}
*/

		}
		else
		{	//var_dump($result);
			return array(	'votes'	=> 'X',
					'msg'	=> "OOPS! We ran into a system error! Please try again",
					'error'	=> TRUE,
					'credits'=>	0
				);
		}

	} 
	
	
	public function genNotifMsg($params)
	{	$msg = NULL;
		switch($params['type'])
		{	case 'UPVOTE': 		$msg = "UPVOTE ON FILE ";
						break;
			
			case 'DOWNVOTE':	$msg = "DOWNVOTE ON FILE ";
						break;
						
			case 'DOWNLOAD':	$msg = "DOWNLOAD OF FILE ";
						break;
			
			case 'UPLOAD':		$msg = "UPLOAD OF FILE ";
						break;
						
			case 'BOUNTY':		$msg = "BOUNTY ON FILE ";
						break;
		
		}
		
		return $msg .= $params['fileID'];
	
	}
	
	
	public function changeUserRepo($params)
	{	//begin transaction
		$this->conn->autocommit(false);
		$change = $params['change'];
		$refID = $params['userID'];
		
		$a = $this->conn->query("UPDATE users SET reputation=(reputation+($change)) WHERE refID='$refID' ");
		$b = TRUE;
		if($params['notify']==TRUE)
		{	$type = $params['type'];
			$reference = $params['fileID'];
			$msg = $this->genNotifMsg($params);
			$b = $this->conn->query("INSERT INTO repoEvents (userID, repoChange, type, reference, message, time) VALUES($refID, $change, '$type', $reference, '$msg', '$this->getCurrentTime()')");
		}

		if($a && $b)
		{	$this->conn->commit();
			$this->conn->autocommit(true);
			return TRUE;		
		}
		
		$this->conn->rollback();
		$this->conn->autocommit(true);
		return FALSE;
	}
	

	public function searchNotes($searchStr)
	{	$rows = array();
	
	
		$returnArray = array();		
		$returnArray['error'] = false;
		$returnArray['msg'] = "I swear I dont know what happened! Anyways, I broke something. Please try again :P";
		$returnArray['rows'] = NULL;
		
		$q = "SELECT * FROM validUploadsView
			WHERE MATCH (topic) 
			AGAINST ('$searchStr' IN BOOLEAN MODE)";
	
		
		
		$res = $this->conn->query($rowsq);
		$result = $this->conn->query($q);
	
		if($stmt = $this->conn->prepare($q))
		{	
			$i=0;
			while($data = $result->fetch_assoc())
			{	$rows[$i] = $data;
				$res2 = $this->conn->query('SELECT tagAcronym, tagName, tagId, tagType FROM uploadsTagsView WHERE uploadId='. $rows[$i]['id'] .' ORDER BY tagName, tagType');
				if($res2)
				{	$j=0;
					while($tags2 = $res2->fetch_assoc())
					{	$rows[$i]['tags'][$j] = $tags2;
						$j++;
					}
				}
				$i++;
			}
			$returnArray['error'] = false;
			$returnArray['msg'] = "Hurray! i have the results! ".$searchStr;
			$returnArray['rows'] = $rows;	
		}
		else 
		{	$returnArray['error'] = true;
			$returnArray['msg'] = 'Database Error '.$q.$this->conn->error;
			$returnArray['rows'] = NULL;
		}
		
		return $returnArray;
	}
	
	
	public function createNewTag($name, $acronym, $type, $refID)
	{	
		$returnArray = array( 'error'=> false, 'msg' => -1);
		
		if(empty($name) )
		{	$returnArray['error'] = true;
			$returnArray['msg'] = '<li>Full name of the tag is required!</li> ';			
		}	
		if(empty($acronym ))
		{	$returnArray['error'] = true;
			$returnArray['msg'] .= '<li>Short Name of the tag is required!</li> ';			
		}	
		if(empty($type) )
		{	$returnArray['error'] = true;
			$returnArray['msg'] .= '<li>Please fill the type of your tag!</li> ';			
		}	
		if(empty($refID) )
		{	$returnArray['error'] = true;
			$returnArray['msg'] .= '<li>Invalid Request from non-existing user!</li> ';
		}
		
		if($returnArray['error'] == false)
		{	$result = $this->conn->query("SELECT * FROM tagsAvailable where name=\"$name\" OR acronym=\"$acronym\" LIMIT 30");
		
			if($result)
			{	$i=0;
				while(true)
				{	$data = $result->fetch_assoc();
					if(!$data)
						break;
						
					if($data['name'] == $name)
					{	$returnArray['data']['tag'][$i]['error'] = 'name';
						$returnArray['data']['error']= true;
						$returnArray['data']['tag'][$i]['id'] = $data['id'];
						$returnArray['data']['tag'][$i]['name'] = ucwords($data['name']);
						$returnArray['data']['tag'][$i]['type'] = ucwords($data['type']);
						$returnArray['data']['tag'][$i]['acronym'] = $data['acronym'];
						
						$i++;
					}
					else if($data['acronym'] == $acronym)
					{	//do somethin	
						$returnArray['data']['tag'][$i]['error'] = 'acronym';
						$returnArray['data']['error']= true;
						$returnArray['data']['tag'][$i]['id'] = $data['id'];
						$returnArray['data']['tag'][$i]['name'] = ucwords($data['name']);
						$returnArray['data']['tag'][$i]['type'] = ucwords($data['type']);
						$returnArray['data']['tag'][$i]['acronym'] = $data['acronym'];
						
						$i++;
					}
					
				}
				
			}
		}
		
		if($returnArray['error']==true || $returnArray['data']['error']==true)
			return $returnArray;
			
		//else no similar tag exists.. lets create a new one
		$result = $this->conn->query("INSERT INTO tagsAvailable(name, acronym, type, addedBy) VALUE('$name', '$acronym', '$type', '$refID')");
		if(!$result)
		{	
			$returnArray['error'] = true;
			$returnArray['msg'] = 'Oops! Some error occured while registering your tag! Please try again.';
		}
		else
		{	$returnArray['msg']= 'Thanks! Your tag has been added and you can use it now. <br/>However, it may be reviewed and merged later with some other tag in case both are similar.';
		}
		
		return $returnArray;
		
	}
	
	
}


?>
