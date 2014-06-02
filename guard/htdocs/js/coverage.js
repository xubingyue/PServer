$(document).ready(function(event){
	$("#page_coverage").delegate(".CoverageRefreshBtn", "click", function(event){
		var proj = event.target.id;
		$.ajax({
			type:"POST",
			url:"/commit/coverage/refresh.php",	
			data: "project=" + proj,
			dataType : "json",
			success:function(ret){				
				if(ret.result)
				{
					$("#CoverageRefreshResult").css({color:"green"});
					$("#CoverageRefreshResult").text("刷新成功");
				}
				else
				{
					$("#CoverageRefreshResult").css({color:"red"});
					$("#CoverageRefreshResult").text(ret.error);
				}
			}
		});
	});
})

