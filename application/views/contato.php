<?php
	$nome = $email = "";
	if( $login_data['logged_in'] ) {
		$nome = $login_data['name'];
		$email = $login_data['email'];
	}
?>

<h3>Entre em contato</h3>
<form method="post" action="<?php echo base_url('contato/enviar')?>">
	<input type="text" name="nome" placeholder="Seu nome" value="<?php echo $nome?>">
	<input type="text" name="email" placeholder="Seu email" value="<?php echo $email?>">
	<select name="assunto">
		<option value=""></option>
		<option value="duvida">Dúvida</option>
		<option value="critica">Reclamação</option>
		<option value="problema">Erro no site</option>
	</select>
	<textarea name="corpo" placeholder="Entre sua mensagem" cols="20" rows="4"></textarea>
	<p><input type="submit" value="Enviar"></p>

</form>

