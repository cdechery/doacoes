Prezado(a) <?php echo $nome?>,

<p>Estamos lhe enviando esse email para avisar que um ou mais Interesses cadastrados em nosso site<br>
expiraram e foram exclu�dos.</p>

<p>Voc� n�o receber� novas notifica��es para: <?php echo implode(', ', $categorias)?>
<p>Interesses s�o v�lidos por <?php echo $params['validade_interesse_pessoa']?> dias.<br>
Voc� pode voltar e cadastr�-los novamente se quiser.</p>