<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; <?php echo $this->config->item('charset');?>"/>
<meta charset="<?php echo $this->config->item('charset');?>"/>

<?php
	
	if( !isset($title) ) {
		echo "ERROR: Title not defined!";
		return;
	}
	
	//if( !isset($min_template) ) {
	if(isset($min_template)) {
		$min_template = "basic";
	}

?>

<script type="application/javascript" src="<?php echo base_url();?>javascript"></script>
<script type="application/javascript" src="<?php echo base_url();?>min/g=<?php echo $min_template;?>_js"></script>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>min/g=<?php echo $min_template;?>_css"/>
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<title><?php echo $title; ?></title>
</head>
<body>

<?php

	$user_name = "None";
	$signup_link = " | <a href='".base_url()."login'>Login</a>";
	$signup_link .= " | <a href='".base_url()."usuario/new_user'>Sign up</a>";


	if( isset($login_data) && $login_data["logged_in"] ) {
		$user_name = "<a href='".base_url()."usuario/modify'>". $login_data["name"]."</a> ";
		$user_name .= "[<a href='".base_url()."usuario/logout'>Logout</a>]";
		$signup_link = "";
	}

?>

<header>

	<div class="wrap960">
		
		<h1>Quem Precisa?</h1>

		<div id="login">
			Olá <?php echo $user_name;?>
			<?php echo $signup_link;?>
		</div>

	</div>

</header>
	