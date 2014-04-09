<table width="95%">
	<tr>
	<td width="25%">
	<?php echo $interesse->categoria?>
	</td>
	<td width="15%">
	<?php echo $interesse->raio_busca?> km
	</td>
	<td width="20%">
<?php
	$labelBtn = "Desativar";
	$actBtn = "desativar";
	if( $interesse->fg_ativo == "N" ) {
		$labelBtn = "Ativar";
		$actBtn = "desativar";
	}

	$user_id = $login_data['user_id'];
?>
	<input type="button" id="<?php echo $actBtn?>_interesse" value="<?php echo $labelBtn?>" data_catid="" data_userid=""/>
	</td>
	<td width="20%">
	<?php echo $interesse->data?>
	</td>
	<td width="20%">
	<input type="button" value="Atualizar"> | <input class="delete_interesse_btn" type="button" value="Excluir" data-catid="<?php echo $interesse->id?>" data-userid="<?php echo $user_id?>">
	</td>
	</tr>
</table>