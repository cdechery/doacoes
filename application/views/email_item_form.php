<?php
	$avatar_from = $avatar_to = "";
	$avatar_from = user_avatar($from_user['avatar'], 80);
	$avatar_to = user_avatar($to_user['avatar'], 80);
?>
<form method="POST" id="email_queroitem" action="<?php echo base_url('email/enviar_quer_item')?>">
<input type="hidden" name="de_email" value="<?php echo $from_user['email']?>">
<input type="hidden" name="de_nome" value="<?php echo $from_user['nome']?>">
<input type="hidden" name="para_email" value="<?php echo $to_user['email']?>">
<input type="hidden" name="para_nome" value="<?php echo $to_user['nome']?>">
<input type="hidden" name="item_id" value="<?php echo $item['id']?>">
<p>
De: <img src="<?php echo base_url($avatar_from)?>"> <?php echo $from_user['nome']?>
</p>
<p>
Para: <img src="<?php echo base_url($avatar_to)?>"> <?php echo $to_user['nome']?>
</p>
<p>
Assunto: <input type="text" name="assunto" value="Eu quero o <?php echo $item['titulo']?>">
</p>
<p>
Mensagem: <textarea cols=40 rows=4 name="corpo" onFocus="this.value='';">Escreva algo aqui para o doador (opcional)</textarea>
</p>
<input type="submit" value="Enviar">
</form>
