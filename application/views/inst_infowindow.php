<?php
	$maxItems = 3;

	$avatar = user_avatar($udata['avatar'], 40);

	$arrItems = array();
	foreach ($items as $item) {
		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

	$out_inters = "";
	foreach($interesses as $inter) {
		if( $inter->fg_ativo=="S" ) {
			$out_inters .= $inter->categoria.", ";
		}	
	}
	$out_inters = rtrim($out_inters, ", ");

	if( !empty($out_inters) ) {
		$out_inters = "Interessado em: ".$out_inters;
	} else {
		$out_inters = "Interessado em: <i>não determinado</i>";
	}
?>

<h3>
	<img src="<?php echo $avatar?>"> <span class="username"><?php echo $udata['nome']?></span> tem <a href="<?php echo base_url('usuario/itens/'.$udata['id'])?>"><?php echo count($arrItems)?> itens</a> para doar.
</h3>

<p><?php echo $out_inters?></p>

<?php
	
	$numItems = 0;
	$nodisplay = "";
	foreach ($arrItems as $item_id => $item) {
		$numItems++;
		if( $numItems>$maxItems ) $nodisplay = "style='display:none;'";
		if( isset($item['imagens']) ) {
			$thumb = thumb_filename($item['imagens'][0], 60);
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".user_img_url($thumb)."''></a>";
		} else {
			echo "<a ".$nodisplay." href='".base_url('item/map_view/'.$item_id)."' class='itembox fancybox.ajax' data-itemid='".$item_id."' rel='pessoas_itens'><img src='".img_url('default_item_img_60.gif')."''></a>";
		}
	}

?>
<?php if( $login_data['logged_in'] ): ?>
	<div id="envia-msg">
		<a href="<?php echo base_url('email/contato_inst/'.$udata['id'])?>" class="itembox fancybox.ajax">Enviar Mensagem</a>
	</div>
<?php endif; ?>

<nav>
	<a href="#" onClick="nextMarker();">próximo&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></a>
	<a href="#" onClick="prevMarker();"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;anterior</a>
</nav>