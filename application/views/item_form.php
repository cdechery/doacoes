<body>
<?php
	$desc = $categ = $sit = $status = $titulo = "";
	$id = "";

	if( !empty($data) ) {
		extract($data);
	}

	$actions = array("insert"=>xlabel('insert'), "update"=>xlabel('update'));

	if( empty($avatar) ) {
		$avatar = "images/default_avatar.gif";
	} else {
		$avatar = $params['upload']['path'].$avatar;
	}
?>
<table cellpadding=5 cellspacing=5 border=0>
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:text-top;">
		<img id="user_avatar" src="<?php echo base_url() . $avatar;?>"/><br>
		</td>
		<td>
		<form method="POST" name="itemData" action="<?php echo base_url()?>item/<?php echo $action; ?>" id="item_<?php echo $action?>" onSubmit="clearInlineLabels(this);">
		<input type="hidden" name="id" value="<?php echo $id ?>">

		<input type="text" name="titulo" value="<?php echo $titulo ?>" size="50" title="Título" /><br>
		<select name="categ">
			<option value="">Categoria</option>
			<option value="1">Roupas</option>
			<option value="2">Móveis</option>
			<option value="3">Brinquedos</option>
		</select>
		<textarea name="desc" title="Descrição"/><?php echo $desc ?></textarea><br>
		<select name="sit">
			<option value="">Situação</option>
			<option value="1">Novo</option>
			<option value="2">Usado</option>
			<option value="3">Quebrado</option>
		</select>

		<p><br><input type="submit" value="<?php echo $actions[ $action ]; ?>"/></p>
		</form>
		<td>
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
