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
						<row> 
							<span class="tag">Tags:</span> 
							<input type="text" id="input-tags" name="tags" placeholder="Type a few letters to see matching tags.." class="inputbox"/>
						
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
hintText: "Type some letter or keyword(s) to choose a tag..",
noResultsText: "No matching tag. Try a different keyword..",
searchingText: "Searching the available tags..",
//tokenLimit: 1,
placeholder: "Type in a few words or letters of your tags..",
theme:"facebook"
}); });
					   		 </script>		
						
						</row>';
			
			
								
								
								
								
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
							<input type="text" name="topic" class="inputbox" placeholder="e.g., 4 Queens Problem or Role of government in industrial developent, etc" value="'.$params['selectedTopic'].'">
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
