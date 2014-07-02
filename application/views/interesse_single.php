<?php
	
	$labelBtn = "Desativar";
	$itemstate = "";
	
	if( $interesse->fg_ativo == "N" ) {
		$labelBtn = "Ativar";
		$itemstate = "class='disabled'";
	}

?>

<tr <?php echo $itemstate; ?>>
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
	<td>
		<?php echo $interesse->data?>
	</td>
	<td>
		<button class="update_interesse_btn" data-catid="<?php echo $interesse->id?>">Atualizar</button>
		<button class="activ_interesse_btn blue" data-catid="<?php echo $interesse->id?>"><?php echo $labelBtn?></button>
	</td>
</tr>