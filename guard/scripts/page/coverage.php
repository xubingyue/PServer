<?php
	function page_coverage()
	{
?>
	<div id = "page_coverage">
		<div style = "width:100%">
			<div style = "float:left">
				<a href = "/coverage/scened/index.html">Scened代码覆盖率</a>
			</div>
			<div style = "float:right">
				<div class = "Btn" style = "float:right">
					<div class = "CoverageGenerateBtn" id = "scened">生成</div>
				</div>
				<div class = "Btn" style = "float:right">
					<div class = "CoverageResetBtn" id = "scened">重置</div>
				</div>
				<div class = "CoverageResult" id = "scened" style = "float:right"></div>
			</div>
		</div>
	</div>
<?php
	}
?>
