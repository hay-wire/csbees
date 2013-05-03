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

//	Commons.php
//================================

require_once('includes.php');


function DropDownGenerator($idArray, $valueArray, $selectedRHS, $selectedLHS=null)
{	if(!$selectedRHS)
	{	$selectedLSH = $idArray[0];
	}
	for($i=0; $i<sizeof($idArray); $i++)
	{	$id = $idArray[$i];
		$value = $valueArray[$i];
		$dropDownHTML .= '<option value="'. $id .'" '. (($id==$selectedRHS)? 'selected="selected"': null) .'>'. $value .'</option>
				';
	}
	return $dropDownHTML;
}

/*
function AdsBox1()
{	return  '
		<div id="google-ad" style="width:730px; margin-left:auto; margin-right:auto; margin-top:50px;">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-1125581531341968";
			// banner bottom 
			google_ad_slot = "7048255420";
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
				
		</div>
		';

}

*/


?>
