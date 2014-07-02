<?php 

	$count =  $interesses['count'];
	$raios = $params['raios_busca'];
	$selected = "";
	$active = "blue";
	$labelBtn = "Desativar";
	$cor = "black";
	$itemstate = "";
	
	$display_inter_none = "none";
	if( $count == 0 ) {
		$display_inter_none = "block";
	}
	
	$validade = $params['validade_interesse_pessoa'];
	if( $login_data['type']=='I' ) {
		$validade = $params['validade_interesse_inst'];
	}

?>

<h2>Meus Interesses</h2>

<p>Interesses são válidos por <?php echo $validade?> dias após a data de seu cadastro.<br>
Após esse período serão excluídos automaticamente - podendo ser cadastrados novamente sem problemas.</p>

<div id="interesses">
	
	<div align="center" id="interesses_none" style="display:<?php echo $display_inter_none?>;">
		Não há nenhum Interesse cadastrado.
	</div>

	<table>
		
		<colgroup>
			<col span="4" style="width:25%;" />
		</colgroup>
		
		<thead>
			<tr>
				<th>Categoria</th>
				<th>Distância</th>
				<th>Data Inclusão</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($count !== 0) {
				foreach ($interesses['data'] as $int) {
					if( $int->fg_ativo == "N" ) {
						$labelBtn = "Ativar";
						$itemstate = "class='disabled'";
						$active = "";
					}
			?>
				<tr <?php echo $itemstate; ?>>
					<td><?php echo $int->categoria; ?></td>
					<td>
						<select id="raio_<?php echo $int->id; ?>">
							<?php 
								foreach ($raios as $raio => $desc) {
									echo 'a '.$raio.' b '.$int->raio_busca;
									$selected = ($raio == $int->raio_busca) ? "selected" : "cu";
									echo '<option value = "'.$raio.'" '.$selected.'>'.$desc.'</option>';
								}
							 ?>
						 </select>
					</td>
					<td><?php echo $int->data; ?></td>
					<td>
						<button class="update_interesse_btn" data-catid="<?php echo $int->id?>">Atualizar</button>
						<button class="activ_interesse_btn <?php echo $active; ?>" data-catid="<?php echo $int->id?>"><?php echo $labelBtn?></button>
					</td>
				</tr>		
			<?	}
			} ?>
		</tbody>
	</table>

</div>

<form method="post" id="interesse_insert" action="<?php echo base_url()?>interesse/insert">
	<h3>Incluir novo&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle"></i></h3>
	<label>Categoria</label>
	<select name="categ">
		<option value=""></option>
		<option value="1">Roupas</option>
		<option value="2">Móveis</option>
		<option value="3">Brinquedos</option>
	</select>&nbsp;&nbsp;
	<label>Distância</label>
	<select name="raio" style="width: 100px;">
		<?php
			foreach($raios as $raio => $desc) {
				echo '<option value="'.$raio.'">'.$desc.'</option>';
			}
		?>
	</select>&nbsp;&nbsp;
	<input type="submit" value="Inserir">
</form>
