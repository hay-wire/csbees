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

//	/csbees/help.php
//	=================

//	SECURITY CHECKS	
require_once('includes.php');

//retrieve the user
$authMan = new AuthManager();



/*************************************************************************************************************************/
/*************************************************************************************************************************/
/********************************************    GENERATE HEADER   *******************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/


$HTMLheaderParams = array (
			'isloggedIn'		=>	$authMan->socialuser->isloggedIn(),
			'title'			=>	'Help Page',
			'includedHeadLinks'	=>	NULL,
			'userfullname'		=>	$authMan->socialuser->getName(),
			'logoutURL'		=>	$authMan->socialuser->getlogoutURL(),
			'loginURL'		=>	$authMan->socialuser->getfbloginURL()
			);
			
echo loadView('generateHeader', $HTMLheaderParams);



?>

<br/><br/>
	<div id="uploadContainer">
		<h1>We Support an Open World!</h1>
		<ul>
			<li><b>Please read the legal details before using CSBEES <a href="http://csbees.neurals.in/usage.txt" style="color:#fff;">here</a></b></li>
			<br/>
			<li><b>Why do you see Ads on CSBEES? Well, we are 'not-yet-passed-out' undergrads, and it takes a good amount to keep all your notes online all the time. We do need to pay the server host plus the domain host! We hope you understand and will help us raise the funds to keep CSBEES running  by clicking a few of those :-)</b>
			</li>

			<li style="margin-top:10px;">If there are more than 1 files (images/.ppt/.doc etc) under the same topic, zip them in a single folder and then upload.
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
					<li>Zipped Files (zip/tar/rar)</li>
					<li>PDF Files (pdf)</li>
					<li>Word Documents (doc/docx/odf)</li>
					<li>Presentation Documents (ppt/pptx)</li>
				</ul>
			</li>
			<li><b>Maximum allowable filesize is 30 MB (Megabytes)</b></li>
			
			
			<li>If you find any disputable or unauthorised file here, please make sure to inform us so that it may be removed! We respect your intellectual property.
		</ul>
	</div>
	
	<div id="uploadContainer">
	
		For any assistance, please contact us on:
		<br/><br/>
		<a style="color:#fff;" href="http://facebook.com/pkswatch" target="_blank">Prashant Dwivedi</a>: +91-8826319519<br/>
		<a style="color:#fff;" href="http://facebook.com/vd007" target="_blank">Navneet Dwivedi</a>:&nbsp; +91-7838737788<br/>
		Email: csbees@neurals.in
		
		<br/><br/>and yeah.. did we tell you, we love to hear from your side! :-)
	</div>
	
	
<?php	

/*************************************************************************************************/
/*********************Go home shaun.. i want to click an ad***************************************/
/*************************************************************************************************/

echo loadView('adsBox');

echo '</body></html>';


?>
