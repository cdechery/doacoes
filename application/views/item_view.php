<header>
	<h3><?php echo $idata['titulo']?></h3>
</header>
<div id="main">
	<p><?php echo nl2br(wordwrap($idata['descricao'],60))?></p>
	<div class="imgs">
	<?php
		if( isset($imgdata) && count($imgdata)>0 ) {
			foreach ($imgdata as $img) {
	?>
		<a href="<?php echo user_img_url($img->nome_arquivo)?>" class="fancybox" rel="<?php echo $idata['id']?>" title="<?php echo $idata['titulo']?>"><img src="<?php echo item_image($img->nome_arquivo, 120)?>"></a>
	<?php
			}
		}
	?>
	</div>
	<?php if( $login_data['logged_in'] ): ?>
	<div style="height: 30px;">
		<?php echo meinteressa_button( $idata['id'] ); ?>
	</div>
	<?php endif; ?>
</div>