<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; <?php echo $this->config->item('charset');?>"/>
<meta charset="<?php echo $this->config->item('charset');?>"/>
<?php
	if( !isset($min_template) ) {
		$min_template = "basic";
	}

	$minDebug = "";
	if( ENVIRONMENT!='production' ) {
		$minDebug = "&debug=true";
	}
?>
<script type="application/javascript" src="<?php echo base_url();?>javascript"></script>
<script type="application/javascript" src="<?php echo base_url();?>min/g=<?php echo $min_template;?>_js<?php echo $minDebug?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>min/g=<?php echo $min_template;?>_css<?php echo $minDebug?>"/>
