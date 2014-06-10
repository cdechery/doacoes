<p>De acordo com seus Interesses cadastrados em nosso site, estamos enviando este email com Itens nas categorias que você configurou.</p>
<?php
	$path = $params['upload']['path'];
	foreach ($itens as $item) {
		$img = "images/default_item_img.jpg";
		if( !empty($item['nome_arquivo']) ) {
			$img = $path.$item['nome_arquivo'];
		}
?>
<div style="float: left">
<img src="<?php base_url($img)?>"><br>
<?php echo $item['titulo']?>
</div>
<?php
	} // foreach

	$item_ids = array();
	foreach ($items as $item) {
		$item_ids[] = $item['id'];
	}

	$url = base_url('item/listar/'.implode('/', $item_ids));

?>
Para ver mais detalhes sobre os itens e entrar em contato com os doadores, clique <a href="<?php echo $url?>">aqui</a>.