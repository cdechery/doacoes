<section id="map">

	<div class="wrap960">
		<div id="filtros">
			<input type=button value="Mostrar Tudo" onClick="showAll();"><br>
			<input type=button value="Itens/Pessoas" onClick="showPeople();"> <input type=button value="Instituições" onClick="showInstitutions();">

			<div id="filtro_pessoas" style="display: none;">
			<h4>Mostrar Apenas</h4>
			<h5>Categorias</h5>
			<?php
				foreach ($categorias as $cat) {
					echo "<input class='filtroPessoaCat' type=checkbox name=cat".$cat->id." value=".$cat->id." onClick='filterPessoa();'>&nbsp;&nbsp;".$cat->nome."<br>";
				}
			?>
			<h4>Situações</h4>
			<?php
				foreach ($situacoes as $sit) {
					echo "<input class='filtroPessoaSit' type=checkbox name=sit".$sit->id." value=".$sit->id." onClick='filterPessoa();'>&nbsp;&nbsp;".$sit->descricao."<br>";
				}
			?>
			</div>
			<div id="filtro_insts" style="display: none;">
			<h4>Mostrar Apenas</h4>
			<h4>Interessado em</h4>
			<?php
				foreach ($categorias as $cat) {
					echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInst();'>&nbsp;&nbsp;".$cat->nome."<br>";
				}
			?>
			</div>
			<div id="filtro_texto">
				Use os filtros para bla bla bla lorem ipsum mussum frofens
			</div>
			<input type=button value="Esconder/Mostrar Raios" onClick="hideRadiusCircles();">
		</div>
	</div>
	
	<form name="__map">
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</form>

</section>

<?php /* home logado */ if( isset($login_data) && !$login_data["logged_in"] ) { ?>

	<section id="home" class="contents">
		<div class="wrap960">
			<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum
	girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo.
	Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num
	significa nadis i pareci latim. Interessantiss quisso pudia ce receita de
	bolis, mais bolis eu num gostis.</p>
			<div id="botoes">
				<a href="<?php echo base_url('usuario/new_user/P')?>" id="tenho" class="btn-gradient">
					<span>Tenho&nbsp;&nbsp;&nbsp;<i class="fa fa-thumbs-o-up"></i></span>
				</a>
				<a href="<?php echo base_url('usuario/new_user/I')?>" id="preciso" class="btn-gradient">
					<span>Preciso&nbsp;&nbsp;&nbsp;<i class="fa fa-thumbs-o-down"></i></span>
				</a>
			</div>
		</div>
	</section>

<?php } ?>

