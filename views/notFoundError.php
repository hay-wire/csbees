<?php

function notFoundError()
{	$HTML = '
	<div class="contentBox">
		<div  class="theme-gradient" style="min-height: 35px; border-radius:3px;">
				<h1>Error!</h1>
		</div>		
	
		<row class="downloadableNote">	
			<div class="noteDetails">
				<div class="title">
					<span class="topic">OOPS! There appears to have some error occured! </span>
				</div>
				<div class="desc">
					Your request could not be completed. The possible reasons are:
					<ul>
						<li>The resource has either been removed  or relocated.</li>
						<li>the url you requested is incorrect.</li>
					</ul>
					Please try again if you think its a mistake or contact us for further support.
				</div>
			</div>
		</row>
	</div>';
	
	return $HTML;
}

?>
