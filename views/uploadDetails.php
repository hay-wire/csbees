<?php

function uploadDetails($params)
{
	$file_error = TRUE;		
	
	if(isset($params['fileid'])) 
	{	$conn = dbconnect();
		$query = 'SELECT * FROM validUploadsView WHERE id='.$params['fileid'];
		$result = @$conn->query($query);
		if($result)
		{	
			$data = $result->fetch_assoc();
			if($data)
			{	$file_error = FALSE;
				$id = $data['id'];
				$time = $data['time'];
				$downloadCount = $data['downloadCount'];
				$voteCount = $data['votes'];
				$uploaderRepo = $data['reputation'];
			
				$topic = $data['topic'];
				$description = $data['descr'];
				if(empty($description))
				{	$description = 'No description available.';
				}
				
				$uploaderProfileURL = $data['uploaderProfileURL'];
				$uploader = $data['uploader'];
				if(empty($uploader))
				{	$uploader = 'Guest';
					$uploaderProfileURL = "#";
				}
				
				$fileSize = (float)$data['fileSize'];
				$fileSize = round($fileSize, 2);
				if($fileSize<=0)
					$fileSize = 'I think the file is corrupt!';
				else
				{	if($fileSize>1024)
					{	$fileSize /= 1024;
						$fileSize = round($fileSize, 2);
						$fileSize .= ' MB';
					}
					else
					{	$fileSize .= ' KB';
					}
				}
	
				//fetch all the tags for the current file and store them in an array
				$query2 = 'SELECT tagAcronym, tagName, tagId, tagType FROM uploadsTagsView WHERE uploadId='. $id .' ORDER BY tagName, tagType';
				$result2 = @$conn->query($query2);
				$tags = array();
				if($result2)
				{	$j=0;
					while(TRUE)
					{	$tag = $result2->fetch_assoc();
						if(!$tag)
							break;
						$tags[$j] = $tag;
						$j++;
						//echo '<br/>printing tags: ';
						//print_r($tags);
					}
				}

				$tagsHTML = NULL;
				for( $i=0; $i < sizeof($tags); $i++ )
				{	$tagsHTML.= '<span class="noteCircle ';
					$titlePrefix = ucwords($tags[$i]['tagType']);
					$classSpecifier = 'tag'.$titlePrefix;
			
					//the above code creates something like:
					/*	for $tags[$i]['tagType'] = 'subject'
						$titlePrefix = 'Subject: ';
						$classSpecifier='tagSubject';
					
					*/
					// so while creating new tags, to style them, keep the $classSpecifier value in view	
					$tagsHTML.= $classSpecifier. '" title="'.$titlePrefix.': '. ucwords($tags[$i]['tagName']) .'">'. $tags[$i]['tagAcronym'] .'</span>';

				}
			
				$__BASE_URL = __BASE_URL;
				$HTML= <<<__REG_DATA
				<div class="contentBox">
					<div  class="theme-gradient" style="min-height: 35px; border-radius:3px;">
							<h1>Notes Details </h1>
					</div>
					
					<row class="downloadableNote">
					
						<div class="noteFlags">
							<div class="flags-holder flags-row">
								<div class="flags-cell-50">	
									<div class="vote" id="VotesCount">{$voteCount}</div>
									<div class="vote vote-middle">Votes</div>
								</div>
								<div class="flags-cell-50">
									<div class="vote" id="DownloadsCount">{$downloadCount}</div>
									<div class="vote vote-middle">Downloads</div>
								</div>
							</div>
							<div class="flags-holder flags-row">
									<div class="vote vote-up-down" id="VoteUp" fileId="{$id}" title="Vote Up">
										<img src="{$__BASE_URL}/images/flags/voteup2.png"/>
										<div class="vote vote-middle" style="font-size: 45%; margin:0;">VoteUp</div>
									</div>
									<div class="vote vote-up-down" id="VoteDown" fileId="{$id}" title="Vote Down">
										<img src="{$__BASE_URL}/images/flags/votedown2.png"/>
										<div class="vote vote-middle"  style="font-size: 45%; margin:0;">VoteDown</div>
									</div>
							</div>
							<div class="flags-holder flags-row">
								<a href="{$__BASE_URL}/download.php?downloadId={$id}" target="_blank">
									<div class="flags-cell-50" style="margin-left:auto; margin-right:auto;">	
										<img src="{$__BASE_URL}/images/flags/save2.png"/>
										<div class="vote vote-middle">Download</div>
									</div>
								</a>
								<a href="{$__BASE_URL}/download.php?downloadId={$id}" target="_blank">
									<div class="flags-cell-50" style="margin-left:auto; margin-right:auto;">	
										<img src="{$__BASE_URL}/images/flags/share3.png"/>
										<div class="vote vote-middle">Share</div>
									</div>
								</a>
							</div>
							
						</div>
						
						<div id="NotificationBox" class="click-dismiss" style="visibility:hidden;">
							<div id="Footer">
								(Click on this box to dismiss it)
							</div>
						</div>

						<div class="noteDetails">
							<div class="title">
								<span class="topic">{$topic} </span>
								<span class="doc-info"> {$fileSize} {$fileType} </span>
							</div>

							<div class="desc"><b>Description: </b><br/><pre>{$description}</pre></div>
							<div class="rowFooter">
								<div class="circlesArea">
									{$tagsHTML}
								</div>
								
								<div class="time-n-name" style="border-top:0px;"><!--parent-->
									<div class="repo">
										{$uploaderRepo}
									</div>
									<div class="time-n-name">
										<span class="time" title="{$time}">{$time}
										</span>
										<span class="uploaderName">
											<a 
__REG_DATA;
											if($uploaderProfileURL!="#")
											{	$HTML.= 'href="'. $uploaderProfileURL .'" ';
											}
			$HTML.= <<<__REG_DATA
							 			    >{$uploader}</a>
										</span>
									</div>
								</div><!--end of time-n-repo (parent)-->
							</div><!--end of row footer-->
						</div><!--end of notes-details-->

					</row>
				</div>
__REG_DATA;
				return 	$HTML;
			}
			
		}
		
		
	}
	
	// returning false tells calling page that file was not found.. so a 404 msg can be displayed
	return FALSE;
}	


?>