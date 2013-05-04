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

function error()
{	$HTML = '
	<div class="contentBox">
		<div  class="theme-gradient" style="min-height: 35px; border-radius:3px;">
				<h1>Error!!!</h1>
		</div>		
	
		<row class="downloadableNote">	
			

			<div class="noteDetails">
				<div class="title">
					<span class="topic">OOPS! There appears to have some error occured! </span>
				</div>
				<div class="desc">
					The resource you requested could not be located.<br/>
					It has either been removed or the url you typed is incorrect.
				</div>
			</div>
		</row>
	</div>';
	
	return $HTML;
}

?>
