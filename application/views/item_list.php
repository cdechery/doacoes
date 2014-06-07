<div id="show_itens" class="clearfix">
<?php
	foreach ($items as $item) {
?>
	<div class="item_single">
<?php
		if( !empty($item->nome_arquivo) ) {
				$thumb = thumb_filename($item->nome_arquivo, 200);
?>
			<img src="<?php echo base_url("files/".$thumb)?>">
<?php
		} // if imagem
?>	
		<div>
			<h3><a href="<?php echo base_url('item/map_view/'.$item->id)?>" class='itembox fancybox.ajax' data-itemid='".$item_id."'><?php echo $item->titulo ?></a></h3>
			<p><?php echo $item->descricao ?></p>
		</div>
<?php
		if( $login_data['logged_in'] ) {
?>
		<div>
			<input type="button" value="Eu quero!" class='itembox fancybox.ajax' href="<?php echo base_url("email/quer_item/".$item->id)?>">
		</div>
<?php
		} // login
?>
	</div>
<?php
	} // for
?>	
</div>