<?php
	$fg_geral_email = ($data['fg_geral_email']=='S')?'checked':'';
	$fg_notif_int_email = ($data['fg_notif_int_email']=='S')?'checked':'';
	$fg_de_inst_email = ($data['fg_de_inst_email']=='S')?'checked':'';
	$fg_de_pessoa_email = ($data['fg_de_pessoa_email']=='S')?'checked':'';
?>
<form id="pref_email" method="post" action="<?php echo base_url('usuario/salvar_pref_email')?>">
<h3>Selecione abaixo quais emails deseja receber</h3>
<div style="float: left; margin: 10px">
	Receber avisos gerais do site<br>
	Receber avisos relacioandos aos seus Interesses<br>
	Receber emails de contato de Instituições<br>
	Receber emails de contato de Pessoas<br>
</div>
<div style="float: left; margin: 10px">
	<input type="checkbox" <?php echo $fg_geral_email?> name="fg_geral_email" value="<?php echo $data['fg_geral_email']?>"><br>
	<input type="checkbox" <?php echo $fg_notif_int_email?> name="fg_notif_int_email" value="<?php echo $data['fg_notif_int_email']?>"><br>
	<input type="checkbox" <?php echo $fg_de_inst_email?> name="fg_de_inst_email" value="<?php echo $data['fg_de_inst_email']?>"><br>
	<input type="checkbox" <?php echo $fg_de_pessoa_email?> name="fg_de_pessoa_email" value="<?php echo $data['fg_de_pessoa_email']?>">
</div>
<div style="clear: both">
<br><input type="submit" value="Salvar">
</form>
</div>