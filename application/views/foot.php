		<!-- </div> --> <!-- roundbox -->
	</div><!-- wrap960 -->
</section>	

<footer>
	<div class="wrap960">
		<p style="font-size: small; text-align: center;"><a href="<?php echo base_url('termos')?>">Termos de Serviço</a> | <a href="<?php echo base_url('sobre')?>">Sobre o site</a> | <a href="<?php echo base_url('contato')?>">Fale conosco</a> |
		<?php if( $login_data['logged_in'] ): ?>
		 <a href="<?php echo base_url('usuario/logout')?>">Sair</a>
		<?php else: ?>
		 <a id="escolhe_tipo_link" href="<?php echo base_url('usuario/novo')?>" class="escolhetipo_box fancybox.ajax">Faça seu cadastro</a></p>
		<?php endif; ?>
		</p>
	</div>
</footer>
 
 <?php if( ENVIRONMENT!='production' ) { ?>
	<div id="error-details" style="display: none">&nbsp;</div>
<?php } // if ENV ?>
</body>
</html>