<?php
	$labelBtn = "Desativar";
	$cor = "black";
	if( $interesse->fg_ativo == "N" ) {
		$labelBtn = "Ativar";
		$cor = "lightgrey";
	}

	$user_id = $login_data['user_id'];
?>
<table style="color: <?php echo $cor?>;" class="interesse_row">
	<tr>
		<td><?php echo $interesse->categoria?></td>
		<td>
			<select id="raio_<?php echo $interesse->id?>" style="width: 100px;">
				<?php
				$raios = $params['raios_busca'];
				$selected = "";
				foreach($raios as $raio => $desc) {
					$selected=($raio==$interesse->raio_busca)?"selected":"";
					echo '<option value="'.$raio.'" '.$selected.'>'.$desc.'</option>';
				}
				?>
			</select>
		</td>
		<td></td>
		<td>
			<?php echo $interesse->data?>
		</td>
		<td>
			<input type="button" value="Atualizar" class="update_interesse_btn" data-catid="<?php echo $interesse->id?>">		
			<input type="button" class="activ_interesse_btn" value="<?php echo $labelBtn?>" data-catid="<?php echo $interesse->id?>"/>
		</td>
	</tr>
</table>