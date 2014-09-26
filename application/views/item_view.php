<script type="text/javascript">
$(document).ready( function() {
	$.fancybox.update();
	FB.XFBML.parse();
});
</script>
<header>
	<h3><?php echo $idata['titulo']?>&nbsp;&nbsp;<button class="situacao"><?php echo $sit?></button></h3>
</header>
<div id="main">
	<p style="min-height: 40px;"><?php echo nl2br(wordwrap($idata['descricao'],60))?></p>
	<?php if( isset($imgdata) && count($imgdata)>0 ): ?>
	<div class="imgs">
		<?php foreach ($imgdata as $img): ?>
		<a href="<?php echo user_img_url($img->nome_arquivo)?>" class="fancybox" rel="<?php echo $idata['id']?>" title="<?php echo $idata['titulo']?>"><img src="<?php echo item_image($img->nome_arquivo, 120)?>"></a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div style="height: 30px; margin-bottom: 3px;">
		<?php echo meinteressa_button( $idata['id'] ); ?>&nbsp;<div class="fb-share-button" data-layout="button" data-href="<?php echo base_url('sharefb/'.$idata['id'])?>"></div>
	</div>
</div>
