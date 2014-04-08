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
?>
	<input type="button" id="<?php echo $actBtn?>_interesse" value="<?php echo $labelBtn?>"/>
	</td>
	<td width="20%">
	<?php echo $interesse->data?>
	</td>
	<td width="20%">
	<input type="button" value="Atualizar"> | <input type="button" value="Excluir">
	</td>
	</tr>
</table>