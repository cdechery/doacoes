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