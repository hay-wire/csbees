$(document).ready(function(){
	$(".vote.vote-up-down").click(function() {
			
			$("#NotificationBox").html('');
			$("#NotificationBox").css("visibility", "hidden");
			var noteId = $(this).attr('fileId');
			var voteNature = $(this).attr('id');
			var oppVoteNatureDiv = "";
			switch(voteNature)
			{	case 'VoteUp':	oppVoteNatureDiv = 'VoteDown';
						break;
				case 'VoteDown':oppVoteNatureDiv = 'VoteUp';
						break;
			}


			$.ajax({
			  type: "GET",
			  cache: false,
			  url: "ajaxRequests/voteHandler.php",
			  data: {	voteType: voteNature, 
			  		fileid: noteId
			 	},
			  success: function(response, status, xhr){
			    
			    var JSONObj = jQuery.parseJSON(response);
			    var msg = JSONObj.msg;
			    var error = JSONObj.error;
			    if(msg.length>0)
			    {	    $("#NotificationBox").html(msg);
			    	    $("#NotificationBox").css("visibility", "visible");
			    	    if(error != false) // error
			    	    {	$("#NotificationBox").css("background-color", "#FD5757");	//pink
			    	    	//$("#NotificationBox").css("color", "white");
			    	    }
			    	    else	// no error
			    	    {    $("#NotificationBox").css("background-color", "#00C7D8");	// deep blue
				    	 //$("#NotificationBox").css("color", "white");
				    }
			    }
			    if(JSONObj.votes!="X")	//if the vote isn't faulty, display it
			    {  	    $("#VotesCount").html(JSONObj.votes);
    			    	    $('#VotesCount').css('background-color', '#009400');
    			    	    $('#VotesCount').css('color', 'white');
    			    	    var selectedImageId = "#"+voteNature+' img';
				    var unselectedImageId = "#"+oppVoteNatureDiv+' img';
    			    	    $(selectedImageId).css('opacity', '1');
    			    	    $(unselectedImageId).css('opacity', '0.2');
    			    	    console.log('selected image id='+selectedImageId);
    			    	    
			    }
			    	//console.log("\t error: "+error.length);
			    	//console.log("\t votes: "+JSONObj.votes);
			     // $("#VotesCount").html(response);
			      //alert('voila!'+response);
			      console.log("pkstatus: "+xhr.status+"\t response: "+response);
			    
			  },
			  error: function() {
			    alert('error occured');
			  }
			});
			
		})
	});



//hide on click boxes
$(document).ready(function(){
	$(".click-dismiss").click(function() {
		$(this).css("visibility", "hidden");
	    	$("#NotificationBox").css("background-color", "#FF5C00");
		$("#NotificationBox").css("color", "white");
	})
});

