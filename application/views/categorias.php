<?php
	foreach( $categorias as $cat ) {
		echo "<h4>".$cat->nome."</h4>\n";
		echo $cat->descricao."\n";
	}
?>