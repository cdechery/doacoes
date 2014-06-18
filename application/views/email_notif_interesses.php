Prezado(a) <?php echo $nome?>,

<p>Estamos lhe enviando esse email para avisar que um ou mais Interesses cadastrados em nosso site<br>
expiraram e foram excluídos.</p>

<p>Você não receberá novas notificações para: <?php echo implode(', ', $categorias)?>
<p>Interesses são válidos por <?php echo $params['validade_interesse_pessoa']?> dias.<br>
Você pode voltar e cadastrá-los novamente se quiser.</p>