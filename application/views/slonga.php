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
	
</div>

<section id="map">

	<div class="wrap960">
		<div id="filtros">
			<h3>Categorias</h3>
			<?php
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
			<input type=button value="Esconder/Mostrar Raios" onClick="hideRadiusCircles();" style="display: none;">
		</div>
	</div>
	
	<form name="__map">
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</form>

</section>

<section id="contents">
	<div class="wrap960">
		<p>Mussum ipsum
cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois
divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum
girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo.
Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num
significa nadis i pareci latim. Interessantiss quisso pudia ce receita de
bolis, mais bolis eu num gostis.</p>
		<div id="botoes">
			<a href="#" id="tenho" class="btn">
				<span><b>Tenho&nbsp;&nbsp;&nbsp;<i class="fa fa-thumbs-o-up"></i></b></span>
			</a>
			<a href="#" id="preciso" class="btn">
				<span><b>Preciso&nbsp;&nbsp;&nbsp;<i class="fa fa-thumbs-o-down"></i></b></span>
			</a>
		</div>
	</div>
</section>

