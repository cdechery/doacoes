<div id="login">

	<header>
		<a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>/images/logo_grande.png" alt="interessa.org"></a>
	</header>
	
	<div id="erromsg"><?php echo $msg?></div>

	<form id="login" method="post" action="<?php echo base_url()?>login/verificar">
		<input type="hidden" name="next" value="<?php echo $next?>">
		<div class="form-group">
			<input type="text" name="login" id="login" placeholder="Login" />
		</div>
		<div class="form-group">
			<input type="password" name="password" id="password" placeholder="Senha" />
		</div>
		<div id="lembrasenha" class="form-group checkbox clearfix">
			<a class="various" href="<?php echo base_url()?>usuario/reset_password" data-fancybox-type="iframe">
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

	<script>
		$(document).ready(function() {
		$(".various").fancybox({
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
		})
	</script>

</div>

<div id="link_cadastro">
	Novo por aqui?&nbsp;&nbsp;<a href="<?php echo base_url('usuario/novo')?>">Faça seu cadastro</a>
</div>
