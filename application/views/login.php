<div id="login">
	<div>
		<h4 style="color: red;"><?php echo $msg?></h4>
	</div>
	<h2>Login</h2>
	<form method="post" action="<?php echo base_url()?>login/verify">
		<h5><?php echo $msg?></h5>
		<div class="form-group">
			<label>Usu�rio: </label>
			<input type="text" name="login" id="login" />
		</div>
		<div class="form-group">
			<label>Senha: </label>
			<input type="password" name="password" id="password"/>
		</div>
		<div class="form-group checkbox">
			<label>
				<input type="checkbox" name="lembrar"> Manter conectado?
			</label>
		</div>
		<div class="form-group">
			<input type="submit" value="Enviar">
		</div>
	</form>
</div>

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
