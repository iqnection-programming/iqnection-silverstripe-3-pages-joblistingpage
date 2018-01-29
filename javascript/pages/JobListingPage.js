(function($){
	"use strict";
	function filterJobs()
	{
		var str = $("#job-search-filter").val();
		var cat = $("#job-search-category").val();
		
		$(".job-row").show();
		
		if (str.length || cat > 0){
			$(".job-row").each(function(){
				
				var str_match = false;
				var cat_match = false;
				
				if (str.length){			
					$(this).children("td").not(".details").children("a").each(function(){
						if ($(this).html().toUpperCase().indexOf(str.toUpperCase()) !== -1) str_match = true;
					});
				}else{
					str_match = true;
				}
				
				if (cat > 0){
					if ($(this).attr("rel") == cat) cat_match = true;
				}else{
					cat_match = true;
				}
				
				if (!str_match || !cat_match) {
					$(this).hide();
				}
			});
		}
	}

	$(document).ready(function(){
		
		$("#job_list").tablesorter();
		
		$("#job-search-filter").keyup(function(){
			filterJobs();
		});
		
		$("#job-search-category").change(function(){
			filterJobs();
		});
		
		$("#job_list td").hover(function(){
			$(this).parent().children("td").addClass("hover");
		}, function(){
			$(this).parent().children("td").removeClass("hover");
		});
	});
	
}(jQuery));