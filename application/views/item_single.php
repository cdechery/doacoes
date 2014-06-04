<?php

	$maxItems = 1;

	$numItems = 0;
	
	$arrItems = array();
	
	foreach ($idata as $item) {
		$arrItems[ $idata->item_id ]['titulo'] = $idata->titulo;
		$arrItems[ $idata->item_id ]['descricao'] = $idata->descricao;
		if( !empty($idata->nome_arquivo ) ) {
			$arrItems[ $idata->item_id ]['imagens'][] = $idata->nome_arquivo;
		}
	};

?>

<?php foreach ($arrItems as $id => $item): ?>
	
	<?php 
		$numItems++;
		if( $numItems > $maxItems ) break; 
	?>
	
	<div class="item_single">
		<?php if( isset($item['imagens']) ) $thumb = thumb_filename($item['imagens'][0], 220); ?>
		<img src="<?php echo base_url()."files/".$thumb; ?>" alt="<?php echo $idata->titulo; ?>">
		<div>
			<h3><?php echo $item['titulo']; ?></h3>
			<p><?php echo $item['descricao']; ?></p>
		</div>
	</div>

<?php endforeach; ?>

