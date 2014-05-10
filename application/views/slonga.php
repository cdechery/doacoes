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

	var radiusShown = true;
	function hideRadiusCircles() {
		radiusShown = !radiusShown;
		for(var i=0; i<radiusCircles.length; i++) {
			radiusCircles[i].setVisible(radiusShown);
		}
	}
</script>

<input type=button value="Esconder/Mostrar Raios" onClick="hideRadiusCircles();" style="display: none;">

<div id="filtros" style="display: none;">
	<h3>Categorias</h3>
	?php
		foreach ($categorias as $cat) {
			echo "<input type=checkbox checked=checked name=cat".$cat->id." value=".$cat->id." onClick='showHideMarkersCat(".$cat->id.", this);'>".$cat->nome."<br>";
		}
	?>
	<h3>Situações</h3>
	<?php
		foreach ($situacoes as $sit) {
			echo "<input type=checkbox checked=checked name=sit".$sit->id." value=".$sit->id." onClick='showHideMarkersSit(".$sit->id.", this);'>".$sit->descricao."<br>";
		}
	?>	
</div>

<section id="map">
	
	<form name="__map">
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</form>

</section>

<section id="contents">
	<div class="wrap960">
		<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
	</div>
</section>

