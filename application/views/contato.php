<?php
	$nome = $email = "";
	if( $login_data['logged_in'] ) {
		$nome = $login_data['name'];
		$email = $login_data['email'];
	}
?>

<div id="contato" class="roundbox clearfix">

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
				<option value="sugestao">Sugestão</option>
				<option value="problema">Erro no site</option>
				<option value="elogio">Elogio</option>
			</select>
		</div>
		<div class="form-group">
			<label>Sua mensagem:</label>
			<textarea name="corpo" placeholder="Entre sua mensagem" cols="20" rows="4"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" value="Enviar">
		</div>

	</form>

	<aside>
		<p>Se tiver qualquer dúvida sobre o funcionamento do site, tente primeiro procurar <a href="<?php echo base_url('ajuda')?>">aqui</a> ou <a href="<?php echo base_url('sobre')?>">aqui</a>.</p>
		<p>O funcionamento do site é bastante simples e muito provavelmente você vai encontrar o que procura nos links acima. Se não achar, não tem problema. Pode escrever pra gente. Prometo que respondemos rapidinho.</p>
		<p>Sugestões e elogios são bem-vindos também, é claro. =]</p>
	</aside>

</div>
