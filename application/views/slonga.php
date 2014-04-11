<form name="__map">
<?php echo $map['js']; ?>
<?php echo $map['html']; ?>
</form>
<script type="application/javascript">
	function showHideMarkersCat(cat, checkbox) {
		for(var i=0; i<markers_settings.length; i++) {
			mrk = markers_settings[i].mrk;
			cats = markers_settings[i].cats;
			for(var j=0; j<cats.length; j++) {
				if( cat==cats[j] ) {
					mrk.setVisible( checkbox.checked );
				}
			}
		}
	}

	function showHideMarkersSit(sit, checkbox) {
		for(var i=0; i<markers_settings.length; i++) {
			mrk = markers_settings[i].mrk;
			sits = markers_settings[i].sits;
			for(var j=0; j<cats.length; j++) {
				if( sit==sits[j] ) {
					mrk.setVisible( checkbox.checked );
				}
			}
		}
	}
</script>
<p>Filtros</p>
<table>
	<tr>
	<td><b>Categorias</b></td>
	<td>
<?php
	foreach ($categorias as $cat) {
		echo "<input type=checkbox checked=checked name=cat".$cat->id." value=".$cat->id." onClick='showHideMarkersCat(".$cat->id.", this);'>".$cat->nome."<br>";
	}
?>		
	</td>
	<td><b>Situações</b></td>
	<td>
<?php
	foreach ($situacoes as $sit) {
		echo "<input type=checkbox checked=checked name=sit".$sit->id." value=".$sit->id." onClick='showHideMarkersSit(".$sit->id.", this);'>".$sit->descricao."<br>";
	}
?>		
	<td>
	</tr>
</table>