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
		<option value="2">M�veis</option>
		<option value="3">Brinquedos</option>
	</select>
	</td>
	<td>
	Raio
	<select name="raio">
		<option value=""></option>
		<option value="1">1 km</option>
		<option value="5">5 km</option>
		<option value="10">10 km</option>
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
	Raio
	</td>
	<td width="10%">
	&nbsp;
	</td>
	<td width="20%">
	Data Inclus�o
	</td>
	<td width="20%">
	A��es
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
		N�o h� nenhum Interesse cadastrado.
	</div>
</div>
