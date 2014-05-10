<?php
	$avatar_from = $avatar_to = "";
	if( empty($from_user['avatar']) ) {
		$avatar_from = base_url('images/default_avatar_small.gif');
	} else {
		$avatar_from = base_url('files/'.thumb_filename($from_user['avatar'], 80));
	}

	if( empty($to_user['avatar']) ) {
		$avatar_to = base_url('images/default_avatar_small.gif');
	} else {
		$avatar_to = base_url('files/'.thumb_filename($to_user['avatar'], 80));
	}
?>
<script type="application/javascript" src="http://localhost/doacoes/javascript/inherit_css"></script>
<form name="queroitem" action="<?php echo base_url('email/enviar')?>"?>
<input type="hidden" name="de" value="<?php echo $from_user['email']?>">
<input type="hidden" name="para" value="<?php echo $to_user['nome']?>">
<input type="hidden" name="item_id" value="<?php echo $item['id']?>">
<p>
De: <img src="<?php echo $avatar_from?>"> <?php echo $from_user['nome']?>
</p>
<p>
Para: <img src="<?php echo $avatar_to?>"> <?php echo $to_user['nome']?>
</p>
<p>
Assunto: <input type="text" name="assunto" value="Eu quero o <?php echo $item['titulo']?>">
</p>
<p>
<textarea cols=40 rows=4 name="corpo">Escreva algo aqui para o doador</textarea>
</p>
<input type="submit" value="Enviar">
</form>