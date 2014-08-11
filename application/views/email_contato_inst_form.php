<?php
	$avatar_from = $avatar_to = "";
	$avatar_from = user_avatar($from_user['avatar'], 40);
	$avatar_to = user_avatar($to_user['avatar'], 40);
?>
<form method="POST" id="email_contato_inst" action="<?php echo base_url('email/enviar_contato_inst')?>">
	<input type="hidden" name="de_email" value="<?php echo $from_user['email']?>">
	<input type="hidden" name="de_nome" value="<?php echo $from_user['nome']?>">
	<input type="hidden" name="para_email" value="<?php echo $to_user['email']?>">
	<input type="hidden" name="para_nome" value="<?php echo $to_user['nome']?>">
	<div class="form-group">
		<label>De:</label>
		<img src="<?php echo $avatar_from?>"> <?php echo $from_user['nome']?>
	</div>
	<div>
		<label>Para:</label>
		<img src="<?php echo $avatar_to?>"> <?php echo $to_user['nome']?>
	</div>
	<div class="form-group">
		<label>Assunto: </label>
		<input type="text" name="assunto" value="Olá, <?php echo $to_user['nome']?>">
	</div>
	<div class="form-group">
		<label>Mensagem: </label>
		<textarea cols="30" rows="4" name="corpo"></textarea>
	</div>
	<div class="form-group submit">
		<input type="submit" value="Enviar">
	</div>
</form>
