<body>
<?php
	$descricao = $status = $titulo = "";
	$categoria_id = $situacao_id = "";
	$id = "";

	if( !empty($data) ) {
		extract($data);
	}

	if( empty($images) ) {
		$images = array();
	}

	$actions = array("insert"=>xlabel('insert'),
		"update"=>xlabel('update'));

?>
<table cellpadding=5 cellspacing=5 border=0>
	<tr>
		<td>
<?php
	$num_imgs = 0;
	$max_imgs = $params['max_item_imgs'];

	// Imagens do item, se houver
	foreach($images as $img) {
		$num_imgs++;
		$thumb = thumb_filename($img->nome_arquivo, 200);
?>
		<input type="file" name="img_<?php echo $num_imgs?>" style="display: none;" data-imgid="<?php echo $img->id?>"/>
		<a href="#" onclick="document.getElementById('img_<?php echo $num_imgs?>').click();" />
		<img alt="Alterar imagem" src="<?php echo base_url()."files/".$thumb?>" id="img_<?php echo $num_imgs?>">
		</a>
<?php			
	} //images

	// completo as imagens com a "default"
	for($i=0; $i<$max_imgs-$num_imgs; $i++) {
?>		
		<input type="file" id="img_<?php echo $i?>" name="img_<?php echo $i?>" style="display: none;"/>
		<a href="#" onclick="document.getElementById('img_<?php echo $i?>').click();" />
		<img alt="Enviar imagem" src="<?php echo base_url()."images/default_item_img.gif"?>"/>
		</a>
<?php
	}
?>
		</td>
	</tr>
	<tr>
		<td>
		<form method="POST" name="itemData" action="<?php echo base_url()?>item/<?php echo $action; ?>" id="item_<?php echo $action?>" onSubmit="clearInlineLabels(this);">
		<input type="hidden" name="id" value="<?php echo $id ?>">

		<input type="text" name="titulo" value="<?php echo $titulo ?>" size="50" title="Título" /><br>
		<select name="categ">
			<option value="">Categoria</option>
			<option value="1">Roupas</option>
			<option value="2">Móveis</option>
			<option value="3">Brinquedos</option>
		</select><br>
		<textarea name="desc" title="Descrição" rows="4" cols="50"/><?php echo $descricao?></textarea><br>
		<select name="sit">
			<option value="">Situação</option>
			<option value="1">Novo</option>
			<option value="2">Usado</option>
			<option value="3">Quebrado</option>
		</select>

		<p><br><input type="submit" value="<?php echo $actions[ $action ]; ?>"/></p>
		</form>
	</td>
	</tr>
</table>
<a href="<?php echo base_url()?>map">Back to the Map</a>
</p>
<script>
$( document ).ready(function() {
	processInLineLabels();
});
</script>
