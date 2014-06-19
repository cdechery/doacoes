<header class="clearfix">
	<h2>Itens</h2>
	<a href="#" class="item-novo" onClick="location.href='<?php echo base_url('item/novo')?>';"><i class="fa fa-plus"></i>&nbsp;&nbsp;adicionar</a>
</header>

<div id="show_itens" class="clearfix">

	<?php
		foreach ($items as $item_id => $item) {
	?>
		<div class="item_single">
			<button class="itemdel" data-itemid="<?php echo $item_id; ?>"><i class="fa fa-times"></i></button>
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
				<button class="item-modify" data-itemid="<?php echo $item_id; ?>" title="Editar Item"><i class="fa fa-pencil"></i></button>
				<?php if ($item['data']->status === 'I'): ?>
					<button class="item-status active" data-itemid="<?php echo $item_id; ?>" data-status="I" title="Item Ativo"><i class="fa fa-thumbs-o-up"></i></button>
				<?php else: ?>
					<button class="item-status" data-itemid="<?php echo $item_id; ?>" data-status="0" title="Item Inativo"><i class="fa fa-thumbs-o-down"></i></button>
				<?php endif; ?>
			</div>
		</div>
	<?php
		}
	?>	

</div>