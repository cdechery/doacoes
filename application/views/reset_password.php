<form id="forgot_pass" method="post" action="<?php echo base_url()?>usuario/reset_password">

	<p class="<?php echo $status?>"><?php echo $msg?></p>

	<input type="hidden" name="action" value="<?php echo $action?>">	

<?php
	if( $status!="success" ) {
?>
	<div class="form-group-horizontal">
		<input type="text" name="email">&nbsp;&nbsp;
		<input type="submit" value="Ok">
	</div>

<?php
	} //if
?>
</form>