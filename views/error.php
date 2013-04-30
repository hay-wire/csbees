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
