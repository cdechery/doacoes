<html>
<head>
	<title>Newsletter</title>
	 <link type="text/css" rel="stylesheet" href="<?php echo base_url('css/interessa.css')?>">
<script type="text/javascript">
	function valida(form) {
		if( form.assunto.value.length < 3 ) {
			alert('Assunto muito pequeno!');
			return false;
		}

		if( form.msg.value.length < 10 ) {
			alert('Mensagem muito pequena!');
			return false;
		}

		if( form.emails.value.indexOf('\n')!= -1 ||
			form.emails.value.indexOf('\r')!= -1 ) {
			alert('Separe os emails com ; !!!');
			return false;
		}

		form.submit.disabled = true;
		form.submit.value = 'Enviando, aguarde...';			

		return true;
	}
</script>
</head>
<body style="margin: 20px">
<h2>Enviar Newsletter</h2>
<form method="post" action="<?php echo base_url('newsletter/enviar')?>" onSubmit="return valida(this);">
Assunto: <input type="text" name="assunto">
De: <select name="from">
<option value="noreply">noreply</option>
<option value="webmaster">webmaster</option>
</select><br>
Corpo da mensagem (sem "olá" ou "um abraço"):
<textarea name="msg" rows="4" cols="40">
</textarea>
Enviar apenas para estes (separado por ;):
<textarea name="emails" rows="4" cols="40"></textarea>
<input name="submit" type="submit" value="Enviar">
<p><a href="<?php echo base_url('newsletter')?>">Enviar outra?</a></p>
</body>
</html>