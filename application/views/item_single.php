<div class="item_single">
<?php
	if( count($imagens) ) {
		foreach ($imagens as $img) {
			$thumb = thumb_filename($img, 80);
?>
		<img src="<?php echo base_url("files/".$thumb)?>">
<?php
		}
	}
?>	
	<div>
		<h3><?php echo $data->titulo ?></h3>
		<p><?php echo $data->descricao ?></p>
	</div>
</div>