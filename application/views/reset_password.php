<form id="forgot_pass" method="post" action="<?php echo base_url()?>usuario/reset_password">

	<h4 class="<?php echo $status?>"><?php echo $msg?></h4>

	<input type="hidden" name="action" value="<?php echo $action?>">	

<?php
	if( $status!="success" ) {
?>
	<div class="form-group">
		<input type="text" name="email" style="display: inline-block">
		<input type="submit" value="Ok">
	</div>

<?php
	} //if
?>
</form>