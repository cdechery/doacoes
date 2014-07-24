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
<div id="iw_current" style="width:300px; display: box;">
	<h3>
		<img src="<?php echo $avatar?>"> <span class="username"><?php echo $udata['nome']?></span> tem <a style="text-decoration: underline;" href="<?php echo base_url('usuario/itens/'.$udata['id'])?>"><?php echo count($arrItems)?> itens</a> para doar.
	</h3>
<?php
	
	$numItems = 0;
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) break;
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 60);
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".base_url()."files/".$thumb."''></a>";
		} else {
			echo "<a href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".base_url()."images/default_item_img.gif' style='width:60px;height:60px;'></a>";
		}
	}
?>
</div>
<div style="float: left; width: 50%; text-align: left;">
	<a href="#" onClick="prevMarker();">< anterior</a>
</div>
<div style="float: left; width: 50%; text-align: right;">
	<a href="#" onClick="nextMarker();">próximo ></a>
</div>