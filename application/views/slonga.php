<section id="map">
	<div class="wrap960">

		<div id="hide"><i class="fa fa-minus-square"></i></div>
		
		<div id="filtros">

			<header>
				<p>Filtre o conteudo do mapa:</p>
				<button onClick="showAll();">Mostrar Tudo</button>
				<button onClick="showPeople();">Itens/Pessoas</button>
				<button onClick="showInstitutions();">Instituições</button>
				<button onClick="hideRadiusCircles();">Raios</button>
			</header>

			<div id="filtro_pessoas" style="display: none;">
				<div class="col">
					<h4>Categorias</h4>
					<?php
						foreach ($categorias as $cat) {
							echo "<input class='filtroPessoaCat' type=checkbox name=cat".$cat->id." value=".$cat->id." onClick='filterPessoa();'>&nbsp;&nbsp;".$cat->nome."<br>";
						}
					?>
				</div>
				<div class="col">
					<h4>Situações</h4>
					<?php
						foreach ($situacoes as $sit) {
							echo "<input class='filtroPessoaSit' type=checkbox name=sit".$sit->id." value=".$sit->id." onClick='filterPessoa();'>&nbsp;&nbsp;".$sit->descricao."<br>";
						}
					?>
				</div>
			</div>
			
			<div id="filtro_insts" style="display: none;">
				<div class="col">
					<h4>Interessado em</h4>
					<?php
						foreach ($categorias as $cat) {
							echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInst();'>&nbsp;&nbsp;".$cat->nome."<br>";
						}
					?>
				</div>
			</div>
		
		</div>
	</div>
	
	<form name="__map">
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</form>

</section>

<section id="home" class="contents">
	<div class="wrap960">
		<?php if( !$login_data["logged_in"] ) { ?>
			<p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum
	girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo.
	Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num
	significa nadis i pareci latim. Interessantiss quisso pudia ce receita de
	bolis, mais bolis eu num gostis.</p>
			<div id="botoes">
				<a href="<?php echo base_url('login')?>" id="tenho" class="btn-gradient">
					<span>Fazer Login</span>
				</a>
				<a href="<?php echo base_url('usuario/novo')?>" id="preciso" class="btn-gradient">
					<span>Cadastrar-se</span>
				</a>
			</div>
		<?php } ?>