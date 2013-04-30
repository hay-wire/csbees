$(document).ready(function(){
	
	$("#newTagArea").hide();
	$("#newTagTrigger").click(function() {
			$("#uploader").hide();
			$("#newTagArea").show();
			$("#similarTagsHolder").hide();
			console.log('clicked create new tag');
			
		});
		
	$("#closeTagCreator").click( function() {
			$("#newTagArea").hide();
			$("#uploader").show();
		});

	$("#createNewTag").click(function() {
		    	

			var newTagName = $('[name="newTagFullName"]').val();
			var newTagAcronym = $('[name="newTagShortName"]').val();
			var newTagType = $('[name="newTagCategory"]').val();

			
			console.log("sending details: "+newTagName+" "+newTagAcronym+" "+newTagType);

			$.ajax({
			  type: "GET",
			  cache: false,
			  url: "ajaxRequests/newTagsHandler.php",
			  data: {	tagName: newTagName, 
			  		tagAcronym: newTagAcronym,
			  		tagType: newTagType
			 	},
			 	
			 	
			 beforeSend: function(){
			    // $('#createNewTag').off('click');
			     $('#createNewTag').html('<img src="images/buttons/requesting.gif" style="width:14%;" alt="Please Wait" title="Creating New Tag. Please Wait." />');
			     
			     console.log('disabled sending more data');
			     $("#similarTags").html('');	
			     $("#similarTagsHolder").hide();	
			     
			   },
			 complete: function(){
			     //$('#createNewTag').on('click');
			     $('#createNewTag').html('Create Tag');
			   },
			 	
			 	
			  success: function(response, status, xhr){
			    
			    var JSONObj = jQuery.parseJSON(response);
			    var msg = JSONObj.msg;
			    var error = JSONObj.error;
			    
			    if(msg != -1)
			    {	    $("#NotificationBox").html(msg);
			    	    $("#NotificationBox").css("visibility", "visible");
			    	    if(error != false) // error
			    	    {	$("#NotificationBox").css("background-color", "#FD5757");	//pink
			    	    	//$("#NotificationBox").css("color", "white");
			    	    }
			    	    else	// no error
			    	    {    $("#NotificationBox").css("background-color", "#00C7D8");	// deep blue
				    	 //$("#NotificationBox").css("color", "white");
				    	 
				    	 //empty the field values
				    	 $('[name="newTagFullName"]').val('');
				    	 $('[name="newTagShortName"]').val('');
				    	 
				    }
			    }
			    if(JSONObj.data && JSONObj.data.error )	//if the data isnt faulty, display it
			    {  	    var i;
			    	    for(i=0; i<JSONObj.data.tag.length; i++)
			    	    {	t = JSONObj.data.tag[i];
			    	    	var string = '<span class="noteCircle tag'+t.type+'" title="'+t.type+': '+t.name+'">'+t.acronym+'</span>';
			    	    	$("#similarTags").html(string);
			    	    	$("#similarTagsHolder").show();			    	    
			    	    }
			    }
			   	// $('#createNewTag').html('Create Tag');
			    	//console.log("\t error: "+error.length);
			    	//console.log("\t votes: "+JSONObj.votes);
			     	// $("#VotesCount").html(response);
			      	//alert('voila!'+response);
			     
			   	// $('#createNewTag').on('click', function() { console.log('enabled sending more data');});
			  },
			  error: function() {
			    $("#NotificationBox").html('A network error occured while adding new tag.');
			    $("#NotificationBox").css("visibility", "visible");
			    $("#NotificationBox").css("background-color", "#FD5757");	//pink
			   // $('#createNewTag').on('click');
			   //$('#createNewTag').html('Create Tag');
			  }
			});

		});
			
});