<body>
<?php
	$descricao = $status = $titulo = "";
	$categoria_id = $situacao_id = "";
	$id = "0";

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
	    <form method="post" action="<?php echo base_url();?>image/upload_item_image" id="upload_item_image" enctype="multipart/form-data">
<?php
	$num_imgs = 0;
	$max_imgs = $params['max_item_imgs'];

	// Imagens do item, se houver
	foreach($images as $img) {
		$num_imgs++;
		$thumb = thumb_filename($img->nome_arquivo, 200);
?>
		<input type="file" name="item_file_<?php echo $num_imgs?>" style="display: none;" id="item_file_<?php echo $num_imgs?>"  onchange="do_upload_item_image(<?php echo $img->id?>, false);" />
		<a href="#" onclick="document.getElementById('item_file_<?php echo $num_imgs?>').click();"/>
		<img alt="Alterar imagem" src="<?php echo base_url()."files/".$thumb?>" id="item_img_<?php echo $num_imgs?>" data-imgid="<?php echo $img->id?>">
		</a>
<?php			
	} //images

	// completo as imagens com a "default"
	for($i=0; $i<$max_imgs-$num_imgs; $i++) {
?>		
		<input type="file" name="file_<?php echo $i?>" style="display: none;" id="file_<?php echo $i?>" onchange="do_upload_item_image(<?php echo $i?>, true);"/>
		<a href="#" onclick="document.getElementById('file_<?php echo $i?>').click();"/>
		<img alt="Enviar imagem" src="<?php echo base_url()."images/default_item_img.jpg"?>" id="img_<?php echo $i?>"/>
		</a>
<?php
	}
?>
		</form>
		</td>
	</tr>
	<tr>
		<td>
		<form method="POST" name="itemData" action="<?php echo base_url()?>item/<?php echo $action; ?>" id="item_<?php echo $action?>" onSubmit="clearInlineLabels(this);">
		<input type="hidden" name="id" id="id" value="<?php echo $id ?>">
		<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $login_data['user_id'] ?>">
	    <input type="hidden" name="thumbs" id="thumbs" value="<?php echo implode('|',$params['image_settings']['thumb_sizes'])?>"/>

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
<div id="error-details"></div>
<script>
$( document ).ready(function() {
	processInLineLabels();
});
</script>
