<?php
	
	$maxItems = 3;
	$path = $params['upload']['path'];
	$width = "300";
	/*if( isset($data['images']) && count($data['images'])>2 ) {
		$width = "400";
	}*/

	$avatar = user_avatar( $udata['avatar'], 40 );

	$arrItems = array();
	$arrCats = array();
	foreach ($items as $item) {
		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

?>

<h3>
	<img src="<?php echo $avatar?>"> <span class="username"><?php echo $udata['nome']?></span> tem <?php echo count($arrItems)?> itens para doar.
</h3>

<?php
	
	$numItems = 0;
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) break;
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 60);
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens' title='".$item['descricao']."'><img src='".base_url()."files/".$thumb."''></a>";
		} else {
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens' title='".$item['descricao']."'><img src='".base_url()."images/default_item_img.gif' style='width:60px;height:60px;'></a>";
		}
	}

?>