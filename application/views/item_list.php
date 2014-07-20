<script>
$(document).ready(function() {
	$(".itembox").fancybox({
		wrapCSS		: 'fancybox-item',
		padding		: 25,
		width	: 400,
		// maxHeight	: 410,
		fitToView	: false,
		// width		: '90%',
		// height		: '90%',
		autoSize	: true,
		type		: 'ajax',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
})
</script>
<div id="show_itens" class="clearfix">
<?php
	foreach ($items as $item_id => $item) {
?>
		<div class="item_single">
			<div class="thumbs">
				<?php if( count($item['imagens']) ) {
					foreach ($item['imagens'] as $file) {
						$thumb = thumb_filename($file, 120);
						echo "<img src=".base_url("files/".$thumb)." />";
					}
				} ?>
			</div>
			<h3><?php echo $item['data']->titulo ?></h3>
			<p><?php echo $item['data']->descricao ?></p>
			<div class="action">
				
				<?php if ($item['data']->status == 'D'): { ?>
					<button class="item-list active"><i class="fa fa-check-square-o"></i>&nbsp;Este item já foi Doado</button>
				<?php } elseif ( $login_data['logged_in'] ) : ?>
				<input type="button" value="Eu quero!" class='itembox fancybox.ajax' href="<?php echo base_url("email/quer_item/".$item_id)?>">
				<?php endif; ?>
				
			</div>
		</div>
<?php
	} // foreach items
?>	
</div>