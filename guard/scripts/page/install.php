<?php
	function page_install()
	{
?>
	<div id = "page_install">
		<div class = "install_info">
			<form method="post" enctype="multipart/form-data" >  
				<table>
					<tr>
						<td class = "tdleft">安装路径:</td>
						<td class = "tdright"><input type = "text" value = "<?php echo PUBLISH_DIR; ?>" id = "install_publish_dir" class = "right_text" disabled="true"/></td>
					</tr>
					<tr>
						<td class = "tdleft">安装文件:</td>
						<td class = "tdright"><input type = "file" id = "install_file" name = "install_file" accept=".gz" class = "right_text"/></td>
					</tr>
				</table>
			</form>
		</div>

		<div class = "install_control">
			<div class = "Btn">
				<div class = "uploadBtn">安装</div>
			</div>
			<div id = "install_result" name = "install_result" class = "install_result" ></div>
		</div>
	</div>
<?php
	}
?>

