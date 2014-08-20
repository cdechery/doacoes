<p class="label">nome do item</p>
<h3><?php echo $idata['titulo']?></h3>
<p class="label">descrição</p>
<p><?php echo wordwrap($idata['descricao'], 60)?></p>

<div class="imgs">
<?php
	if( isset($imgdata) ) {
		foreach ($imgdata as $img) {
?>
	<img src="<?php echo item_image($img->nome_arquivo, 80)?>">
<?php
		}
	}
?>
</div>

<?php
	if( $login_data['logged_in'] ) {
?>
<button class="itembox fancybox.ajax" ref="<?php echo base_url("email/quer_item/".$idata["id"])?>">Me interessa!</button>
<?php
	}
?>