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
//		======================


//	SECURITY CHECKS	
require_once('../includes.php');

//retrieve the user
$authMan = new AuthManager();


//ENSURE USER IS LOGGED IN
//$authMan->restrictedPage('login.php');


$csbeesMan = new CSBeesManager();

if(isset($_GET['q']))
{	$subjectStr = cleanString($_GET['q']);
	$result = $csbeesMan->getAllSubjects($subjectStr);
	//echo '<br/>queried for '.$_GET['q'].'<br/>$subjectStr= '.$subjectStr.'<br/><br/>result = ';
	//print_r($result);
	//echo '<br/><br/><br/>';
	//var_dump($result);
	
	$encodeableArray = array();
	$json_output;
	if(!empty($result))
	{	$sidArray = $result['sid'];
		$subjectArray = $result['subject'];
		
		for($i=0; $i<sizeof($sidArray); $i++)
		{	$encodeableArray['id'] = $sidArray[$i];
			$encodeableArray['name'] = $subjectArray[$i];
			$json_output .= json_encode($encodeableArray);
		
			//if it is not the last row of database result, append a comma, else just continue to break the loop
			if($i!=sizeof($sidArray)-1)
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