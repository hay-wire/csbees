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

//		 csbees/ajaxRequests/returnsSubjects.php
//		============================================


//	SECURITY CHECKS	
require_once('../includes.php');

//retrieve the user
$authMan = new AuthManager();


//ENSURE USER IS LOGGED IN
//$authMan->restrictedPage('login.php');


$csbeesMan = new CSBeesManager();

if(isset($_GET['q']))
{	$tagsStr = cleanString($_GET['q']);
	$tagsArray = $csbeesMan->getAllTags($tagsStr);
	//echo '<br/>Sizeof array = '.sizeof($tagsArray).'<br/>';
	//print_r($tagsArray);
	//echo '<br/><br/><br/>';
	
	$encodeableArray = array();
	$json_output;
	if(!empty($tagsArray))
	{	//$tagsArray = $result;
		//$tagAcronymArray = $result['tagAcronym'];
		
		for($i=0; $i<sizeof($tagsArray); $i++)
		{	$encodeableArray['id'] = $tagsArray[$i]['tagId'];
			$encodeableArray['name'] = $tagsArray[$i]['tagName'];
			$encodeableArray['type'] = $tagsArray[$i]['tagType'];
			
			$json_output .= json_encode($encodeableArray);
		
			//if it is not the last row of database result, append a comma, else just continue to break the loop
			if($i!=sizeof($tagsArray)-1)
			{	$json_output .= ', ';
			}
			else
			{	continue;
			}
		}
	}
	

	echo '[ '. $json_output . ']';	
}




?>
