<?php
	
	$arrImg = array();
	
	foreach ($idata as $item) {
		if( !empty($idata->nome_arquivo ) ) {
			$arrImg[ $idata->item_id ]['imagens'][] = $idata->nome_arquivo;
			foreach ($arrImg as $item_id => $item) {
				if( isset($item['imagens']) ) {
					$thumb = thumb_filename($item['imagens'][0], 220);
				}
			}
		}
	};

?>

<div class="item_single">
	<?php if( isset($item['imagens']) ) { ?>
		<img src="<?php echo base_url()."files/".$thumb; ?>" alt="<?php echo $idata->titulo; ?>">
	<?php } ?>
	<div>
		<h3><?php echo $idata->titulo; ?></h3>
		<p><?php echo $idata->descricao; ?></p>
	</div>
</div>