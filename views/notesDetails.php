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
require_once('adsBox.php');

function noteDetails($params)
{	$HTML.= ' <div class="contentBox"> ';

		$HTML.='<div class="theme-gradient" style="min-height: 35px; border-radius:3px;">
				<h1>'. $params['topic'] .'</h1>
			</div>';
	
		$conn = dbconnect();
		$query = 'SELECT * FROM validUploadsView WHERE id='.$params['fileid'];
		$result = @$conn->query($query);
		if($result)
		{	$data = $result->fetch_assoc();
			if($data)
			{	$id = $data['id'];
				$time = $data['time'];
				$downloadCount = $data['downloadCount'];
				$voteCount = $data['votes'];
			
				$topic = $data['topic'];
			
				$uploaderProfileURL = $data['uploaderProfileURL'];
				$uploader = $data['uploader'];
				if(empty($uploader))
				{	$uploader = 'Guest';
					$uploaderProfileURL = "#";
				}
			
				$description = substr($data['descr'], 0 , 170);
				if( strlen($data['descr']) > 170 )
					$description .= '...';
			
			

			
				$fileSize = (float)$data['fileSize'];
				$fileSize = round($fileSize, 2);
				if($fileSize<=0)
					$fileSize = 'Less than 2 MB';
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
				$j=0;
				if($result2)
				{	while(TRUE)
					{	$tag = $result2->fetch_assoc();
						if(!$tag)
							break;
						$tags[$j] = $tag;
						$j++;
						//echo '<br/>printing tags: ';
						//print_r($tags);
					}
				}
			



		$HTML.='<row id="'.$id.'" class="downloadableNote '. ( ($rowNum%2 == 0)?'odd-row':null) . '">';

		$__BASE_URL = __BASE_URL;						
		$HTML.= <<<__REG_DATA
			
					<div class="noteFlags">
						<!--div class="flags-holder">
							<div id="plus1" class="vote" title="Vote up"><img src="{$__BASE_URL}/images/flags/vote+1.png"/></div>
							<div id="badfile" class="vote vote-middle" title="Flag as inappropriate"><img src="{$__BASE_URL}/images/flags/flag.png"/></div>
							<div id="minus1" class="vote" title="Vote down"><img src="{$__BASE_URL}/images/flags/vote-1.png"/></div>
						</div-->
						<div class="flags-holder">
								<div class="vote" style="foont-size:150%;">{$voteCount}</div>
								<div class="vote vote-middle">Downloads</div>
						</div>
						<div class="flags-holder">
								<div class="vote" style="foont-size:150%;">{$downloadCount}</div>
								<div class="vote vote-middle">Votes</div>
						</div>							
					</div>

					<div class="noteDetails">
						<div class="title">
							<a href="{$__BASE_URL}/notesdetails.php?id={$id}" title="See Details"> <span class="topic">{$topic} </span> </a>
							<span class="doc-info"> {$fileSize} {$fileType} </span>
						</div>

						<!--div class="desc"><b>Description:</b><br/>{$description}</div-->
						<div class="rowFooter">
							<div class="circlesArea">
__REG_DATA;
								$i=0;
								while( $i < sizeof($tags) )
								{	$HTML.= '<span class="noteCircle ';
									$titlePrefix = ucwords($tags[$i]['tagType']);
									$classSpecifier = 'tag'.$titlePrefix;
								
									//the above code creates something like:
									/*	for $tags[$i]['tagType'] = 'subject'
										$titlePrefix = 'Subject: ';
										$classSpecifier='tagSubject';
										
									*/
									// so while creating new tags, to style them, keep the $classSpecifier value in view	
									$HTML.= $classSpecifier. '" title="'.$titlePrefix.': '. ucwords($tags[$i]['tagName']) .'">'. $tags[$i]['tagAcronym'] .'</span>';
									$i++;
								}
		$HTML.= <<<__REG_DATA
							</div>
							<div class="time-n-name">
								<span class="time">{$time}</span>
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
						</div>
					</div>

				</row>
		
__REG_DATA;
			}
		}
		
		$HTML .= adsBox();
		$HTML.= '</div>';
		return 	$HTML;


}

?>