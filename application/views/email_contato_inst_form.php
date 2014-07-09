<?php
	$avatar_from = $avatar_to = "";
	$avatar_from = user_avatar($from_user['avatar'], 80);
	$avatar_to = user_avatar($to_user['avatar'], 80);
?>
<form method="POST" id="email_contato_inst" action="<?php echo base_url('email/enviar_contato_inst')?>">
<input type="hidden" name="de_email" value="<?php echo $from_user['email']?>">
<input type="hidden" name="de_nome" value="<?php echo $from_user['nome']?>">
<input type="hidden" name="para_email" value="<?php echo $to_user['email']?>">
<input type="hidden" name="para_nome" value="<?php echo $to_user['nome']?>">
<p>
De: <img src="<?php echo $avatar_from?>"> <?php echo $from_user['nome']?>
</p>
<p>
Para: <img src="<?php echo $avatar_to?>"> <?php echo $to_user['nome']?>
</p>
<p>
Assunto: <input type="text" name="assunto" value="Olá, <?php echo $to_user['nome']?>">
</p>
<p>
Mensagem: <textarea cols=40 rows=4 name="corpo" onFocus="this.value='';">Escreva aqui sua mensagem</textarea>
</p>
<input type="submit" value="Enviar">
</form>
