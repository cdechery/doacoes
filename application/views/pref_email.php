<?php
	$fg_geral_email = ($data['fg_geral_email']=='S')?'checked':'';
	$fg_notif_int_email = ($data['fg_notif_int_email']=='S')?'checked':'';
	$fg_de_inst_email = ($data['fg_de_inst_email']=='S')?'checked':'';
	$fg_de_pessoa_email = ($data['fg_de_pessoa_email']=='S')?'checked':'';
?>

<h2>Preferências de email</h2>

<p>Selecione abaixo quais emails deseja receber.</p>

<div class="roundbox">

	<form id="pref_email" method="post" action="<?php echo base_url('usuario/salvar_pref_email')?>">
	
		<label>Receber avisos gerais do site</label> <input type="checkbox" <?php echo $fg_geral_email?> name="fg_geral_email" value="<?php echo $data['fg_geral_email']?>"><br>
		<label>Receber avisos relacioandos aos seus Interesses</label> <input type="checkbox" <?php echo $fg_notif_int_email?> name="fg_notif_int_email" value="<?php echo $data['fg_notif_int_email']?>"><br>
		<label>Receber emails de contato de Instituições</label> <input type="checkbox" <?php echo $fg_de_inst_email?> name="fg_de_inst_email" value="<?php echo $data['fg_de_inst_email']?>"><br>
		<label>Receber emails de contato de Pessoas</label> <input type="checkbox" <?php echo $fg_de_pessoa_email?> name="fg_de_pessoa_email" value="<?php echo $data['fg_de_pessoa_email']?>"><br>

		<br>

		<input type="submit" value="Salvar">

	</form>

</div>