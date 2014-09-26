<style type="text/css">
::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

h6 {
	color: red;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: bold;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

#error_container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
	<div id="error_container" style="background-color: #f0f0f0;">
		<h6><i class="fa fa-warning"></i>&nbsp;&nbsp;<?php echo $heading; ?></h6>
<?php
	if( is_array($message) ) {
		echo "<p>\n";
		foreach($message as $msg) {
			echo $msg."</br>";
		}
		echo "</p>";
	} else {
		echo "<p>".$message."</p>";
	}
?>
	</div>
	<p align="center"><a href="<?php echo base_url()?>">Voltar</a></div>
