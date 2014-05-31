<?php
	function page_setup()
	{
?>
	<div id = "page_setup">
		<form method="post" enctype="multipart/form-data">  
			<input type = "file" id = "setup_file" name = "setup_file" style = "float:left"/>
			<div style = "float:right">
				<div id = "setup_result" name = "setup_result" class = "setup_result" ></div>
				<div class = "Btn" style = "float:right">
					<div class = "uploadBtn">上传</div>
				</div>
			</div>
		</form>
	</div>
<?php
	}
?>

