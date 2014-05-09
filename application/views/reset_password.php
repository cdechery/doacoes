<style type="text/css">
.error {
	color: red;
	font-weight:bold;
}
.success {
	color: blue;
	font-weight:bold;
}
.form {
	color: black;
}
</style>
</head>
<div style="text-align: middle; margin: 10px">
<div class="<?php echo $status?>"><?php echo $msg?></div><br>
<form method="post" action="<?php echo base_url()?>usuario/reset_password">
	<input type="hidden" name="action" value="<?php echo $action?>">
<?php
	if( $status!="success" ) {
?>
	<input type="text" name="email"> <input type="submit" value="Submit">
<?php
	} //if
?>
</form>
</div>