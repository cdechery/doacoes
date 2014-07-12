<p>De acordo com seus Interesses cadastrados em nosso site, estamos enviando este email com Itens nas categorias que você configurou.</p>
<?php
	$path = $params['upload']['path'];
	foreach ($itens as $item) {
		$img = item_image($item['nome_arquivo'], 80);
?>
<div style="float: left">
<img src="<?php echo $img?>"><br>
<?php echo $item['id']."-".$item['titulo']?>
</div>
<?php
	} // foreach

	$item_ids = array();
	foreach ($itens as $item) {
		$item_ids[] = $item['id'];
	}
	$item_ids = array_unique($item_ids);

	$url = base_url('item/listar/'.implode('/', $item_ids));

?>
<br>
<p style="clear: both">
Para ver mais detalhes sobre os itens e entrar em contato com os doadores, clique <a href="<?php echo $url?>">aqui</a>.
</p>