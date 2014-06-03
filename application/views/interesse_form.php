<h2>Meus Interesses</h2>

<form method="post" id="interesse_insert" action="<?php echo base_url()?>interesse/insert">
	<h4>Incluir novo</h4>
	<div class="form-group">
		<label>Categoria</label>
			<select name="categ">
			<option value=""></option>
			<option value="1">Roupas</option>
			<option value="2">Móveis</option>
			<option value="3">Brinquedos</option>
		</select>
	</div>
	<div class="form-group">
		<label>Distância</label>
		<select name="raio" style="width: 100px;">
			<?php
				$raios = $params['raios_busca'];
				$selected = "";
				foreach($raios as $raio => $desc) {
					echo '<option value="'.$raio.'" '.$selected.'>'.$desc.'</option>';
				}
			?>
		</select>
	</div>
	<input type="submit" value="Inserir">
</form>

<p>&nbsp;</p>

<table>
	<colgroup>
		<col span="5" style="width:20%;" />
	</colgroup>
	<thead>
		<tr>
			<th>Categoria</th>
			<th>Distância</th>
			<th>&nbsp;</th>
			<th>Data Inclusão</th>
			<th>Ações</th>
		</tr>
	</thead>
</table>

<?php
	$display_inter_none = "none";
	if( $int_count==0 ) {
		$display_inter_none = "block";
	}
?>

<div id="interesses">
	<div align="center" id="interesses_none" style="display:<?php echo $display_inter_none?>;">
		Não há nenhum Interesse cadastrado.
	</div>
</div>
