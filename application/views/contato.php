<?php
	$nome = $email = "";
	if( $login_data['logged_in'] ) {
		$nome = $login_data['name'];
		$email = $login_data['email'];
	}
?>

<h2>Entre em contato</h2>

<form method="post" action="<?php echo base_url('contato/enviar')?>">
	<div class="form-group">
		<label>Seu nome:</label>
		<input type="text" name="nome" placeholder="Seu nome" value="<?php echo $nome?>">
	</div>
	<div class="form-group">
		<label>Seu email:</label>
		<input type="text" name="email" placeholder="Seu email" value="<?php echo $email?>">
	</div>
	<div class="form-group">
		<label>Assunto:</label>
		<select name="assunto">
			<option value=""></option>
			<option value="duvida">Dúvida</option>
			<option value="critica">Reclamação</option>
			<option value="problema">Erro no site</option>
		</select>
	</div>
	<div class="form-group">
		<label>Sua mensagem:</label>
		<textarea name="corpo" placeholder="Entre sua mensagem" cols="20" rows="4"></textarea>
	</div>
	<div><input type="submit" value="Enviar"></div>

</form>

