
$(document).ready(function(){
	$(".searchInput").focus(function() {
		
		$(".searchInput").animate({width:'+=20%'}, 'slow', 'swing');
	});
	
	$(".searchInput").blur(function() {
		
		$(".searchInput").animate({width:'-=20%'}, 'slow', 'swing');
		
		
		
		
	/*	$(".searchInput").keyup( function() {
			var searchStr = $(".searchInput").val();
			if(searchStr!="") {
				$.ajax({
					type: "GET",
					cache: false,
					url: "ajaxRequests/searchNotesHandler.php",
					data: {	search: searchStr },
					
					error:function(response, status, xhr) {
					 		$("#NotificationBox").html('Oops! Error: "'+xhr+'" occured while searching. Please try again');
							$("#NotificationBox").css("visibility", "visible");
					 	},
					success: function(response, status, xhr) {
							var JSONObj = jQuery.parseJSON(response);
							var msg = JSONObj.msg;
							var error = JSONObj.error;
							if(error==false) {
								$("#NotificationBox").html(msg);
								$("#NotificationBox").css("visibility", "visible");
								
							}
				    			console.log(response);
					 
						}
				})			 
			} 
		}).keyup();
	*/
	})
});

