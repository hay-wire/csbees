<?php


function profileBox($params)
{	
	//echo '<br/><br/>inside ProfileBox()<br/>'; print_r($params);
	$editMode = ($params['editMode']===TRUE) ? TRUE : FALSE;
	
	$ProfileBoxHTML .= (!empty($params['msg'])) ? '<div id="NotificationBox" style="visibility:visible"  class="'. ( (!empty($params['error'])) ? 'badbox' : 'goodbox') . ' click-dismiss"><ul>'. $params['msg'] .'</ul></div>':null;
	
	
	//var_dump($params);


	$ProfileBoxHTML .=
		'<div class="contentBox" style="background-color:transparent;">
		<ul class="tabs-ul">
			<li id="profile" class="tab theme-gradient" linked="me">Profile</li>
			<li id="tags" class="tab theme-gradient" linked="mytags">My Tags</li>
		</ul>
		<div class="tab-content-holder">
			<div id="me" class="tab-content profile-box">
				<div class="contentTitle announce">
					Profile: '.$params['name'].'
				</div>
				';
				//$ProfileBoxHTML .= ($params['msg']) ? ('<div id="NotificationBox" style="visibility:visible" class="click-dismiss '. (($params['error'])? 'badbox':'goodbox') .'"><ul>'. $params['msg'] .'</ul></div>'):null;
				
				$ProfileBoxHTML .= '
				<div id="uploader">
				
					<form action="" method="POST">';
					
					
				if($editMode)
				{	$ProfileBoxHTML .= '
						<row>
							<span class="tag"></span>
							<input type="submit" value="Save Me!" class="myButton"/>
							<input type="hidden" name="saveEditedProfile" value="1">
						</row>';

				}
				else
				{	$ProfileBoxHTML .= '
						<row>
							<span class="tag"></span>
							<a href="'. __PROFILE_PAGE_URL .'&edit=TRUE" class="myButton" style="width:488px; text-align:center;">Enable Profile Editing!</a>
						</row>';
				}
					
					
					
/*					
					
				$ProfileBoxHTML .='<row> 
							<span class="tag">College:</span> 
							<select  name="college" '. ((!$editMode) ? 'disabled' : null) .'>';
								
								$ProfileBoxHTML .= DropDownGenerator($params['collList']['collid'], $params['collList']['name'], $params['selectedCollege']);
						
						$ProfileBoxHTML .= 	'</select>
						</row>
						
						<row> 
							<span class="tag">Course:</span> 
							<select  name="course" '. ((!$editMode) ? 'disabled' : null) .'>';
								//print_r($params['courseList']);
								$ProfileBoxHTML .= DropDownGenerator($params['courseList']['cid'], $params['courseList']['course'], $params['selectedCourse']);

								
								
						$ProfileBoxHTML .= 	'</select>
						</row>						

						<row> 
							<span class="tag">Department:</span> 
							<select  name="department" style="width:330px;" '. ((!$editMode) ? 'disabled' : null) .'>';
								$ProfileBoxHTML .= DropDownGenerator($params['deptList']['deptid'], $params['deptList']['department'], $params['selectedDept']);

								/*
								foreach($params['deptList'] as $data)
								{	$ProfileBoxHTML .= '<option value="'.$data['deptid'].'" '.(($data['deptid']==$params['selectedDept'])?'selected="selected"':null).'>'.$data['department'].'</option>';	
								}
								*\/
								
						$ProfileBoxHTML .= 	'</select>
						
							<span class="tag" style="margin-left:30px; width:80px;">Semester:</span> 
								<select  name="semester" style="width:50px;" '. ((!$editMode) ? 'disabled' : null) .'>';
								$ProfileBoxHTML .= DropDownGenerator($params['semList']['semid'], $params['semList']['semester'], $params['selectedSemester']);
								/*
								foreach($params['semList'] as $data)
								{	$ProfileBoxHTML .= '<option value="'.$data['semid'].'" '.(($data['semid']==$params['selectedSemester'])?'selected="selected"':null).'>'.$data['semester'].'</option>';	
								}
								*\/
								
							$ProfileBoxHTML .= 	'</select>
						
						</row>	
						
						<!--row> 
							<span class="tag">Subject:</span> 
							<select  name="subject" '. ((!$editMode) ? 'disabled' : null) .'>';
								$ProfileBoxHTML .= DropDownGenerator($params['subjectList']['sid'], $params['subjectList']['subject'], $params['selectedSubject']);

								/*
								foreach($params['subjectList'] as $data)
								{	$ProfileBoxHTML .= '<option value="'.$data['sid'].'" '.(($data['sid']==$params['selectedSubject'])?'selected="selected"':null).'>'.$data['subject'].'</option>';	
								}
								*\/
								
								
						$ProfileBoxHTML .= 	'</select>
							
							
						</row-->
*/							
			$ProfileBoxHTML .= 	'<row>
							<span class="tag">Nickname:</span>
							<input style="width:493px;" type="textbox" name="name" placeholder="e.g., Harry Potter :-P" value="'.$params['name'].'" '. ((!$editMode) ? 'disabled' : null) .'/>
						</row>
					</form>';
						//<row>
						//	<span class="tag">Your Name:</span>
						//	';
						//if user id not logged in, upload will have to be authorised first under guest's name
						//if(!$params['isloggedIn'])
						//{	$ProfileBoxHTML .= '<input type="textbox" name="name" placeholder="eg., Navneet, Prashant" value="'.$uploaderName.'">
						//</row>';
						//}
						
				
						
					$ProfileBoxHTML .= '
			</div>		
			</div>
			
			<div id="mytags" class="tab-content subject-box">
				<div class="contentTitle announce">
					MY TAGS
				</div>
					
				<div id="subject-tokeninput" >
					
					<form action="#mytags" method="POST" name="subjectsForm">
					
					<row>
					    <span class="tag"></span>
					    <input type="submit" value="Save My Tags!" class="myButton" />
					 </row>

					<row>
					    <span class="tag">My Tags:<br/><font style="font-size:70%;">(Hint: Type a few letters)</font></span>
					    <input type="textbox" id="input-subjects" name="updateTags" />
					</row>
					
					    <script type="text/javascript">
					    $(document).ready(function() {
					        $("#input-subjects").tokenInput("'.__BASE_URL.'/ajaxRequests/returnTags.php", {
					            prePopulate: [';
					            
					            $i=0;
					            while(true)
					            {	if(empty($params['userTagsList'][$i]))
					            	{      	break;
					            	}
					            	$sub = $params['userTagsList'][$i];
					            	$JSON_encodableTagsArray['id'] = $params['userTagsList'][$i]['id'];
					            	$JSON_encodableTagsArray['name'] = $params['userTagsList'][$i]['name'];
					            
					            	$i++;
					            	
					            	$ProfileBoxHTML .= json_encode($JSON_encodableTagsArray).', ';
					            		//{id: 123, name: "Slurms MacKenzie"},
						        
						    }					                
					            
					            
					            
					            
			$ProfileBoxHTML .= 	     '], 
preventDuplicates:true,
hintText: "Type some letter or keyword(s) to choose a subject..",
noResultsText: "No such subject. Try a different keyword..",
searchingText: "Searching the available subjects..",
//theme:"facebook"
}); });
					    </script>
					    </form>
					</div>

				
				</div>
			</div><!--end of subject-box-->
			
			
			
			
			
			
		
		</div><!--end of tab-content-holder-->	

		</div>
	';

	return $ProfileBoxHTML;
}




?>