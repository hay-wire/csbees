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


function taggedUploadBox($params)
{	
	//echo '<br/><br/>inside DownloadBox()<br/>'; print_r($params);
	$uploadBoxHTML .= '<br/>
	
		<div class="contentBox">
			
				<div id="hiddenDesc" style="width:0px; height:0px; overflow: hidden;">
				Share your handwritten college notes online for free, get rated and spread education! Download from thousands of quality write-ups across the globe on your topic even a night before the exams!! Moreover, it also helps you to buid a a free online backup of your notes!!!
				</div>
				
				<a name="up"></a>
				<div class="theme-gradient">
					<h1>NEW UPLOAD</h1>
				</div>
				';
				$uploadBoxHTML .= (!empty($params['msg'])) ? '<div id="NotificationBox" style="visibility:visible"  class="goodbox click-dismiss"><ul>'. $params['msg'] .'</ul></div>':null;
				$uploadBoxHTML .= (!empty($params['error'])) ? '<div id="NotificationBox" style="visibility:visible" class="badbox click-dismiss"><ul>'. $params['error'] .'</ul></div>':null;
				
				$uploadBoxHTML .= '
				<div id="uploader">
					<form action="" method="POST" enctype="multipart/form-data">
						';					
								
						$uploadBoxHTML .= 	'
							
							<input type="hidden" name="uploadAttempted" value="1">
						
						
						<row>
							<span class="tag">Title:</span>
							<input type="text" name="topic" class="inputbox" placeholder="Example: &quot;4 Queens Problem&quot; OR &quot;Role of government in industrial development&quot;, etc" value="'.$params['selectedTopic'].'">
						</row>
						<row>
							<span class="tag">Description:</span>
							<textarea style="height:100px;"  class="inputbox" rows="50" cols="50" name="desc" placeholder="Optional description of your notes." value="'.$params['selectedDesc'].'"></textarea>
						</row>
						';
						//<row>
						//	<span class="tag">Your Name:</span>
						//	';
						//if user id not logged in, upload will have to be authorised first under guest's name
						//if(!$params['isloggedIn'])
						//{	$uploadBoxHTML .= '<input type="text" name="name" placeholder="eg., Navneet, Prashant" value="'.$uploaderName.'">
						//</row>';
						//}
						
					$uploadBoxHTML .= '
						
						<row>
							<span class="tag">File:</span>
								<input name="upload" class="inputbox" type="file" />
						</row>
						
						
						
						<row> 
							<span class="tag">Tags:</span> 
							<input type="text" id="input-tags" name="tags" placeholder="Type in a few letters to see matching tags" class="inputbox"/>
						
						<script type="text/javascript">
					    $(document).ready(function() {
					        $("#input-tags").tokenInput("'.__BASE_URL.'/ajaxRequests/returnTags.php", {
					            prePopulate: [';
					            
					            $i=0;
					            while(true)
					            {	if(empty($params['userTagsList'][$i]))
					            	{      	break;
					            	}
					            	$sub = $params['userTagsList'][$i];
					            	$JSON_encodableSubjectArray['id'] = $params['userTagsList'][$i]['tagId'];
					            	$JSON_encodableSubjectArray['name'] = $params['userTagsList'][$i]['tagName'];
					            
					            	$i++;
					            	//var_dump($params['UserSubjectsList']);
					            	
					            	
					            	
					            	//$ProfileBoxHTML .= '{"id": "'. $sub['sid'] .'", "name": "'. $sub['subject'] .'"},';
					            	
					            	$uploadBoxHTML .= json_encode($JSON_encodableSubjectArray).', ';
					            		//{id: 123, name: "Slurms MacKenzie"},
						        
						    }					                
					            
					            
					            
					            
			$uploadBoxHTML .= 	     '], 
preventDuplicates:true,
hintText: "<div style=\"padding:1%; background-color:rgb(96, 181, 238); color:white; font-weight:bold;\">Type some letter or keyword(s) to choose tags.</div>",
noResultsText: "<div style=\"padding:1%; background-color:red; color:white; font-weight:bold;\"> No matching tag. Try a different keyword or <a id=\"newTagTrigger\" href=\"#\" style=\"color:#5D6424; padding:3px; background-color:#FAFAB3; border-radius:3px;\"> Create a new tag here</a>  </div>",
searchingText: "Searching the available tags..",
//tokenLimit: 1,
placeholder: "Type in a few words or letters of your tags..",
theme:"facebook"
}); });
					   		 </script>		
						
						</row>
						
						<br/>
						
						<row>
							<span class="tag"></span>
							<input type="submit" value="Upload My Notes!" class="myButton" ">
						</row>
					</form>
				</div>
				
				<div id="newTagArea" style="background-color:rgb(255, 255, 244); position:relative; box-shadow: 0 0 3px gray; border-radius: 5px; padding: 2%; margin:2%; ">
							
							<img id="closeTagCreator" style="float:right; cursor:pointer; display:block;" src="'. __BASE_URL .'/images/buttons/dialogCloseButton.gif" alt="close" title="Close and Continue with Notes Uploading"/>
														
							<h1 style="text-align:center; color: black;">Add a New Tag</h1>
							<row>
								<span class="tag">Tag\'s Full Name:</span>
								<input type="text" placeholder="Example: &quot;Environmental Sciences&quot; OR &quot;MY College&quot;, etc" name="newTagFullName"/>
														
							</row>
							
							<row>
								<span class="tag">Tag\'s Short Name:</span>
								<input type="text" placeholder="Example: &quot;evs&quot; OR &quot;my-college&quot;, etc" name="newTagShortName"/>
														
							</row>
							
							<row>
								<span class="tag">It is a:</span>
								<select type="text" name="newTagCategory">
									<option value="subject" >Subject</option>
									<option value="college">College/University</option>
									<option value="topic">Popular Topic</option>
								</select>
							</row>
							
							<row>
								<div id="similarTagsHolder" style="border: 1px solid rgb(247, 189, 189); border-radius: 3px; padding: 1%; margin-left: 14%; width: 65%; background: rgb(255, 255, 255);">
									<h4 style="margin-top:0; margin-bottom:2%;">Found Similar Tags:</h4>
									<div id="similarTags"></div>
								</div>
							
							</row>
							
							<row>
								<span class="tag"></span>
								<div id="createNewTag" class="myButton" style="text-align:center">Create Tag </div>							
							</row>
							
							
								
						</div>
			

		</div>
	';

	return $uploadBoxHTML;
}

?>