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
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

?>

<h3 style="margin:0 0 10px;">
	<img src="<?php echo $avatar?>" style="width:40px;height:40px;"> <span class="username"><?php echo $udata['nome']?></span> tem <?php echo count($arrItems)?> itens para doar.
</h3>

<?php
	
	$numItems = 0;
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) break;
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 80);
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' title='".$item['descricao']."'><img src='".base_url()."files/".$thumb."'' style='width:60px;height:60px;border:1px solid #ccc;'></a>";
		} else {
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."'>".$item['titulo']."</a>";
		}
	}

?>