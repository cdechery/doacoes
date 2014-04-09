<?php
	$labelBtn = "Desativar";
	$cor = "black";
	if( $interesse->fg_ativo == "N" ) {
		$labelBtn = "Ativar";
		$cor = "lightgrey";
	}

	$user_id = $login_data['user_id'];
?>
<table width="95%" style="color: <?php echo $cor?>;">
	<tr>
	<td width="25%">
	<?php echo $interesse->categoria?>
	</td>
	<td width="30%">
		<select id="raio_<?php echo $interesse->id?>" style="width: 80px;">
<?php
	$raios = $params['raios_busca'];
	$selected = "";
	foreach($raios as $raio) {
		$selected=($raio==$interesse->raio_busca)?"selected":"";
		echo '<option value="'.$raio.'" '.$selected.'>'.$raio.' km</option>';
	}
?>
		</select> <input type="button" value="Atualizar" class="update_interesse_btn" data-catid="<?php echo $interesse->id?>">
	</td>
	<td width="10%">
	&nbsp;
	</td>
	<td width="15%">
	<?php echo $interesse->data?>
	</td>
	<td width="20%">
	<input type="button" class="activ_interesse_btn" value="<?php echo $labelBtn?>" data-catid="<?php echo $interesse->id?>"/>
	<input class="delete_interesse_btn" type="button" value="Excluir" data-catid="<?php echo $interesse->id?>"/>
	</td>
	</tr>
</table>