<?php
	$maxItems = 3;

	$avatar = user_avatar( $udata['avatar'], 40 );

	$arrItems = array();
	foreach ($items as $item) {
		if( $item->status != 'A' ) continue;

		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

	$para_doar = "";
	$qtd_itens = count($arrItems);
	if( $qtd_itens==1 ) {
		$para_doar = "possui <a href='".base_url('usuario/itens/'.$udata['id'])."'>um item</a> para doar";
	} else {
		$para_doar = "possui <a href='".base_url('usuario/itens/'.$udata['id'])."'>".$qtd_itens." itens</a> para doar";
	}

?>
	
<header>
	<img src="<?php echo $avatar?>"> <span class="username"><?php echo $udata['nome']?></span> <?php echo $para_doar?>
</header>
<br/>
<?php
	
	$numItems = 0;
	$nodisplay = "";
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) $nodisplay = "style='display:none;'";
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 60);
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='foto_item itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens' title='".$item['titulo']."'><img src='".user_img_url($thumb)."''></a>";
		} else {
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='foto_item itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens' title='".$item['titulo']."'><img src='".img_url('default_item_img_60.gif')."'></a>";
		}
	}
?>

<nav>
	<a href="#" onClick="nextMarker();">próximo&nbsp;&nbsp;<i class="fa fa-angle-right"></i></a>
	<a href="#" onClick="prevMarker();"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;anterior</a>
</nav>
<script type="text/javascript">
	$('.foto_item').tipsy( {opacity: 1});
</script>