<?php
	$maxItems = 3;

	$avatar = user_avatar( $udata['avatar'], 40 );

	$arrItems = array();
	foreach ($items as $item) {
		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

?>
	
<h3>
	<img src="<?php echo $avatar?>"> <span class="username"><?php echo $udata['nome']?></span> tem <a href="<?php echo base_url('usuario/itens/'.$udata['id'])?>"><?php echo count($arrItems)?> itens</a> para doar.
</h3>

<?php
	
	$numItems = 0;
	$nodisplay = "";
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) $nodisplay = "style='display:none;'";
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 60);
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".base_url()."files/".$thumb."''></a>";
		} else {
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".base_url()."images/default_item_img.gif'></a>";
		}
	}
?>

<nav>
	<a href="#" onClick="nextMarker();">próximo&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></a>
	<a href="#" onClick="prevMarker();"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;anterior</a>
</nav>