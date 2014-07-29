<section id="map">
	
<?php
	$welcomeShown = $this->session->userdata('WelcomeShown');
	if( !$login_data['logged_in'] && !$welcomeShown ) {
?>
	<div id="texto_apres_cont">
		<div id="texto_apres">
			<div id="close">X</div>
			<div id="texto">
				<h3>Bem-vindo ao Interessa.org</h3>
				<p>Se você tem algo sobrando na sua casa e está procurando para quem doar, esse é o lugar para você. Fique a vontade para procurar tudo que estiver disponível para doação e entrar em contato com o doador. <br><br>O objetivo aqui é facilitar a vida de pessoas e instituições a se encontrarem e doar o que não mais serve para quem Interessa.</p>
				<p>Para saber melhor como funciona e como você pode participar clique <a href="<?php echo base_url('sobre')?>">aqui</a>.</p>
				<p>Se já quiser se cadastrar use os botões abaixo:</p>
				<input type="button" class="escolhetipo_box fancybox.ajax" value="Cadastrar" href="<?php echo base_url('usuario/escolhe_tipo')?>"> <button>Botão do Facebook</button>
			</div>
		</div>
	</div>
<?php
		$this->session->set_userdata('WelcomeShown', TRUE);
	}
?>	
	<form name="__map">
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</form>

</section>

<section id="home" class="contents">
	
	<div class="wrap960">
		
		<div id="filtros">

			<div id="filtro_texto" class="checks" style="display: none;">
				<?php
					$centro = $params['mapa']['default_loc_name'];
					if( $login_data['logged_in'] ) {
						$centro = "Sua localização";
				} ?>
				<p>Exibindo: <span id="exibindo_mapa"><?php echo $centro?></span></p>
				<input type="text" style="color: black" placeholder="Digite aqui uma cidade ou bairro" id="mapCenterTextBox">
				<?php if( $login_data['logged_in']) : ?>
					<p>Retornar para <a href="#" onClick="map.setCenter( user_location ); $('#exibindo_mapa').html('Sua localização');">sua localização</a></p>
				<?php endif; ?>
			</div>

			<div id="botoes">
				<button id="local">Mudar localização</button>
				<?php if( $login_data['logged_in'] ): ?>
					<button id="raios">Mostrar/esconder raios</button>
					<?php
						// REVER
						// array_shift($params['raios_busca']);
						// echo implode(" > ", $params['raios_busca']);
					?>
				<?php endif; ?>
			</div>

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
						<div class="col">
							<h4>Categorias</h4>
							<?php
								foreach ($categorias as $cat) {
									echo "<input class='filterItemCat' type=checkbox name=cat".$cat->id." value=".$cat->id." onClick='filterItem();'>&nbsp;&nbsp;".$cat->nome."<br>";
								}
							?>
						</div>
						<div class="col">
							<h4>Situações</h4>
							<?php
								foreach ($situacoes as $sit) {
									echo "<input class='filterItemSit' type=checkbox name=sit".$sit->id." value=".$sit->id." onClick='filterItem();'>&nbsp;&nbsp;".$sit->descricao."<br>";
								}
							?>
						</div>
					</div>
				</li>
				<li id="filter-inst">
					Interesses
					<div id="filtro_ints" class="checks" style="display: none;"class="clearfix">
						<div class="col">
							<h4>Interessado em</h4>
							<?php
								foreach ($categorias as $cat) {
									echo "<input class='filtroInstCat' type=checkbox name=icat".$cat->id." value=".$cat->id." onClick='filterInt();'>&nbsp;&nbsp;".$cat->nome."<br>";
								}
							?>
						</div>
					</div>
				</li>
			</ul>
		
		</div>