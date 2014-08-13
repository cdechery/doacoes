<?php if( !empty($user) ): ?>

	<header id="user_itens" class="clearfix">
		<h3><img src="<?php echo user_avatar($user['avatar'], 40) ?>">
		Listando itens do <?php echo $user['nome']?></h3>
	</header>

<?php endif; ?>

<div id="show_itens" class="clearfix">

<?php
	if( count($items)==0 ) {
		echo "<h4>Nenhum item para exibir</h4>";		
	}

	foreach ($items as $item_id => $item) {
?>
		<div class="item_single">
			<div class="thumbs">
				<?php if( count($item['imagens']) ) {
					foreach ($item['imagens'] as $file) {
						$thumb = thumb_filename($file, 120);
						echo "<a href='".user_img_url($file)."' class='fancybox' rel='fotos_".$item_id."'><img src=".user_img_url($thumb)." /></a>";
					}
				} ?>
			</div>
			<h3><?php echo $item['data']->titulo ?></h3>
			<p><?php echo $item['data']->descricao ?></p>
			<div class="action">
				
				<?php if ($item['data']->status == 'D'): { ?>
					<button class="item-list active"><i class="fa fa-check-square-o"></i>&nbsp;Este item já foi Doado</button>
				<?php } elseif ( $login_data['logged_in'] ) : ?>
					<button class='itembox active fancybox.ajax' href="<?php echo base_url("email/quer_item/".$item_id)?>">Me interessa!</button>
				<?php endif; ?>
				
			</div>
		</div>
<?php
	} // foreach items
?>	
</div>
<script type="text/javascript">
	$(".itembox").fancybox({
		wrapCSS		: 'fancybox-item',
		padding		: 25,
		fitToView	: false,
		width		: '400px',
		height		: '370px',
		autoSize	: false,
		type		: 'ajax',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});	
</script>