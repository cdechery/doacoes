<section id="contents">
	<div class="wrap960">
		<h5><?php echo $msg?></h5>
		<form method="post" action="<?php echo base_url()?>login/verify">
			<h3>Login</h3>
			<div class="form-group">
				<label>Username: </label>
				<input type="text" class="form-control" name="login" id="login" />
			</div>
			<div class="form-group">
				<label>Password: </label>
				<input type="password" class="form-control" name="password" id="password"/>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="lembrar"> Manter conectado?
				</label>
			</div>
			<div class="form-group">
				<a class="various" href="<?php echo base_url()?>usuario/reset_password" data-fancybox-type="iframe">
					<?php echo xlang('dist_resetpw_link')?>
				</a>
				<button type="submit" class="btn btn-default">Go</button>
			</div>
		</form>
	</div>
</section>

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
