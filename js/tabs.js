//simple tabs implementation by prashant dwivedi "prashant@neurals.in"

jQuery(function() {
	//window.location.hash;
	var firstLi = $(".tab:first-child");			//the first shown division
	var firstDiv = "#"+$(firstLi).attr('linked');
	var hashTarget = window.location.hash.replace("#", "");	//div id to be shown from url
	
	
	$(firstLi).siblings().each( function() {
		if($(this).attr("linked") == hashTarget)
		{	firstLi = this;
		}
	});
	$(firstLi).addClass("activeTab");
		
	//if target id is set in url, and that id exists in our list of valid tabs, mark it as firstDiv
	$(firstDiv).siblings().each( function () {
		$(this).hide();
		if(hashTarget == this.id)
		{	$(firstDiv).hide();
			$(firstDiv).removeClass('activeTab');
			firstDiv = this;
		}
	});
	// now display the division which has been determined as best
	//$(firstDiv).addClass('activeTab');
	$(firstDiv).show("slow", "swing");
	
	$("li.tab").click( function(){
		//hide all the siblings of this li
		var currentTab = this;
		$(currentTab).siblings('li').each( 
		function() {
			var other = "#"+$(this).attr('linked');
			$(other).hide("slow", "swing");
			$(this).removeClass('activeTab');
			
		});
		var linkedDiv = "#"+$(this).attr('linked');
		$(this).addClass('activeTab');
		$(linkedDiv).show("slow", "swing");
	
	})

});

