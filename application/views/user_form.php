<body>
<?php
	$nome = $sobrenome = $lat = $lng = $email = "";
	$cpf = $cnpj = $login = $avatar = $action = "";
	$id = "";

	$tipo = "P";

	if( !empty($data) ) {
		extract($data);
	}

	$actions = array("insert"=>xlabel('insert'), "update"=>xlabel('update'));
	if( empty($avatar) ) {
		$avatar = "images/default_avatar.gif";
	} else {
		$avatar = $params['upload']['path'].$avatar;
	}

	$login_disabled = "";
	if( $action=="update" ) {
		$login_disabled = "disabled";
	}

	$naoMostraSobrenome = $naoMostraCPF = $naoMostraCNPJ = "";

	if( $tipo=="I" ) { // Instituicao
		$naoMostraSobrenome = "style='display: none;'";
		$naoMostraCPF = "style='display: none;'";
	} else { // Pessoa
		$naoMostraCNPJ = "style='display: none;'";
	}
?>

<table cellpadding=5 cellspacing=5 border=0>
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:text-top;">
		<img id="user_avatar" src="<?php echo base_url() . $avatar;?>"/><br>
<?php
	if( $action=="update" ) {
?>
	    <form method="post" action="<?php echo base_url();?>image/upload_avatar" id="upload_avatar" enctype="multipart/form-data">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
	    <input type="hidden" name="thumbs" id="thumbs" value="<?php echo implode('|',$params['image_settings']['thumb_sizes'])?>"/>
		<input type="file" id="userfile" name="userfile" style="display: none;" />
		<input type="button" value="Browse ..." onclick="document.getElementById('userfile').click();" />

	      <br><input type="submit" name="Upload" id="submit" value="<?php echo xlabel('upload')?>" />
	   </form>
<?php
	}
?>
		</td>
		<td>
		<form method="POST" action="<?php echo base_url()?>usuario/<?php echo $action; ?>" id="usuario_<?php echo $action?>" onSubmit="clearInlineLabels(this);">
		<input type="hidden" name="id" value="<?php echo $id ?>">
		<input type="hidden" name="lat" value="<?php echo $lat ?>">
		<input type="hidden" name="long" value="<?php echo $lng ?>">
		<input type="hidden" name="tipo" value="<?php echo $tipo ?>">

		<input type="text" name="login" value="<?php echo $login; ?>" size="50" <?php echo $login_disabled; ?> title="Login"/><br>
		<input type="text" name="nome" value="<?php echo $nome ?>" size="50" title="Name" /><br>
		<input type="text" name="sobrenome" value="<?php echo $sobrenome; ?>" size="50" title="Sobrenome" <?php echo $naoMostraSobrenome?>/><br>
		<input type="text" name="email" value="<?php echo $email; ?>" size="50" title="Email" /><br>
		<input type="text" name="cpf" value="<?php echo $cpf; ?>" size="50" title="CPF" <?php echo $naoMostraCPF?>/><br>
		<input type="text" name="cnpj" value="<?php echo $cpf; ?>" size="50" title="CNPJ" <?php echo $naoMostraCNPJ?>/><br>
		Senha<br>
		<input type="password" name="password" value="" size="10"><br>
		Repita a senha<br>
		<input type="password" name="password_2" value="" size="10" /><br>

		<div><input type="submit" value="<?php echo $actions[ $action ]; ?>"/></div>
		</form>
		<td>
		</td>
	</tr>
</table>
<a href="<?php echo base_url()?>map">Back to the Map</a>
</p>
<script>
$( document ).ready(function() {
	processInLineLabels();
});
</script>
