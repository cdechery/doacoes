<?php
	$maxItems = 3;
	$tamMaxInteresses = 30;

	$avatar = user_avatar($udata['avatar'], 40);

	$arrItems = array();
	foreach ($items as $item) {
		if( $item->status != 'A' ) continue;
		
		$arrItems[ $item->item_id ]['titulo'] = $item->titulo;
		$arrItems[ $item->item_id ]['descricao'] = $item->descricao;
		if( !empty($item->nome_arquivo ) ) {
			$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
		}
	}

	$out_inters = "";
	$tooltip_inters = "";

	foreach($interesses as $inter) {
		$len = strlen($inter->categoria . $out_inters);

		if( $inter->fg_ativo=="S" && $len < $tamMaxInteresses ) {
			$out_inters .= $inter->categoria.", ";
		} else if ( $len > $tamMaxInteresses ) {
			$tooltip_inters .= $inter->categoria.", ";
		}
	}
	$out_inters = rtrim($out_inters, ", ");
	$tooltip_inters = rtrim($tooltip_inters, ", ");

	if( !empty($out_inters) ) {
		$out_inters = "Interessado em: ".$out_inters;
		if( strlen($tooltip_inters)>0 ) {
			$out_inters .= " e <a href='#' id='iw_inters' title='".$tooltip_inters."'>outros</a>";
		}
	} else {
		$out_inters = "Interessado em: <u>não determinado</u>";
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
<script type="text/javascript">
	$('#iw_inters').tipsy( {gravity: 'ne', fade: true, opacity: 0.8 }  );
</script>