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

function sideBar($params)
{	//var_dump($params);
	
	if(empty($params['notif']['heading']))
	{	$params['notif']['heading'] = 'Hey There!';
		$params['notif']['content'] = '<strong>CSBEES</strong> is a public driven and public moderated website which helps you share and store class notes online. It suits students and profs as well.
						<br/>And its absolutely free!';
	
	}


	$HTML .=<<<__HTM
	
			<div id="sidebar">
__HTM;
				
			if($params['newTagsBox'] == TRUE)
			{	$HTML .=<<<__HTM
			
				<div class="noticeBox announce" id="newTagTrigger" style="cursor:pointer; background-color:#009FEB; color:white;">
					<heading style="color:white;">Need a New Tag?</heading>
					<content>Click here to create a new tag for your notes.</content>
				</div>
__HTM;
			}


	$HTML .=<<<__HTM
				
				<div class="noticeBox announce">
					<heading>{$params['notif']['heading']}</heading>
					<content>{$params['notif']['content']}</content>
				</div>
				
				<div class="noticeBox announce" style="background:white; overflow:hidden;">
					<a href="http://internetdefenseleague.org">
						<img src="http://internetdefenseleague.org/images/badges/final/shield_badge.png" alt="Member of The Internet Defense League" style="width: 100%;">
					</a>
				</div>
				
				<!--div class="noticeBox announce" style="background:white; overflow:hidden;">
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-1125581531341968";
					/* Sidebar Square */
					google_ad_slot = "7788889578";
					google_ad_width = 250;
					google_ad_height = 250;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div-->	
	
				
				<div class="noticeBox">
					<heading>Newest Tags</heading>
					<content>
__HTM;


					$i=0;
					
					while( $i < sizeof($params['tagsList']['tags']) )
					{	$HTML.= '<span class="noteCircle ';
						$titlePrefix = ucwords($params['tagsList']['tags'][$i]['type']);
						$classSpecifier = 'tag'.$titlePrefix;
						
						//the above code creates something like:
						/*	for $tags[$i]['tagType'] = 'subject'
							$titlePrefix = 'Subject: ';
							$classSpecifier='tagSubject';
								
						*/
						// so while creating new tags, to style them, keep the $classSpecifier value in view	
						$HTML.= $classSpecifier. '" title="'.$titlePrefix.': '. ucwords($params['tagsList']['tags'][$i]['name']) .'">'. $params['tagsList']['tags'][$i]['acronym'] .'</span>';
						$i++;
					}
			$HTML.= <<<__HTM
					</content>
				</div>
				
				
				
				
				
			</div>

__HTM;

	return $HTML;

}

?>