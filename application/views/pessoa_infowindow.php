<?php
	$maxItems = 3;
	$path = $params['upload']['path'];
	$width = "300";
	/*if( isset($data['images']) && count($data['images'])>2 ) {
		$width = "400";
	}*/

	$avatar = user_avatar( $udata['avatar'], 80 );

	$arrItems = array();
	$arrCats = array();
	foreach ($items as $item) {
		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}
?>
<div style="width: <?php echo $width;?>px; text-align: left;">
<img src="<?php echo $avatar?>"> <?php echo $udata['nome']?> tem <?php echo count($arrItems)?> itens para doar.<br>
</div>

<?php
	$numItems = 0;
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) break;
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 80);
			echo "<div style='float: left'><a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."'><img src='".base_url()."files/".$thumb."''></a></div>";
		} else {
			echo "<div style='background-color: lightgray; width:80px; height:80px; margin: 10px; float: left'><a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."'>".$item['titulo']."</a></div>";
		}
	}
?>
</div>