<?php 

	$count =  $interesses['count'];
	$raios = $params['raios_busca'];
	$selected = "";
	$active = "blue";
	$labelBtn = "<i class='fa fa-square-o'></i>&nbsp;Desativar";
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

	chromePhp::log($interesses);

?>

<h2>Meus Interesses</h2>

<p>Interesses são válidos por <?php echo $validade?> dias após a data de seu cadastro.<br>
Após esse período serão excluídos automaticamente - podendo ser cadastrados novamente sem problemas.</p>

<div align="center" id="interesses_none" style="display:<?php echo $display_inter_none?>;">
	Não há nenhum Interesse cadastrado.
</div>

<div id="interesses">

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
						$labelBtn = "<i class='fa fa-check-square-o'></i>&nbsp;Ativar";
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
						<button class="update_interesse_btn" data-catid="<?php echo $int->id?>"><i class="fa fa-refresh"></i>&nbsp;Atualizar</button>
						<button class="activ_interesse_btn <?php echo $active; ?>" data-catid="<?php echo $int->id?>"><?php echo $labelBtn?></button>
					</td>
				</tr>		
			<?php }
			} ?>
		</tbody>
	</table>

</div>

<form method="post" id="interesse_insert" action="<?php echo base_url()?>interesse/insert">
	<h3>Incluir novo&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle"></i></h3>
	<label>Categoria</label>
	<select name="categ">
		<?php
			foreach ($categorias as $cat) {
				echo '<option value="'.$cat->id.'">'.$cat->nome.'</option>';
			}
		?>
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
