<!DOCTYPE html>
<html>
<head>
<meta charset="<?php echo $this->config->item('charset');?>"/>
<?php
	
	if( !isset($title) ) {
		echo "ERROR: Title not defined!";
		return;
	}
	
	if( !isset($min_template) ) {
		$min_template = "basic";
	}

	$min_debug = "";
	if( ENVIRONMENT!='production' ) {
		$min_debug = "&debug=true";
	}

?>
<script type="application/javascript" src="<?php echo base_url('javascript')?>"></script>
<script type="application/javascript" src="<?php echo base_url('min/g='.$min_template.'_js'.$min_debug)?>"></script>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('min/g='.$min_template.'_css'.$min_debug)?>"/>
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
	if( !empty($cust_js) ) {
?>
<script type="application/javascript" src="<?php echo base_url('min/f='.implode(",",$cust_js))?>"></script>
<?php
	}

	if( !empty($cust_css) ) {
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('min/f='.implode(",",$cust_css).$min_debug)?>"/>
<?php
	}
?>
<title><?php echo $title; ?></title>

<script>
$(document).ready(function() {
	// esqueceu senha
	$("#lembrasenha a").fancybox({
		maxWidth	: 320,
		maxHeight	: 129,
		fitToView	: false,
		width		: '90%',
		height		: '90%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	// cadastro
	$("#link_cadastro a").fancybox({
		maxWidth	: 500,
		maxHeight	: 300,
		fitToView	: false,
		width		: '90%',
		height		: '90%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>

<div id="cadastro_window" style="display:none">
	<p>Você está criando um cadastro novo para:</p>
	<div class="col">
		<a href="<?php echo base_url('usuario/novo/P')?>">Pessoa</a> - para <strong>fazer</strong> e receber doações. Só aparecem no mapa Pessoas com Itens para doar.
	</div>
	<div class="col">
		<a href="<?php echo base_url('usuario/novo/I')?>">Instituição</a> - para fazer e <strong>receber</strong> doações. Todas aparecem no mapa, independente de ter Itens ou não.
	</div>
</div>

</head>

<body>
