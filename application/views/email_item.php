<?php
	$avatar_from = $avatar_to = "";
	$avatar_from = user_avatar($from_user['avatar'], 80);
	$avatar_to = user_avatar($to_user['avatar'], 80);
?>
<script type="application/javascript" src="http://localhost/doacoes/javascript/inherit_css"></script>
<form name="queroitem" action="<?php echo base_url('email/enviar')?>"?>
<input type="hidden" name="de" value="<?php echo $from_user['email']?>">
<input type="hidden" name="para" value="<?php echo $to_user['nome']?>">
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
<textarea cols=40 rows=4 name="corpo">Escreva algo aqui para o doador</textarea>
</p>
<input type="submit" value="Enviar">
</form>