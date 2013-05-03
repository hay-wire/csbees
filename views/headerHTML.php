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


function headerHTML($params)
{	$__BASE_URL = __BASE_URL;

	$HEADERhtml = <<<__HEADER1
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="en">
		<head>
		<title>CSBEES - {$params['title']}</title>
		<meta charset="utf-8">
		<meta property="fb:app_id" content="304223549689012" />
		<META NAME="Description" CONTENT="Share your handwritten college notes online for free, get rated and spread education! Download from thousands of quality write-ups across the globe on your topic, anytime, from anywhere!! Moreover, it also helps you to buid a a free online backup of your notes!!!">
		
		
		<!-- all the links to be included go here -->		
			<link rel="shortcut icon" href="{$__BASE_URL}/images/favicon.png" type="image/x-icon" />
			<link rel="stylesheet" href="{$__BASE_URL}/css/style.css" type="text/css" media="screen">
			<link rel="stylesheet" href="{$__BASE_URL}/css/downloadsList.css" type="text/css" media="screen">
			<link rel="stylesheet" href="{$__BASE_URL}/css/pagination.css" type="text/css" media="screen">
			<link rel="stylesheet" href="{$__BASE_URL}/css/sidebar.css" type="text/css" media="screen">
			<link rel="stylesheet" href="{$__BASE_URL}/css/tabs.css" type="text/css" media="screen">
			<!--script type="text/javascript" src="{$__BASE_URL}/js/jquery-1.9.0.min.js"></script-->
			<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
				<!--script type="text/javascript" src="{$__BASE_URL}/js/jquery.prettydate.js"></script-->
				<script type="text/javascript" src="{$__BASE_URL}/plugins/token-input/jquery.tokeninput.js"></script>
				<link rel="stylesheet" href="{$__BASE_URL}/plugins/token-input/token-input.css" type="text/css" />
				<link rel="stylesheet" href="{$__BASE_URL}/plugins/token-input/token-input-facebook.css" type="text/css" />
			{$params['includedHeadLinks']}

		<!---------------- ajaxRequests---------------------->
		<script type="text/javascript" src="{$__BASE_URL}/ajaxRequests/ajaxVoteup.js"></script>
		<script type="text/javascript" src="{$__BASE_URL}/ajaxRequests/searchNotes.js"></script>
		<script type="text/javascript" src="{$__BASE_URL}/ajaxRequests/ajaxTagsCreator.js"></script>

		
		<!------------------- prashant's implementation -------------------------------->

		<script type="text/javascript" src="{$__BASE_URL}/js/tabs.js"></script>
		<script type="text/javascript" src="{$__BASE_URL}/js/timeinterval.js"></script>

		<script type="text/javascript">
/*		
			function dump(obj) {
			    var out = '';
			    for (var i in obj) {
				out += i + ": " + obj[i] + "\n";
			    }

			    alert(out);

			    // or, if you wanted to avoid alerts...

			    var pre = document.createElement('pre');
			    pre.innerHTML = out;
			    document.body.appendChild(pre)
			}
*/			
			// for go back button
			function goBack()
			{	window.history.back()
			}

			// for pretty dates printing (plugin)
			jQuery( function() { 
				//$(".time-n-name .time").html("hello");
				$(".time-n-name .time").each( function() {
					//$(this).html("pk");
					var time2 = $(this).attr("title");
					//console.log("time2="+time2);
					$(this).html(easydate(time2));
				});
				//console.log("i - "+dump(i));
			});
		</script>



		<!-- end of links to be included go here -->

		<!-- cool open id auth for myself B-) ( go and get your own!:-P :-) :-->
			<link rel="openid2.provider" href="https://openid.stackexchange.com/openid/provider">
			<link rel="openid2.local_id" href="https://openid.stackexchange.com/user/44c239e7-d613-4f03-8559-8f8af5fd5bec"> 
		<!-- end of open id auth -->
		
		
		<!-- google analytics code for neurals.in-->
			<script type="text/javascript">
			
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-31815802-2']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = HTML= ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			
			</script>
		<!-- end of google analytics code for neurals.in-->
		



		</head>
		
		
		<body style="margin:0;">
		
		
			
			
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=304223549689012";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			
			<!--done intialising fb -->
			
			
			<div id="menu" class="theme-gradient">
				<div id="menu-navigator">

__HEADER1;
			if($params['isloggedIn'] == TRUE)
			{	$HEADERhtml .= '<a href="'. $params['logoutURL'] .'">LOGOUT</a>';
			}
			else
			{	$HEADERhtml .= '<a href="'. $params['loginURL'] .'">fb.LOGIN</a>';
			}
	$HEADERhtml .= '
				<a href="http://neurals.in">NEURALS</a>
				<a href="https://www.facebook.com/groups/csbees.neurals.in/" target="_blank">FORUM</a>
				<a href="'. __WIKI_PAGE_URL .'">HELP</a>
				<a href="'. __INDEX_PAGE_URL .'">CSBEES</a> 
   			    </div>
			</div> 
			
			<!-- for facebook facepile -->
			<!--div style="display:hidden; width:0; height: 0;">
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js
#appId=304223549689012&amp;xfbml=1"></script><fb:facepile></fb:facepile>
			
			</div-->
				
			<div id="table_container">
				<div id="personal-navigation" class="theme-gradient">
							<div id="nav-links">
								<font style="font-size:110%; color:#81c1da; font-weight: bold; ">Hello '. $params['userfullname'] .'!</font>
			';
			
				
				
				if($params['isloggedIn'] == TRUE)
				{	$HEADERhtml .= '	<a '. (($_GET[__PAGE_VIEW_KEYWORD] == __HOME_PAGE_KEYWORD) ? 'class="activePage"' : null ) .' href="'. __HOME_PAGE_URL .'">Home</a>
								<a '. (($_GET[__PAGE_VIEW_KEYWORD] == __UPLOAD_PAGE_KEYWORD) ? 'class="activePage"' : null ) .' href="'. __UPLOAD_PAGE_URL .'">Upload Notes</a>
								<a '. (($_GET[__PAGE_VIEW_KEYWORD] == __MY_UPLOADS_PAGE_KEYWORD) ? 'class="activePage"' : null ) .' href="'. __MY_UPLOADS_PAGE_URL .'">My Uploads</a>
								<a '. (empty($_GET[__PAGE_VIEW_KEYWORD]) ? 'class="activePage"' : null ) .' href="'. __INDEX_PAGE_URL .'">All Notes</a>
								<a '. (($_GET[__PAGE_VIEW_KEYWORD] == __PROFILE_PAGE_KEYWORD) ? 'class="activePage"' : null ) .' href="'. __PROFILE_PAGE_URL .'">Profile</a>
							';
							
				}
				else
				{	$HEADERhtml .= '<a href="'. $params['loginURL'] .'">fb.Login</a> before you upload!';
				}

	$HEADERhtml .= <<<__HEADER3
							</div>	
						<!--for google+1 -->
							<!-- Place this tag where you want the +1 button to render. -->
							<div class="socialButton">
								<div class="g-plusone" data-href="http://csbees.neurals.in" ></div>
							</div>
							<!-- Place this tag after the last +1 button tag. -->
							<script type="text/javascript">
							  (function() {
							    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							    po.src = 'https://apis.google.com/js/plusone.js';
							    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
						<!--done google+1 -->
						
						
						<!--now for twitter -->
							<div class="socialButton" style="width:8%; margin-top:4px;">
								<a href="https://twitter.com/Neuralsindia" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @Neuralsindia</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
						<!--done for twitter -->

						<!--now for fb -->
							<div class="socialButton" style="margin-top:4px;">
								<div class="fb-like" data-href="http://csbees.neurals.in" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false" data-font="verdana"></div>
							</div>
						<!--done fb -->

						<div id="messages">
__HEADER3;
						if(!empty($params['msg']))
							$HEADERhtml .= '<ul>'.$params['msg'].'</ul>';
						
				$HEADERhtml .=<<<__HEADER4

						</div>
						
					</div>	<!--end of personal navigation division-->
											
				
				<div class="clear50"></div>
				<div id="NotificationBox" class="click-dismiss" ></div>
__HEADER4;

return $HEADERhtml;

}


?>