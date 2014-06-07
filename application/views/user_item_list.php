<input type="button" value="Novo Item" onClick="location.href='<?php echo base_url('item/novo')?>';">

<div id="show_itens" class="clearfix">

	<?php
		foreach ($items as $item_id => $item) {
	?>
		<div class="item_single">
		<?php
			if( count($item['imagens']) ) {
					$thumb = thumb_filename($item['imagens'][0], 220);
		?>
				<img src="<?php echo base_url("files/".$thumb)?>">
		<?php
			} // if imagens
		?>	
			<div>
				<h3><?php echo $item['data']->titulo ?></h3>
				<p><?php echo $item['data']->descricao ?></p>
			</div>
			<div>
				<input type="button" value="Modificar" onClick="location.href='<?php echo base_url('item/modify/'.$item_id)?>';">
				<input type="button" class="itemdel" value="Apagar" data-itemid="<?php echo $item_id; ?>">
			</div>
		</div>
	<?php
		}
	?>	

</div>