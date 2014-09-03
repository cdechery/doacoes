<script type="text/javascript">
	$(document).ready( function() {
		if( typeof(Storage) !== "undefined" ) {
			if( !localStorage.welcomeShown ) {
				localStorage.setItem('welcomeShown', 1);
				setTimeout( function() {
					$('#welcome').fadeIn('slow');
				}, 1000);
			}
			// para forçar exibição. comitar comentado
			//localStorage.clear();
		}
	});
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});

	$(".itembox").fancybox({
		wrapCSS		: 'fancybox-item',
		padding		: 0,
		fitToView	: false,
		minWidth	: '500px',
		minHeight	: '220px',
		autoSize	: true,
		type		: 'ajax',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
</script>

<section id="home" class="contents">

	<section id="map">
		
		<div id="welcome" style="display: none">
			<div id="texto_apres">
				<div id="close">X</div>
				<div id="texto">
					<h3>Bem-vindo ao Interessa.org</h3>
					<p>Se você tem algo sobrando na sua casa e está procurando para quem doar, esse é o lugar para você. Fique a vontade para procurar tudo que estiver disponível para doação e entrar em contato com o doador. <br><br>O objetivo aqui é facilitar a vida de pessoas e instituições a se encontrarem e doar o que não mais serve para quem Interessa.</p>
					<p>Para saber melhor como funciona e como você pode participar clique <a href="<?php echo base_url('sobre')?>">aqui</a>.</p>
					<p>Se já quiser se começar a usar acesse as opções abaixo:</p>
					<div class="buttons">
						<a class="escolhetipo_box active fancybox.ajax" href="<?php echo base_url('usuario/escolhe_tipo')?>">cadastre-se agora</a>&nbsp;&nbsp;
						ou entre pelo&nbsp;&nbsp;<a style="vertical-align: bottom" class="fb-login-button" scope="email,public_profile" data-size="icon" data-show-faces="false"></a>
					</div>
				</div>
			</div>
		</div>

		<form name="__map">
			<?php echo $map['js']; ?>
			<?php echo $map['html']; ?>
		</form>

	</section>
	
	<div class="wrap960">
		
		<div id="filtros">

			<div id="filtro_texto" class="checks" style="display: none;">
				<?php
					$centro = $params['mapa']['default_loc_name'];
					if( $login_data['logged_in'] ) {
						$centro = "Sua localização";
				} ?>
				<p>Exibindo: <span id="exibindo_mapa"><?php echo $centro?></span></p>
				<input type="text" placeholder="Digite aqui uma cidade ou bairro" id="mapCenterTextBox">
				<?php if( $login_data['logged_in']) : ?>
					<p>Retornar para <a href="#" onClick="map.setCenter( user_location ); $('#exibindo_mapa').html('Sua localização');">sua localização</a></p>
				<?php endif; ?>
			</div>
			<?php
				array_shift($params['raios_busca']);
			?>
			<div id="botoes">
				<button id="local">Mudar localização</button>
				<?php if( $login_data['logged_in'] ): ?>
					<button id="raios" title="<?php echo implode(" > ", $params['raios_busca'])?>">Mostrar/esconder raios</button>
				<?php endif; ?>
			</div>
			<script type="text/javascript">
				$('#raios').tipsy({ gravity: 's', opacity: 0.9});
			</script>

			<h4>Filtrar resultados</h4>

			<span>Mostrar&nbsp;&nbsp;</span><i class="fa fa-angle-right"></i>
			<ul>
				<li id="show-all">Tudo</li>
				<li id="show-pessoas">Pessoas</li>
				<li id="show-inst">Instituições</li>
			</ul>
			
			<span>Filtrar&nbsp;&nbsp;</span><i class="fa fa-angle-right"></i>
			<ul>
				<li id="filter-item">
					Itens
					<div id="filtro_itens" class="checks" style="display:none;" class="clearfix">
						<div class="limpar">
							<button onClick="limparFiltroItem();">Limpar</button>
						</div>
						<h4>Estas Categorias:</h4>
						<div class="col">
							<?php
								foreach ($categorias as $cat) {
									if ($cat->id <= 5) {
										echo "<input class='filterItemCat' type=checkbox name=cat".$cat->id." value=".$cat->id." onClick='filterItem();'>&nbsp;&nbsp;".$cat->nome."<br>";
									}
								}
							?>
						</div>
						<div class="col">
							<?php
								foreach ($categorias as $cat) {
									if ($cat->id > 5) {
										echo "<input class='filterItemCat' type=checkbox name=cat".$cat->id." value=".$cat->id." onClick='filterItem();'>&nbsp;&nbsp;".$cat->nome."<br>";
									}
								}
							?>
						</div>
						<br clear="all">
						<div id="sit">
							<h4>E nestas Situações:</h4>
							<?php
								foreach ($situacoes as $sit) {
									echo "<input class='filterItemSit' type=checkbox name=sit".$sit->id." value=".$sit->id." onClick='filterItem();'>&nbsp;&nbsp;".$sit->descricao."&nbsp;&nbsp;&nbsp;";
								}
							?>
						</div>
					</div>
				</li>
				<li id="filter-inst">
					Interesses
					<div id="filtro_ints" class="checks" style="display: none;" class="clearfix">
						<h4>Apenas interessados em:</h4>
						<div class="limpar">
							<button onClick="limparFiltroInts();">Limpar</button>
						</div>
						<div class="col">
							<?php
								foreach ($categorias as $cat) {
									if ($cat->id <= 5) {
										echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInt();'>&nbsp;&nbsp;".$cat->nome."<br>";
									}
								}
							?>
						</div>
						<div class="col">
							<?php
								foreach ($categorias as $cat) {
									if ($cat->id > 5) {
										echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInt();'>&nbsp;&nbsp;".$cat->nome."<br>";
									}
								}
							?>
						</div>
					</div>
				</li>
			</ul>
		
		</div>		