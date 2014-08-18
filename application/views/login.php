<script>
$(document).ready(function() {
	// esqueceu senha
	$("#lembrasenha a").fancybox({
		fitToView	: false,
		width		: '300px',
		height		: '100px',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	$(".escolhetipo_box").fancybox({
		padding		: 25,
		fitToView	: false,
		width		: '630px',
		height		: '310px',
		autoSize	: false,
		type		: 'ajax',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>

<div id="login-page">

	<header>
			<span style="text-align: center; color: white; font-size:2em; font-weight: strong;">Login</span>
	</header>
	
	<div id="erromsg"><?php echo $msg?></div>

	<form method="post" action="<?php echo base_url()?>login/verificar">
		<input type="hidden" name="next" value="<?php echo $next?>">
		<div class="form-group">
			<input type="text" name="login" id="login" placeholder="Login" />
		</div>
		<div class="form-group">
			<input type="password" name="password" id="password" placeholder="Senha" />
		</div>
		<div id="lembrasenha" class="form-group checkbox clearfix">
			<a href="<?php echo base_url()?>usuario/reset_password" data-fancybox-type="iframe">
				<?php echo xlang('dist_resetpw_link')?>
			</a>
			<label>
				<input type="checkbox" name="lembrar"> Manter conectado?
			</label>
		</div>
		<div class="form-group">
			<input type="submit" value="Fazer login">
		</div>
	</form>

</div>

<div id="link_cadastro">
	Novo por aqui?&nbsp;&nbsp;<a href="<?php echo base_url('usuario/escolhe_tipo/w')?>" class="escolhetipo_box fancybox.ajax">Preencha o cadastro</a> ou use o <a class="fb-login-button" scope="email,public_profile" data-size="icon" data-show-faces="false"></a>
</div>

