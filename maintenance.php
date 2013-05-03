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


//		 csbees/Maintenance-Page.php
//		=============================


//	SECURITY CHECKS	
require_once('includes.php');

//retrieve the user
$authMan = new AuthManager();


//ENSURE USER IS LOGGED IN
//$authMan->restrictedPage('login.php');





/*************************************************************************************************************************/
/*************************************************************************************************************************/
/********************************************    GENERATE HEADER   *******************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/


$HTMLheaderParams = array (
			'isloggedIn'		=>	$authMan->socialuser->isloggedIn(),
			'title'			=>	'Under Maintenance',
			'includedHeadLinks'	=>	NULL,
			'userfullname'		=>	$authMan->socialuser->getName(),
			'logoutURL'		=>	'#',//$authMan->socialuser->getlogoutURL(),
			'loginURL'		=>	'#',//$authMan->socialuser->getfbloginURL()
			);
			
echo loadView('generateHeader', $HTMLheaderParams);		
//echo generateHeader($HTMLheaderParams);

?>

<div id="table_container">
	<div id="uploadContainer">
		<h1>Under Upgradation</h1>
		Sorry For the inconvenience.. We are upgrading.. Will be back real soon with lots of new features!
		<br/>And ya! Thanks for ur support :)		
	</div>
	<div id="uploadContainer">
		<h1>We Support Open Education</h1>
		<ul>
			<li>If there are more than 1 files (images/.ppt/.doc etc) under the same topic, zip them in a single folder and then upload.
			</li>
			
			<li>Upload Your files using the New Uploads Dialogue Box on home page.
			</li>
			
			<li>Be precise in giving the topic name. It should give a hint of what topics are covered in the file.
			</li>
			
			<li>Keep the names of the files such that they reflect the content of the files.
			</li>
			
			<li>Here at CSBEES, we only support you to share "your" notes and other such educational stuffs. Files you are uploading should benefit others in their eduation.
			</li>
			
			<li>You are yourself responsible for the content you are uploading.
			</li>
			
			<li>Any act of hacking, unauthorised access or any such activity will be strictly dealt with.
			</li>
			
			<li>Currently allowed file formats:
				<ul>
					<li>Images (jpg/png/gif)</li>
					<li>Plain text (txt/rtf)</li>
					<li>Zipped Files (zip/tar)</li>
					<li>PDF Files (pdf)</li>
					<li>Word Documents (doc/docx/odf)</li>
					<li>Presentation Documents (ppt/pptx)</li>
				</ul>
			</li>
			<li>Maximum allowable filesize is 30 MB (Megabytes)</li>
			
			
		</ul>
	</div>
	
	<div style="background-color:#014D6B; font-weight:bold; font-size:110%; color:white; margin-top:30px; padding:5px;">
	
		For any assistance, please contact us on:
		<br/><br/>
		<a style="color:#fff;" href="http://facebook.com/pkswatch" target="_blank">Prashant Dwivedi</a>: +91-8826319519<br/>
		<a style="color:#fff;" href="http://facebook.com/vd007" target="_blank">Navneet Dwivedi</a>:&nbsp; +91-7838737788<br/>
		Email: csbees@neurals.in
	</div>
	
