<?php
	$path = $params['upload']['path'];
	$width = "300";

	$avatar = user_avatar($udata['avatar'], 80);

	$out_inters = "";
	foreach($interesses as $inter) {
		if( $inter->fg_ativo=="S" ) {
			$out_inters .= $inter->categoria.", ";
		}	
	}
	$out_inters = rtrim($out_inters, ", ");

	if( !empty($out_inters) ) {
		$out_inters = "Interessado em: ".$out_inters;
	}
?>
<div style="width: <?php echo $width;?>px; text-align: left;">
<img src="<?php echo base_url($avatar)?>"> <?php echo $udata['nome']?><br>
</div>
<p><?php echo $out_inters?></p>
<?php
	if( $login_data['logged_in'] ) {
?>
<input type='button' value='Enviar Mensagem' class='itembox fancybox.ajax' href="<?php echo base_url('email/contato_inst/'.$udata['id'])?>">
<?php
	}
?>
