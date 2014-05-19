<style>
.interesse_head {
	font-weight: bold;
	font-size: 14px;
	background-color: lightgray;
}
</style>

<section class="contents">
	<div class="wrap960">
		<h2>Meus Interesses</h2>
		<form method="post" id="interesse_insert" action="<?php echo base_url()?>interesse/insert">
			<h4>Incluir novo</h4>
			<div class="form-group">
				<label>Categoria</label>
					<select name="categ">
					<option value=""></option>
					<option value="1">Roupas</option>
					<option value="2">M�veis</option>
					<option value="3">Brinquedos</option>
				</select>
			</div>
			<div class="form-group">
				<label>Dist�ncia</label>
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
		<br><br>
		<table class="interesse_head">
			<tr>
				<td>Categoria</td>
				<td>Dist�ncia</td>
				<td>&nbsp;</td>
				<td>Data Inclus�o</td>
				<td>A��es</td>
			</tr>
		</table>
		<?php
			$display_inter_none = "none";
			if( $int_count==0 ) {
				$display_inter_none = "box";
			}
		?>
		<div id="interesses">
			<div align="center" id="interesses_none" style="display:<?php echo $display_inter_none?>;">
				N�o h� nenhum Interesse cadastrado.
			</div>
		</div>
	</div>
</section>
