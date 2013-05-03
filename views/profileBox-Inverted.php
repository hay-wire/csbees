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


function profileBox($params)
{	
	//echo '<br/><br/>inside ProfileBox()<br/>'; print_r($params);
	$editMode = ($params['editMode']===TRUE) ? TRUE : FALSE;
	
	$ProfileBoxHTML .= '<div class="contentBox">';
				$ProfileBoxHTML .= ($params['msg']) ? ('<div id="NotificationBox" style="visibility:visible" class="click-dismiss '. (($params['error'])? 'badbox':'goodbox') .'"><ul>'. $params['msg'] .'</ul></div>'):null;
				
				$ProfileBoxHTML .='
				<a name="SubjectChoice"></a>
				<div id="subject-tokeninput" style="margin-top:6%;">
					<div class="theme-gradient">
						<h1 id="subjects">MY SUBJECTS</h1>
					</div>
					
					<form action="" method="POST" name="subjectsForm">
					
					<row>
					    <span class="tag"></span>
					    <input type="submit" value="Save My Subjects!" class="myButton" />
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

';
						//<row>
						//	<span class="tag">Your Name:</span>
						//	';
						//if user id not logged in, upload will have to be authorised first under guest's name
						//if(!$params['isloggedIn'])
						//{	$ProfileBoxHTML .= '<input type="textbox" name="name" placeholder="eg., Navneet, Prashant" value="'.$uploaderName.'">
						//</row>';
						//}
						
				
						
					$ProfileBoxHTML .= '
				<div class="theme-gradient">
					<h1>Profile: '.$params['name'].'</h1>
				</div>
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
					
							
			$ProfileBoxHTML .= 	'<row>
							<span class="tag">Nickname:</span>
							<input style="width:493px;" type="textbox" name="name" placeholder="e.g., Harry Potter :-P" value="'.$params['name'].'" '. ((!$editMode) ? 'disabled' : null) .'/>
						</row>
					</form>				
				</div>
			

		</div>
	';

	return $ProfileBoxHTML;
}




?>
