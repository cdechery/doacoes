<!DOCTYPE html>
<html>
<head>
<meta charset="<?php echo $this->config->item('charset');?>"/>	
<?php
	$fbReg = $this->input->cookie('FbRegPending');
	if( false==$login_data['logged_in'] && false==$fbReg && false ) {
?>
	<script>
		window.fbAsyncInit = function() {		
			FB.init({
				appId      : '<?php echo $params["facebook"]["appId"]?>', // App ID
				status     : true, // check login status
				cookie     : true, // enable cookies to allow the server to access the session
				xfbml      : true  // parse XFBML
			});
			FB.Event.subscribe('auth.authResponseChange', function(response) {
				if (response.status === 'connected') {
					new Messi('Conectando ao Facebook. Aguarde...');
					logonFB();
				} else if (response.status === 'not_authorized') {
					FB.login();
				} else {
					FB.login();
				}
			});
		};
		(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/pt_BR/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));

		function logonFB() {
			window.location = "<?php echo base_url('login/fblogin'); ?>";
		}
	</script>
<?php
	 }
?>

<?php
	
	if( !isset($title) ) {
		echo "ERROR: Title not defined!";
		return;
	}
	
	if( !isset($min_template) ) {
		$min_template = "basic";
	}

?>

<script type="application/javascript" src="<?php echo base_url();?>javascript"></script>
<script type="application/javascript" src="<?php echo base_url();?>min/g=<?php echo $min_template;?>_js"></script>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>min/g=<?php echo $min_template;?>_css"/>
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<title><?php echo $title; ?></title>
</head>
<body>
<?php

	$user_name = "";
	$signup_link = "<a href='".base_url()."login'>Login</a>";
	$signup_link .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href='".base_url()."usuario/new_user'>Registrar</a>";


	if( isset($login_data) && $login_data["logged_in"] ) {
		$user_name = "Ol&aacute; <a href='".base_url()."usuario/modify'>". $login_data["name"]."</a> ";
		$user_name .= "[<a href='".base_url()."usuario/logout'>Logout</a>]";
		$user_name .= "<div>Cadastrar: <a href='".base_url()."usuario/itens'>Item<a>&nbsp;|&nbsp;<a href='".base_url()."usuario/interesses'>Interesse<a></div>";
		$signup_link = "";
	}
?>
<header>
	<div class="wrap960">
		<div id="marca">&nbsp;</div>
		<h1><a href="<?php echo base_url();?>">Quem Precisa?</a></h1>
		<div id="login">
			<?php echo $user_name;?>
			<?php echo $signup_link;?>
			<div class="fb-login-button" scope="email,public_profile" data-max-rows="1" data-size="large" data-show-faces="false"></div>
		</div>
	</div>
</header>

	