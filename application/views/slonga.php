<style>
#busca_mapa {
	width:350px;
	background-color: gray;
	min-height:90px;
	background-image:url('../images/bg_filtros.png');
	border-radius:6px;
	padding:15px;
	position:absolute;
	left:150px;
	top:30px;
	font-size:.9em;
	color:#fff;z-index:2
}
</style>
<section id="map">
	<div class="wrap960">

		<div id="hide"><i class="fa fa-minus-square"></i></div>

		<div id="busca_mapa">
		<?php
			$centro = $params['mapa']['default_loc_name'];
			if( $login_data['logged_in'] ) {
				$centro = "Sua localiza��o";
			}
		?>
			Exibindo: <div id="exibindo_mapa"><?php echo $centro?></div><br>
			<input type="text" style="color: black;" placeholder="Digite aqui uma cidade ou bairro" id="mapCenterTextBox">
		<?php if( $login_data['logged_in']) : ?>
			Retornar para <a href="#" onClick="map.setCenter( user_location );">Sua localiza��o</a>
		<?php endif; ?>
		</div>
		
		<div id="filtros">

			<header>
				<p>Filtre o conteudo do mapa:</p>
				<button onClick="showAll();">Mostrar Tudo</button>
				<button onClick="showPeople();">Itens/Pessoas</button>
				<button onClick="showInstitutions();">Institui��es</button>
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
					<h4>Situa��es</h4>
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
			<p>Bem-vindo ao Interessa.org. Se voc� tem algo sobrando na sua casa e est� procurando para quem doar, esse � o lugar para voc�. Fique a vontade para procurar tudo que estiver dispon�vel para doa��o e entrar em contato com o doador. O objetivo aqui � facilitar a vida de pessoas e institui��es a se encontrarem e doar o que n�o mais serve para quem Interessa.</p>
			<div id="botoes">
				<a href="<?php echo base_url('login')?>" id="tenho" class="btn-gradient">
					<span>Fazer Login</span>
				</a>
				<a href="<?php echo base_url('usuario/novo')?>" id="preciso" class="btn-gradient">
					<span>Cadastrar-se</span>
				</a>
			</div>
		<?php } ?>