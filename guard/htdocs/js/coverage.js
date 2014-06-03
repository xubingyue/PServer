$(document).ready(function(event){
	$("#page_coverage").delegate(".CoverageGenerateBtn", "click", function(event){
		var proj = event.target.id;
		$.ajax({
			type:"POST",
			url:"/commit/coverage/generate.php",	
			data: "project=" + proj,
			dataType : "json",
			success:function(ret){				
				if(ret.result)
				{
					$(".CoverageResult").css({color:"green"});
					$(".CoverageResult").text("生成html成功");
				}
				else
				{
					$(".CoverageResult").css({color:"red"});
					$(".CoverageResult").text(ret.error);
				}
			}
		});
	});

	$("#page_coverage").delegate(".CoverageResetBtn", "click", function(event){
		var proj = event.target.id;
		$.ajax({
			type:"POST",
			url:"/commit/coverage/reset.php",	
			data: "project=" + proj,
			dataType : "json",
			success:function(ret){				
				if(ret.result)
				{
					$(".CoverageResult").css({color:"green"});
					$(".CoverageResult").text("重置成功");
				}
				else
				{
					$(".CoverageResult").css({color:"red"});
					$(".CoverageResult").text(ret.error);
				}
			}
		});
	});
})

