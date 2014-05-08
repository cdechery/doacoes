<!DOCTYPE html>
<html>
<head>
<?php
	$fbReg = $this->input->cookie('FbRegPending');

	if( false==$login_data['logged_in'] && false==$fbReg ) {
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
<meta http-equiv="Content-Type" content="text/html; <?php echo $this->config->item('charset');?>"/>
<meta charset="<?php echo $this->config->item('charset');?>"/>
<?php
	if( !isset($title) ) {
		echo "ERROR: Title not defined!";
		return;
	}
	
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
<style>
body {
	background-color:#787977;font-size:14px;margin:0px;
}
.corners {
	padding:15px; line-height:18px; 
	-moz-border-radius:10px; -khtml-border-radius:10px; 
	-webkit-border-radius:10px; border-radius:10px; 
	-moz-box-sizing:content-box; 
	-webkit-box-sizing:content-box; 
	-khtml-box-sizing:content-box; box-sizing:content-box;
}

#body_container {
	margin:20px 0px 0px;width:800px;background-color:#fff;padding:20px;
}
.credits {
	margin:0px;width:800px;text-align:right;padding:5px 0px;color:#ccc;font-size:11px;top:30px;float:bottom;
}
.credits a {
	color:#ccc; font-size:12px;border:0px;text-decoration:none;
}
</style>
<title><?php echo $title; ?></title>
</head>
<body>
	<div align="center">
	<div class="corners" id="body_container" align="left">
	<h2><a href="<?php echo base_url()?>">QuemPrecisa</a></h2>
<?php
		$user_name = "None";
		$signup_link = " | <a href='".base_url()."login'>Login</a>";
		$signup_link .= " | <a href='".base_url()."usuario/tipo'>Sign up</a>";


		if( isset($login_data) && $login_data["logged_in"] ) {
			$user_name = "<a href='".base_url()."usuario/modify'>". $login_data["name"]."</a> ";
			$user_name .= "[<a href='".base_url()."usuario/logout'>Logout</a>]";
			$signup_link = "";
		}
?>
<div align="right">User: <?php echo $user_name;?><?php echo $signup_link;?></div>
<div class="fb-login-button" scope="email,public_profile" data-max-rows="1" data-size="large" data-show-faces="false"></div>