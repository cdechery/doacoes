<!DOCTYPE html>
<html>
<head>
<meta charset="<?php echo $this->config->item('charset');?>"/>
<?php
	$fbReg = $this->input->cookie('FbRegPending');
	if( false == $login_data['logged_in'] && false == $fbReg ) {
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
		};

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
<script type="application/javascript" src="<?php echo base_url('min/f='.implode(",",$cust_js).$min_debug)?>"></script>
<?php
	}

	if( !empty($cust_css) ) {
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('min/f='.implode(",",$cust_css).$min_debug)?>"/>
<?php
	}
?>
<title><?php echo $title; ?></title>
</head>
<body>
<header id="main">
	<div class="wrap960">
		<h1><a href="<?php echo base_url();?>">Interessa ?</a></h1>
		<nav id="top">
			<ul>
				<li>
					<a href="">Sobre</a>
				</li>
				<li>
					<a href="">Contato</a>
				</li>
<?php
	if ( $login_data["logged_in"] ) {
?>
					<li id="user-btn">
						<a href=""><?php echo $login_data["name"]?>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
						<div id="user-menu">
							<ul>
<?php
		if ( $login_data['type']=='P') {
?>
								<li><a href="<?php echo base_url('usuario/itens')?>">Meus Itens</a></li>
<?php
		} // tipo = P
?>
								<li><a href="<?php echo base_url('usuario/interesses')?>">Meus Interesses</a></li>
								<li><a href="<?php echo base_url('usuario/modificar')?>">Editar perfil</a></li>
								<li><a href="<?php echo base_url('usuario/logout')?>">Logout</a></li>
							</ul>
						</div>
					</li>
<?php
	} else {
?>
					<li id="user-btn">
						<a href="<?php echo base_url('login')?>">Login / Cadastro</a>
					</li>
<?php
	} // if logged_in
?>
				<li>
					<div class="fb-login-button" scope="email,public_profile" data-max-rows="1" data-size="large" data-show-faces="false"></div>
				</li>
			</ul>
		</nav>
	</div>
</header>

	