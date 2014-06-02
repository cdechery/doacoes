<?php 
	echo "<pre>".print_r($idata)."</pre>";
?>
<h3><?php echo $idata['titulo']?></h3>
<p><?php echo wordwrap($idata['descricao'], 60)?></p>
<div>
	<?php
		if( isset($imgdata) ) {
			foreach ($imgdata as $img) {
				$thumb = thumb_filename($img->nome_arquivo, 80);
	?>
	<div style="float: left; margin: 2px">
		<img src="<?php echo base_url('files/'.$thumb)?>">
	</div>
	<?php
			}
		}
	?>
</div>
<div style="clear: both"></div>
<br>

<?php if( $login_data['logged_in'] ) { ?>
	<input type="button" value="Eu quero!" class='itembox fancybox.ajax' href="<?php echo base_url("email/quer_item/".$idata["id"])?>">
<?php } ?>