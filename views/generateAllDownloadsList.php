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

function generateAllDownloadsList($params)
{		
		$__PAGE_VIEW_KEYWORD = cleanString($_GET[__PAGE_VIEW_KEYWORD]);
				

		$currentURL=$_SERVER['REQUEST_URI'];
		$uri=parse_url($currentURL);
		
		if(empty($_GET))
			$URL=$_SERVER['PHP_SELF'].'?';
		else
			$URL=$currentURL.'&';
			
			
			
		
		
		$currentPage = isset($_GET['page']) ? (int)cleanString($_GET['page']) : 1;
		if($currentPage<1)
			$currentPage = 1;
			
		$offset = ($currentPage-1) * __ITEMS_PER_PAGE;
		$pageMax = 1;			// = Maximum pages possible. this is determined after a few lines from the database
		unset($_GET['page']);
		$URL = $_SERVER['PHP_SELF'].'?'.http_build_query($_GET).'&';
		

		//decide currently recieved ordering request before generating order options for the page, and customise accordingly
		$orderBy = null;
		if(isset($_GET['sort']))
		{	$s = cleanString($_GET['sort']);
		
			if('newestFirst'==$s)
				$orderBy = " ORDER BY id DESC";
		
			else if('oldestFirst'==$s)
				$orderBy = " ORDER BY id";
		
			else if('aTopic'==$s)
				$orderBy = " ORDER BY topic";
		
			else if('zTopic'==$s)
				$orderBy = " ORDER BY topic DESC";
		
			else if('aUploader'== $s)
				$orderBy = " ORDER BY uploader";			
		
			else if('zUploader'== $s)
				$orderBy = " ORDER BY uploader DESC";
		
			//else if('relevance'== $s)
				
						
		}

		$conn = dbconnect();
		$query = 'SELECT * FROM validUploadsView '.(($orderBy==null) ? ' ORDER BY id DESC' : $orderBy);
		$rowsQuery = 'SELECT count(*) as rows FROM validUploadsView ';
		
		switch($__PAGE_VIEW_KEYWORD)
		{	case null:			break;		// put it in the first as this is the mostly matched query
			
							/*****************************************************/
			case __MY_UPLOADS_PAGE_KEYWORD:	$query='SELECT * FROM validUploadsView
								WHERE uploaderRefID="'. $params['refID'] .'" '. (($orderBy==null) ? ' ORDER BY id DESC' : $orderBy);
							$rowsQuery = 'SELECT count(*) as rows FROM validUploadsView
									WHERE uploaderRefID="'. $params['refID'] .'" ';
							break;

							/*****************************************************/
			case __HOME_PAGE_KEYWORD:	$query='SELECT * FROM validUploadsView
								WHERE id IN (  SELECT uploadsTags.uploadId
										       FROM usersTags
										       		INNER JOIN uploadsTags ON(uploadsTags.tagId=usersTags.tagID)
										       	WHERE usersTags.userID="'. $params['refID'] .'"
										    )'.(($orderBy==null) ? ' ORDER BY id DESC' : $orderBy);
							$rowsQuery = 'SELECT count(*) as rows FROM validUploadsView
								WHERE id IN (  SELECT uploadsTags.uploadId
										       FROM usersTags
										       		INNER JOIN uploadsTags ON(uploadsTags.tagId=usersTags.tagID)
										       	WHERE usersTags.userID="'. $params['refID'] .'"
										    )';
							break;

							/**************************115.249.182.130***************************/
			case __SEARCH_PAGE_KEYWORD:	$query = 'SELECT * FROM validUploadsView
									WHERE MATCH (topic, descr) 
									AGAINST ("'.$params['searchStr'].'" IN BOOLEAN MODE) '.$orderBy;
							$rowsQuery = 'SELECT count(*) as rows FROM validUploadsView
									WHERE MATCH (topic, descr) 
									AGAINST ("'.$params['searchStr'].'" IN BOOLEAN MODE)';
							break;

							/*****************************************************/
		}
		//echo $rowsQuery;
		$totalRowsAvailable = 0;
		//detemine the maximum pages possible for this query
		if($res = $conn->query($rowsQuery))
		{	$data = $res->fetch_assoc();
			$totalRowsAvailable = $data['rows'];
			$pageMax = (int) ($data['rows'] / __ITEMS_PER_PAGE);
			if( ($data['rows'] % __ITEMS_PER_PAGE) > 0)
				$pageMax++;
				
			if($currentPage >$pageMax)
				$currentPage = $pageMax;
		}
		


		$DOWNLOADSListHTML.= 
		'<div class="contentBox">
			<div id="sort" class="theme-gradient" style="min-height: 40px; border-radius:3px;">
				<!--button onclick="history.go(-1);">'.$_SERVER['HTTP_REFERER'].'</button-->
				<form action="'.__SEARCH_PAGE_URL.'&" action="GET">
					<input type="submit" id="searchButton" value="" title="Click here to search"/>
					<input type="hidden" name="'.__PAGE_VIEW_KEYWORD.'" value="'.__SEARCH_PAGE_KEYWORD.'"/>
					<input type="text" width="30" name="q" class="searchInput" value="'.str_replace("*", "", $params['searchStr']).'" placeholder="Search Notes"/>
				</form>
			</div>
			<div id="searchResults"></div>
			<div id="downloadsList">';
		
		
		if($params['isloggedIn'] && ($__PAGE_VIEW_KEYWORD == __HOME_PAGE_KEYWORD))
		{	$DOWNLOADSListHTML.= '<div class="contentTitle announce">Showing '.$currentPage.' of total '.$pageMax.' Pages for the Notes available under the tags of <a href="'. __PROFILE_PAGE_URL .'#mytags">your choice</a> </div>';
			if(empty($params['userTagsList']))
			{	$DOWNLOADSListHTML .= '<a style="color:white" href="'. __PROFILE_PAGE_URL .'#myTags"><div id="NotificationBox" style="visibility:visible" >Oops! Your personalised list seems empty! Click here to refine your list.</div></a>';
			}
		}
		else if($__PAGE_VIEW_KEYWORD == __SEARCH_PAGE_KEYWORD)
		{	$DOWNLOADSListHTML.= '<div class="contentTitle announce">Found '.$totalRowsAvailable.' Notes for: <b>"'.str_replace("*", "", $params['searchStr']).'"</b></div>';
			
		}
		else if($params['isloggedIn'] && ($__PAGE_VIEW_KEYWORD == __MY_UPLOADS_PAGE_KEYWORD))
		{	$DOWNLOADSListHTML.= '<div class="contentTitle announce">You have uploaded <b>'.$totalRowsAvailable.'</b> Notes so far.</div>';
		}
		
		
		$query .= " LIMIT $offset, ".__ITEMS_PER_PAGE;
		$rowNum=0;
		$result = @$conn->query($query);
		if($result)
		{	
			while(true)
			{	$data = $result->fetch_assoc();
				//print_r($data);
			
				if(!$data)
				{	break;
				}
				else
				{	$rowNum++;
			
					$id = $data['id'];
					$time = $data['time'];
					$downloadCount = $data['downloadCount'];
					$voteCount = $data['votes'];
					$uploaderRepo = $data['reputation'];
					if(!$uploaderRepo)
						$uploaderRepo = 0;

					$topic = substr($data['topic'], 0 , 150);
					if( strlen($data['topic']) > 150 )
						$topic .= '...';

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
						$fileSize = 'Empty File!';
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
					



					$DOWNLOADSListHTML.='<row id="'.$id.'" class="downloadableNote '. ( ($rowNum == 1)?'first-row':null) . '">';
			
					$__BASE_URL = __BASE_URL;
					$_FILEDETAILS_PAGE_URL = __FILEDETAILS_PAGE_URL;	
					// use the functions.php's 'genPagesListHTML' to get the format for displaying the pages set.
							
					$DOWNLOADSListHTML.= <<<__REG_DATA
					
						<div class="noteFlags">
							
							<div class="flags-holder">
									<div class="vote" style="foont-size:150%;">{$voteCount}</div>
									<div class="vote vote-middle">Votes</div>
							</div>
							<div class="flags-holder">
									<div class="vote" style="foont-size:150%;">{$downloadCount}</div>
									<div class="vote vote-middle">Downloads</div>
							</div>							
						</div>

						<div class="noteDetails">
							<div class="title">
								<a href="{$_FILEDETAILS_PAGE_URL}{$id}" title="See Details"> <span class="topic">{$topic} </span> </a>
								<span class="doc-info"> {$fileSize} {$fileType} </span>
							</div>

							<!--div class="desc">{$description}</div-->
							<div class="rowFooter">
								<div class="circlesArea">
__REG_DATA;
									$i=0;
									while( $i < sizeof($tags) )
									{	$DOWNLOADSListHTML.= '<span class="noteCircle ';
										$titlePrefix = ucwords($tags[$i]['tagType']);
										$classSpecifier = 'tag'.$titlePrefix;
										
										//the above code creates something like:
										/*	for $tags[$i]['tagType'] = 'subject'
											$titlePrefix = 'Subject: ';
											$classSpecifier='tagSubject';
												
										*/
										// so while creating new tags, to style them, keep the $classSpecifier value in view	
										$DOWNLOADSListHTML.= $classSpecifier. '" title="'.$titlePrefix.': '. ucwords($tags[$i]['tagName']) .'">'. $tags[$i]['tagAcronym'] .'</span>';
										$i++;
									}
			$DOWNLOADSListHTML.= <<<__REG_DATA
								</div>	<!--end of circlesArea-->

								<div class="time-n-name" style="border-top:0px;"><!--parent-->
									<div class="repo" title="{$uploader}'s Reputation">
										<img src="images/repoMedal.png" alt="Reputation"/>{$uploaderRepo}
									</div>
									<div class="time-n-name">
										<span class="time" title="{$time}">{$time}
										</span>
										<script>
											//$(function() { $(".time-n-name .time").prettyDate({ interval: 1000 }); });
										</script>
										<span class="uploaderName">
											<a 
__REG_DATA;
												if($uploaderProfileURL!="#")
												{	$DOWNLOADSListHTML.= 'href="'. $uploaderProfileURL .'" ';
												}
				$DOWNLOADSListHTML.= <<<__REG_DATA
								 			    >{$uploader}</a>

										</span><!--end of uploaderName-->
									</div>
								</div><!--end of time-n-repo (parent)-->
							</div>
						</div>

					</row>
				
__REG_DATA;


				}
			}
		}
		if($rowNum == 0 && $__PAGE_VIEW_KEYWORD == __HOME_PAGE_KEYWORD)
		{	$DOWNLOADSListHTML .= '	<div id="NotificationBox" style="visibility:visible" >
							No notes uploaded under the tags which you have opted for.<br/>
							Try some different tags or maybe you can upload your own notes! :)
						</div>';
		}
		
		
		// there are results.. time to show pagination ribbon
		unset($_GET['page']);
		$URL = $_SERVER['PHP_SELF'].'?'.http_build_query($_GET).'&';
		if($pageMax<1)
			$pageMax  =  1;
		$DOWNLOADSListHTML.= '<div id="sort" class="theme-gradient" style="padding:1%;">';
		$DOWNLOADSListHTML.= genPagesListHTML($currentPage, $pageMax, $URL);
		$DOWNLOADSListHTML.= '</div>';
	
	
		
		$DOWNLOADSListHTML.= '</div></div>';
		return 	$DOWNLOADSListHTML;


}

?>
