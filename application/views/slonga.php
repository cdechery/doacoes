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

			<div id="filtro_pessoas" style="display: none;" class="clearfix">	
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
			
			<div id="filtro_insts" style="display: none;" class="clearfix">
				<div class="col">
					<h4>Interessado em</h4>
					<?php
						foreach ($categorias as $cat) {
							echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInst();'>&nbsp;&nbsp;".$cat->nome."<br>";
						}
					?>
				</div>
			</div>

			<div id="busca_mapa">
				<?php
					$centro = $params['mapa']['default_loc_name'];
					if( $login_data['logged_in'] ) {
						$centro = "Sua localização";
				} ?>
				<p>Exibindo: <span id="exibindo_mapa"><?php echo $centro?></span></p>
				<input type="text" placeholder="Digite aqui uma cidade ou bairro" id="mapCenterTextBox">
				<?php if( $login_data['logged_in']) : ?>
					<p>Retornar para <a href="#" onClick="map.setCenter( user_location );">Sua localização</a></p>
				<?php endif; ?>
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
		<h3>Bem-vindo ao Interessa.org</h3>
		<p>Se você tem algo sobrando na sua casa e está procurando para quem doar, esse é o lugar para você. Fique a vontade para procurar tudo que estiver disponível para doação e entrar em contato com o doador. <br>O objetivo aqui é facilitar a vida de pessoas e instituições a se encontrarem e doar o que não mais serve para quem Interessa.</p>
		<p>Para saber melhor como funciona e como participar do Interessa.org visite <a href="<?php echo base_url('sobre')?>">nossa apresentação.</a></p>
		<?php if( !$login_data["logged_in"] ) { ?>
			<div id="botoes">
				<a href="<?php echo base_url('login')?>" id="tenho" class="btn-gradient">
					<span>Fazer Login</span>
				</a>
				<a href="<?php echo base_url('usuario/novo')?>" id="preciso" class="btn-gradient">
					<span>Cadastrar-se</span>
				</a>
			</div>
		<?php } ?>