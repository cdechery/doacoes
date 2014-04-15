<form method="post" id="interesse_insert" action="<?php echo base_url()?>interesse/insert">
<h3>Meus Interesses</h3>
<h4>Incluir novo</h4>
<table>
	<tr>
	<td>
	Categoria
	<select name="categ">
		<option value=""></option>
		<option value="1">Roupas</option>
		<option value="2">Móveis</option>
		<option value="3">Brinquedos</option>
	</select>
	</td>
	<td>
	Distância
		<select id="raio" style="width: 100px;">
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
	<input type="submit" value="Inserir">
	</td>
	</tr>
</table>
</form>
<style>
.interesse_head {
	font-weight: bold;
	font-size: 14px;
	background-color: lightgray;
}
</style>
<table width="95%" class="interesse_head">
	<tr>
	<td width="25%">
	Categoria
	</td>
	<td width="25%">
	Distância
	</td>
	<td width="10%">
	&nbsp;
	</td>
	<td width="20%">
	Data Inclusão
	</td>
	<td width="20%">
	Ações
	</td>
	</tr>
</table>
<?php
	$display_inter_none = "none";
	if( $int_count==0 ) {
		$display_inter_none = "box";
	}
?>
<div id="interesses">
	<div align="center" id="interesses_none" style="display: <?php echo $display_inter_none?>;">
		Não há nenhum Interesse cadastrado.
	</div>
</div>
