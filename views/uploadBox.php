<?php


function uploadBox($params)
{	
	//echo '<br/><br/>inside DownloadBox()<br/>'; print_r($params);
	$uploadBoxHTML .= '
	
		<div class="contentBox">
			
				<div id="hiddenDesc" style="width:0px; height:0px; overflow: hidden;">
				Share your handwritten college notes online for free, get rated and spread education! Download from thousands of quality write-ups across the globe on your topic even a night before the exams!! Moreover, it also helps you to buid a a free online backup of your notes!!!
				</div>
				
				<div class="theme-gradient">
					<h1>NEW UPLOAD</h1>
				</div>
				';
				$uploadBoxHTML .= (!empty($params['msg'])) ? '<div id="notificationBox"  class="goodbox click-dismiss"><ul>'. $params['msg'] .'</ul></div>':null;
				$uploadBoxHTML .= (!empty($params['error'])) ? '<div id="notificationBox" class="badbox click-dismiss"><ul>'. $params['error'] .'</ul></div>':null;
				
				$uploadBoxHTML .= '
				<div id="uploader">
					<form action="" method="POST" enctype="multipart/form-data">
						<row> 
							<span class="tag">College:</span> 
							<select  name="college">';
								$uploadBoxHTML .= DropDownGenerator($params['collList']['collid'], $params['collList']['name'], $params['selectedCollege']);
						
						$uploadBoxHTML .= 	'</select>
						</row>
						
						<row> 
							<span class="tag">Course:</span> 
							<select  name="course">';
								//print_r($params['courseList']);
								$uploadBoxHTML .= DropDownGenerator($params['courseList']['cid'], $params['courseList']['course'], $params['selectedCourse']);

								
								
						$uploadBoxHTML .= 	'</select>
						</row>						

						<row> 
							<span class="tag">Department:</span> 
							<select  name="department" style="width:330px;">';
								$uploadBoxHTML .= DropDownGenerator($params['deptList']['deptid'], $params['deptList']['department'], $params['selectedDept']);

								/*
								foreach($params['deptList'] as $data)
								{	$uploadBoxHTML .= '<option value="'.$data['deptid'].'" '.(($data['deptid']==$params['selectedDept'])?'selected="selected"':null).'>'.$data['department'].'</option>';	
								}
								*/
								
						$uploadBoxHTML .= 	'</select>
							
							<span class="tag" style="margin-left:30px; width:80px;">Semester:</span> 
								<select  name="semester" style="width:50px;">';
								$uploadBoxHTML .= DropDownGenerator($params['semList']['semid'], $params['semList']['semester'], $params['selectedSemester']);
								/*
								foreach($params['semList'] as $data)
								{	$uploadBoxHTML .= '<option value="'.$data['semid'].'" '.(($data['semid']==$params['selectedSemester'])?'selected="selected"':null).'>'.$data['semester'].'</option>';	
								}
								*/
								
							$uploadBoxHTML .= 	'</select>
						
						</row>	
						
						<row> 
							<span class="tag">Subject:</span> 
							
								
			
			
			
			
						    <input type="textbox" id="input-subjects" name="subject" placeholder="Type a few letters.."/>
					</row>
					
					    <script type="text/javascript">
					    $(document).ready(function() {
					        $("#input-subjects").tokenInput("'.__BASE_URL.'/ajaxRequests/returnSubjects.php", {
					            prePopulate: [';
					            
					            $i=0;
					            while(true)
					            {	if(empty($params['userSubjectsList'][$i]))
					            	{      	break;
					            	}
					            	$sub = $params['userSubjectsList'][$i];
					            	$JSON_encodableSubjectArray['id'] = $params['userSubjectsList'][$i]['sid'];
					            	$JSON_encodableSubjectArray['name'] = $params['userSubjectsList'][$i]['subject'];
					            
					            	$i++;
					            	//var_dump($params['UserSubjectsList']);
					            	
					            	
					            	
					            	//$ProfileBoxHTML .= '{"id": "'. $sub['sid'] .'", "name": "'. $sub['subject'] .'"},';
					            	
					            	$uploadBoxHTML .= json_encode($JSON_encodableSubjectArray).', ';
					            		//{id: 123, name: "Slurms MacKenzie"},
						        
						    }					                
					            
					            
					            
					            
			$uploadBoxHTML .= 	     '], 
preventDuplicates:true,
hintText: "Type some letter or keyword(s) to choose a subject..",
noResultsText: "No such subject. Try a different keyword..",
searchingText: "Searching the available subjects..",
tokenLimit: 1,
placeholder: "Type in a few words or letters of your subject..",
//theme:"facebook"
}); });
					    </script>
		';
			
			
								
								
								
								
								/*
								$uploadBoxHTML .= '<option value="" selected="">Choose a subject</option>';	

								$uploadBoxHTML .= DropDownGenerator($params['subjectList']['sid'], $params['subjectList']['subject'], $params['selectedSubject']);

								/*
								foreach($params['subjectList'] as $data)
								{	$uploadBoxHTML .= '<option value="'.$data['sid'].'" '.(($data['sid']==$params['selectedSubject'])?'selected="selected"':null).'>'.$data['subject'].'</option>';	
								}
								*/
								
								
						$uploadBoxHTML .= 	'
							
							<input type="hidden" name="uploadAttempted" value="1">
						
						
						<row>
							<span class="tag">Topic:</span>
							<input type="textbox" style="width:493px;" name="topic" placeholder="e.g., 4 Queens Problem or \'GCET-5th SEM CS- Assignment-1\'" value="'.$params['selectedTopic'].'">
						</row>
						';
						//<row>
						//	<span class="tag">Your Name:</span>
						//	';
						//if user id not logged in, upload will have to be authorised first under guest's name
						//if(!$params['isloggedIn'])
						//{	$uploadBoxHTML .= '<input type="textbox" name="name" placeholder="eg., Navneet, Prashant" value="'.$uploaderName.'">
						//</row>';
						//}
						
					$uploadBoxHTML .= '
						
						<row>
							<span class="tag">File:</span>
								<input name="upload" type="file" />
						</row>
						
						<row>
							<span class="tag"></span>
							<input type="submit" value="Upload My Notes!" class="myButton" ">
						</row>
					</form>
				</div>
			

		</div>
	';

	return $uploadBoxHTML;
}

?>
