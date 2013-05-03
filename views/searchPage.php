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

function searchPage($params)
{	$HTML = '<div class="contentBox"> 
			<div id="sort" class="theme-gradient" style="min-height: 40px; border-radius:3px;">
				<form action="'.__SEARCH_PAGE_URL.'&" action="GET">
					<input type="submit" id="searchButton" value="" title="Click here to search"/>
					<input type="hidden" name="'.__PAGE_VIEW_KEYWORD.'" value="'.__SEARCH_PAGE_KEYWORD.'"/>
					<input type="text" width="30" name="q" class="searchInput" placeholder="Search Notes"/>
				</form>
			</div>
			<div id="searchResults">';
			
	//$HTML .= print_r($params);
	$pageMax = 1;
	if($params['error']==FALSE) 
	{
		$rows = $params['rows'];
		if(!empty($rows))
		{	$pageMax = $rows[0]['rowsCount'];
			for($i = 0; $i<sizeof($rows); $i++) 
			{
				$id = $rows[$i]['id'];
				$time = $rows[$i]['time'];
				$downloadCount = $rows[$i]['downloadCount'];
				$voteCount = $rows[$i]['votes'];
				$uploaderRepo = $rows[$i]['reputation'];
				if(!$uploaderRepo)
					$uploaderRepo = 0;

				$topic = substr($rows[$i]['topic'], 0 , 150);
				if( strlen($rows[$i]['topic']) > 150 )
					$topic .= '...';

				$uploaderProfileURL = $rows[$i]['uploaderProfileURL'];
				$uploader = $rows[$i]['uploader'];
				if(empty($uploader))
				{	$uploader = 'Guest';
					$uploaderProfileURL = "#";
				}

				$fileSize = (float)$rows[$i]['fileSize'];
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
		
				$HTML.='<row id="'.$id.'" class="downloadableNote '. ( ($rowNum%2 == 0)?'odd-row':null) . '">';
				$HTML.= <<<__REG_DATA
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

							<div class="rowFooter">
								<div class="circlesArea">
__REG_DATA;
									$tags = $rows[$i]['tags'];
									for($j=0; $j < sizeof($tags); $j++ )
									{	$HTML.= '<span class="noteCircle ';
										$titlePrefix = ucwords($tags[$j]['tagType']);
										$classSpecifier = 'tag'.$titlePrefix;
										
										//the above code creates something like:
										/*	for $tags[$i]['tagType'] = 'subject'
											$titlePrefix = 'Subject: ';
											$classSpecifier='tagSubject';
												
										*/
										// so while creating new tags, to style them, keep the $classSpecifier value in view	
										$HTML.= $classSpecifier. '" title="'.$titlePrefix.': '. ucwords($tags[$j]['tagName']) .'">'. $tags[$j]['tagAcronym'] .'</span>';
										$j++;
									}
				$HTML.= <<<__REG_DATA
								</div>	<!--end of circlesArea-->

								<div class="time-n-name" style="border-top:0px;"><!--parent-->
									<div class="repo" title="{$uploader}'s Reputation">
										<img src="images/repoMedal.png" alt="Reputation"/>{$uploaderRepo}
									</div>
									<div class="time-n-name">
										<span class="time">{$time}
										</span>
										<span class="uploaderName">
											<a 
__REG_DATA;
												if($uploaderProfileURL!="#")
												{	$HTML.= 'href="'. $uploaderProfileURL .'" ';
												}
				$HTML.= <<<__REG_DATA
								 			    >{$uploader}</a>

										</span><!--end of uploaderName-->
									</div>
								</div><!--end of time-n-repo (parent)-->
							</div>
						</div>
__REG_DATA;

				$HTML.='</row>';
			}
		}
	}
		
		
	// there are results.. time to show pagination ribbon
	unset($_GET['page']);
	$URL = $_SERVER['PHP_SELF'].'?'.http_build_query($_GET).'&';
	
	$HTML.= '<div id="sort" class="theme-gradient" style="padding:1%;">';
	$HTML.= genPagesListHTML(1, $pageMax, $URL);
	$HTML.= '</div>';
		
	return $HTML.'</div></div>';

}

?>
