<?php
	
	$path = $params['upload']['path'];
	$width = "300";

	$avatar = user_avatar($udata['avatar'], 40);

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

<h3>
	<img src="<?php echo $avatar?>"> <?php echo $udata['nome']?>
</h3>

<p><?php echo $out_inters?></p>

<?php
	if( $login_data['logged_in'] ) {
?>

<p>
	<a style="font-weight:700;" href="<?php echo base_url('email/contato_inst/'.$udata['id'])?>" class="itembox fancybox.ajax">Enviar Mensagem</a>
</p>

<?php
	}
?>
