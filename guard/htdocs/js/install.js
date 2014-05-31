$(document).ready(function(event){
		$("#page_install").delegate(".uploadBtn", "click", function(event){
			if($("#install_file").val() != "")
			{
				$("#install_result").css({color:"#FFCC00"});
				$("#install_result").text("上传中......");

				$.ajaxFileUpload(
				{
					type:'POST',
					url:'/commit/install/upload.php',
					secureuri:false,
					fileElementId:'install_file',
					dataType: 'json',
					timeout:600000,
					success: function (ret, status)
					{
						if(ret.result)
						{
							$("#install_result").css({color:"green"});
							$("#install_result").text("上传成功!");
						}
						else
						{
							$("#install_result").css({color:"red"});
							$("#install_result").text("上传失败:" + ret.error);
						}
					},
					error: function (ret, status, e)
					{
						$("#install_result").css({color:"red"});
						$("#install_result").text("上传失败!");
					}
				});
			}
			else
			{
				$("#install_result").css({color:"red"});
				$("#install_result").text("请选择安装包");
			}
		});
})

