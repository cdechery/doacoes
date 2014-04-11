<?php
	$path = $params['upload']['path'];
	$width = "300";
	/*if( isset($data['images']) && count($data['images'])>2 ) {
		$width = "400";
	}*/

	$avatar = $data['avatar'];
	if( empty($avatar) ) {
		$avatar = base_url()."images/default_avatar_small.gif";
	} else {
		$avatar = base_url()."files/".thumb_filename($avatar, 80);
	}
?>
<div style="width: <?php echo $width;?>px; text-align: left;">
<img src="<?php echo $avatar?>"> <?php echo $data['nome']?> tem X itens para doar.<br>
</div>

<?php
	if( $images ) {
		foreach ($images as $img) {
			$thumb = thumb_filename($img->nome_arquivo, 80);
			echo "<img src='".base_url()."files/".$thumb."''>";
		}
	}
?>
</div>