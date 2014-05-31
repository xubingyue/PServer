$(document).ready(function(event){
		$("#page_setup").delegate(".uploadBtn", "click", function(event){
			$("#setup_result").css({color:"#FFCC00"});
			$("#setup_result").text("上传中......");

			$.ajaxFileUpload(
			{
				url:'/commit/setup/upload.php',
				secureuri:false,
				fileElementId:'setup_file',
				dataType: 'json',
				timeout:600000,
				success: function (ret, status)
				{
					if(ret.result)
					{
						$("#setup_result").css({color:"green"});
						$("#setup_result").text("上传成功!");
					}
					else
					{
						$("#setup_result").css({color:"red"});
						$("#setup_result").text("上传失败!" + ret.error);
					}
				},
				error: function (ret, status, e)
				{
					$("#setup_result").css({color:"red"});
					$("#setup_result").text("上传失败!");
				}
			});
	});
})

