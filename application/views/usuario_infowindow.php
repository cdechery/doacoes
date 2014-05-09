<?php
	$maxItems = 3;
	$path = $params['upload']['path'];
	$width = "300";
	/*if( isset($data['images']) && count($data['images'])>2 ) {
		$width = "400";
	}*/

	$avatar = $udata['avatar'];
	if( empty($avatar) ) {
		$avatar = base_url("images/default_avatar_small.gif");
	} else {
		$avatar = base_url("files/".thumb_filename($avatar, 80));
	}

	$arrItems = array();
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
			echo "<div style='float: left'><a href='".base_url('item/map_view/'.$item_id)."' class='itembox' data-fancybox-type='iframe' data-itemid='".$item_id."'><img src='".base_url()."files/".$thumb."''></a></div>";
		} else {
			echo "<div style='background-color: lightgray; width:80px; height:80px; margin: 10px; float: left'><a href='".base_url('item/map_view/'.$item_id)."' class='itembox' data-fancybox-type='iframe' data-itemid='".$item_id."'>".$item['titulo']."</a></div>";
		}
	}
?>
</div>