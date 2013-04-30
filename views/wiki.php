<?php


function wiki()
{	
	$ProfileBoxHTML .= 	
		'<script>
			$(document).ready(function(){
				$("#NotificationBox").html("<ul>'. $params['msg'] .'</ul>");
				$("#NotificationBox").show();
			};
		</script>';

	$ProfileBoxHTML .=
		'<div class="contentBox" style="background-color:transparent;">
		<ul class="tabs-ul">
			<li id="howl" class="tab theme-gradient" linked="how">How To\'s</li>
			<li id="wikil" class="tab theme-gradient" linked="rules">Rules</li>
			<li id="whatl" class="tab theme-gradient" linked="what">What is CSBees</li>
			<li id="whyl" class="tab theme-gradient" linked="why">Why CSBees</li>
			<li id="whol" class="tab theme-gradient" linked="who">About Us</li>
			
		</ul>
		<div class="tab-content-holder">
			<div id="what" class="tab-content what-box">
				<div class="contentTitle announce">
					What is CSBees?
				</div>
				
				<div class="content">
					CSBees is a public driven and public moderated network which helps you share and store class notes online. 
					It suits students and professors as well. And its absolutely free!
					<br/><br/>
					<b>Public Driven</b> in the sense that, CSBees is run by community members. They can upload and share their notes,
					irrespective of their geography, nation, culture, college, teacher or any other sort of boundry.
					<br/><br/>
					<b>Public Moderated</b> because every authenticated member of CSBees have the rights to vote and raise voice over 
					any notes. This improves the quality of notes available.
					
					<br/><br/>
					Moreover, with CSBees, you can build an online collection of your notes, which is shared with the world, 
					and can be read and downloaded by anybody over the internet.
					
					<br/><br/>Notes in CSBees are your contrubution to the community. 
					
				</div>
				
				
			</div><!--end of what-box-->
			
			<div id="why" class="tab-content why-box">
				<div class="contentTitle announce">
					Why CSBees?
				</div>
				
				<div class="content">
					CSBees is the outcome of our degrading evaluation system, where we are asked to mug-up the syllabus and vomit it in our answer sheets!

					<br/><br/> What we have realised from our past experiences is that, is doesn\'t matter how good we are in understanding the subject and its practical applications,
					we are always evaluated on the basis of wether we have written the bookish definition in the answer!!

					<br/><br/>Mind you, <br/>
					<b>Best teachers dont teach you what to read, they tell you why to learn and how to learn.
					<br/>Best teachers just plant that seed of curiosity inside you which leads to revolutionary ideas.
					<br/>Best teachers do not tell you the answers, they tell you where to look for one.
					</b>
					<br/>But unfortunately, only a few live on this planet at any given time.
					
					<br/>and thankfully I have had the oppertunity to be guided by that very kind of social engineers :)
					<br/><br/>
					When we read from the class notes written and compiled by thousands of laborious students all over the world, we are actually 
					sharing the knowledge of those enightened few who have taken the pain and time to clear out the mess for us.
					<br/>
					
					<br/><br/>
					<b> So the idea is to learn the subject by our experiments and the ways we enjoy, and learn for the exams from the class notes given by the best teachers and transcribed by the students al over the world.
					 </b>
					 
					<br/><b>Notes save time and effort in preparing for traditional exams as well so that we can use this time to focus on practical aspects of the theory.
					</b>
					
					<br/>And with CSBees, the best part is, you do not need a school to learn!
					<br/>CSBees is a tool of community, and is always up to improve our habitat!
					
				</div>
				
			</div><!--end of why-box-->
			
			
			<div id="rules" class="tab-content wiki-box">
				<div class="contentTitle announce">
					Rules
				</div>
					<div id="uploadContainer">
						<ul>
							<li><b>Please read the legal details before using CSBEES <a href="http://csbees.neurals.in/usage.txt" style="color:#fff;">here</a></b></li>
							<br/>
							<li><b>Why do you see Ads on CSBEES? Well, we are \'not-yet-passed-out\' undergrads, and it takes a good amount to keep all your notes online all the time. We do need to pay the server host plus the domain host! We hope you understand and will help us raise the funds to keep CSBEES running  by clicking a few of those :-)</b>
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
							
							<li>Any act of hacking, unauthorised access or any such activity will be strictly and legally dealt with.
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
				
			</div><!--end of wiki-box-->
			
			
			
			
			
			<div id="who" class="tab-content about-box">
				<div class="contentTitle announce">
					CSBees Wiki
				</div>
				<div class="content">
					We are a group of passionate computer engineers, involved in <a style="color:rgb(36, 153, 219);" href="http://neurals.in">Neurals</a>.
					<br/>We have developed CSBees as a hobby project, and dedicated to the community.
					For any assistance, please contact us on:
						<br/><br/>
						<a style="color:rgb(36, 153, 219);" href="http://facebook.com/pkswatch" target="_blank">Prashant Dwivedi</a>: +91-8826319519<br/>
						<a style="color:rgb(36, 153, 219);" href="http://facebook.com/vd007" target="_blank">Navneet Dwivedi</a>:&nbsp; +91-7838737788<br/>
						Email: csbees@neurals.in
						
						<br/><br/>and yeah.. did we tell you, we love to hear from your side! :-)
				</div>
			</div><!--end of about-box-->
			
			<div id="how" class="tab-content how-box">
				<div class="contentTitle announce">
					How To\'s
				</div>
				<div class="content">
					How To\'s is still under construction, so the below information may not be complete.
					<ul>
						<li>
							<b>What are tags and how do I use it?</b>
							<br/>Tags are subjects, colleges, univesities, topics, etc which you associate your class notes with.
							<br/>Tags are the core elements of CSBees. These help you to associate your notes with many colleges and many topics at the same time with flexibility.
							<br/>To use tags with your notes, just type in a few words of your subject or college in New Upload, and the available options will popup in a box below. And you can choose as many tags as you like.
					
							<br/>The notes you upoad under a tag will immediately appear in the home page of all the people who have subscribed that tag (in their profile)<br/>
						</li>
						
						
						<li>
							<b>What is a user\'s reputation and how is it built?</b>
							<br/>In short, it reflects your contribution to CSBees. 
							<br/>You gain points when community upvotes your notes and repo is lost when community downvotes the notes you uploaded.
							<br/>And number of downloads of a note portrays its popularity in the community.
							
						</li>
					</ul>
				</div>
			</div>
		
		</div><!--end of tab-content-holder-->	

		</div>
	';

	return $ProfileBoxHTML;
}




?>