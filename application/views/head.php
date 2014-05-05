<!DOCTYPE html>
<html>
<head>
<?php
	$fbReg = $this->input->cookie('FbRegPending');
	//var_dump($fbReg); die;

	if( false==$login_data['logged_in'] && false==$fbReg ) {
?>
<script>
   window.fbAsyncInit = function() {
   FB.init({
     appId      : '649645738441266', // App ID
     //channelUrl : '//localhost/doacoes/login/fbchannel', // Channel File
     status     : true, // check login status
     cookie     : true, // enable cookies to allow the server to access the session
     xfbml      : true  // parse XFBML
   });
    
   // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
   // for any authentication related change, such as login, logout or session refresh. This means that
   // whenever someone who was previously logged out tries to log in again, the correct case below 
   // will be handled. 
   FB.Event.subscribe('auth.authResponseChange', function(response) {
     // Here we specify what we do with the response anytime this event occurs. 
     if (response.status === 'connected') {
       // The response object is returned with a status field that lets the app know the current
       // login status of the person. In this case, we're handling the situation where they 
       // have logged in to the app.
	   new Messi('Conectando ao Facebook. Aguarde...');
       testAPI();
     } else if (response.status === 'not_authorized') {
       // In this case, the person is logged into Facebook, but not into the app, so we call
       // FB.login() to prompt them to do so. 
       // In real-life usage, you wouldn't want to immediately prompt someone to login 
       // like this, for two reasons:
       // (1) JavaScript created popup windows are blocked by most browsers unless they 
       // result from direct interaction from people using the app (such as a mouse click)
       // (2) it is a bad experience to be continually prompted to login upon page load.
       FB.login();
     } else {
       // In this case, the person is not logged into Facebook, so we call the login() 
       // function to prompt them to do so. Note that at this stage there is no indication
       // of whether they are logged into the app. If they aren't then they'll see the Login
       // dialog right after they log in to Facebook. 
       // The same caveats as above apply to the FB.login() call here.
       FB.login();
     }
   });
   };
    
   // Load the SDK asynchronously
	(function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/pt_BR/all.js";
    ref.parentNode.insertBefore(js, ref);
   }(document));
    
   // Here we run a very simple test of the Graph API after login is successful. 
   // This testAPI() function is only called in those cases. 
   function testAPI() {
    // console.log('Welcome!  Fetching your information.... ');
     //FB.api('/me', function(response) {
      // console.log('Good to see you, ' + response.name + '.');
     //});
     
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