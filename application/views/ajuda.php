<style type="text/css">
ul.ajuda {
	display: none;
}
h2.ajuda {
	margin-top: 0px;
}
</style>
<script type="text/javascript">
	$(document).ready( function() {
		$('a.ajuda > i').each( function() {
			$(this).on('click', function() {
				showHideHelp( $(this) );
			});
		});
	});

	function showHideHelp( icon ) {
		if( icon.attr('class')=='fa fa-plus-square-o' ) {
			icon.attr('class', 'fa fa-minus-square-o');
			icon.parents('div:first').find('ul:first').show().fadeIn('fast');
			icon[0].scrollIntoView();
		} else {
			icon.attr('class', 'fa fa-plus-square-o');
			icon.parents('div:first').find('ul:first').hide().fadeOut('fast');
			icon[0].scrollIntoView();
		}
	}
</script>
<h2 class="ajuda">Ajuda</h2>
Abaixo se encontram algumas das principais dúvidas que os usuários podem ter ao usar o site. Veja se consegue a resposta para o que você precisa abaixo. Se não encontrar, mande <a href="<?php echo base_url('contato')?>">uma mensagem</a> pra gente.<br><br>
<div class="roundbox">
	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Como faço pra doar minhas coisas?</h3>
	<ul class="ajuda">Primeiro você precisa se <a href="<?php echo base_url('login')?>">logar</a> no site. Se ainda não é cadastrado, faça-o <a href="<?php echo base_url('usuario/escolhe_tipo')?>">aqui</a>. Depois basta acessar através do menu (no canto superior direito) o link 'Meus Itens'. Ali você pode cadastrar seus itens, colocar fotos, etc. Assim que um item seu for cadastrado ele já aparecerá no mapa para outras pessoas.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Como funcionam os Interesses?</h3>
	<ul class="ajuda">Interesses são uma forma de monitorar itens cadastrados de acordo com suas preferências de categoria e distância. Se você adicionar, por exemplo, um Interesse em Brinquedos, numa distância de 10km, toda vez que um item nessa categoria for incluído por qualquer um, dentro de um raio de 10km da sua localização, você receberá um aviso por email, e ai poderá entrar em contato para pedir o item se lhe interessar.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Como usar melhor o mapa?</h3>
	<ul class="ajuda">O mapa é a principal forma de navegação do site, é onde você vai ver todos os itens cadastrados e também todas as Instituições. Pessoas só aparecem no mapa se tiverem algum item disponível para doar. Todas as instituições aparecem, independente de terem ou não itens disponíveis. Na barra azul abaixo do mapa se encontram as opções de filtros. Primeiro você pode selecionar entre "Tudo", "Pessoas" ou "Instituições" - que é auto-explicativo. Tente e veja o que acontece. Ao lado direito se encontram as opções para filtrar ainda mais os resultados. Se você tiver procurando por roupas, por exemplo, basta ir em "Itens" e depois selecionar essa Categoria. Apenas pessoas com roupas para doar aparecerão no mapa. Você pode combinar categorias. Tente, veja como funciona. Se você estiver procurando um instituição para doar algo, você pode também filtrá-las pelos Interesses, as categorias são as mesmas e assim você acha exatamente quem precisa daquilo que você tem.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Como faço pra ver outros locais além do Rio de Janeiro?</h3>
	<ul class="ajuda">O site foi lançado no Rio, mas a ideia é que ele se expanda para todo o Brasil. Na barra de filtros há um botão para que você possa visualizar qualquer localização. Se quiser voltar e centrar o mapa na sua localização (ou no Rio, caso ainda não esteja cadastrado), nesse mesmo botão há um link para isso.</ul>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;E esses raios? Não entendi.</h3>
	<ul class="ajuda">Os raios são a forma de visualizar no mapa a distância que cada marcador está da sua localização. Eles só aparecem se você está logado, naturalmente. Você pode desabilitá-los no botão na barra de filtros. Esse botão também mostra o que cada círculo representa, em kilômetros, basta passar o mouse em cima do botão.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Doei um item. E agora?</h3>
	<ul class="ajuda">Agora você deve voltar ao site, acessar seus itens, e marcá-lo como Doado. Dessa forma ele não aparecerá mais disponível para doação e você não receberá mais emails de Interesse no mesmo.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Mandei uma mensagem de interesse em um item, mas ninguém respondeu.</h3>
	<ul class="ajuda">Bom, essa é a dinâmica natural das doações. Uma pessoa coloca um item para doar, mas não tem nenhuma obrigação de responder aos emails e também não há qualquer prazo imposto. Ela pode tanto demorar um dia como um mês para responder aos emails que recebe. Da mesma forma que doar é um ato de desapego, pedir algo não deve possuir sentimento algum de posse ou merecimento incluído. Apenas o doador pode decidir responder as mensagens e ele o faz de acordo com suas próprias regras e seu próprio tempo.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Coloquei um item pra doar, mas acho que vou precisar dele.</h3>
	<ul class="ajuda">Não tem problema. Se você está na dúvida, você pode acessar seus itens e desativá-lo. Não precisa excluir. Ao desativar ele não aparece mais no mapa como disponível e ninguém terá como solicitá-lo. Mais pra frente se você decidir doar, é só reativar.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Como é essa coisa de Limite de Mensagens por item?</h3>
	<ul class="ajuda">Para que os doadores não recebam enxurradas de mensagens quando colocarem itens para doar, existe um limite configurado (o valor padrão é 10) de mensagens. Quando esse limite é atingido, não podem ser enviadas mais mensagens de interesse para aquele item. Para configurar o limite clique <a href="<?php echo base_url('usuario/pref_email')?>">aqui</a>.</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Me cadastrei errado. Era pra ser Pessoa, coloquei Instituição (ou vice-versa).</h3>
	<ul class="ajuda">Não tem problema. Entre em <a href="<?php echo base_url('contato')?>">contato</a> com a gente, que damos um jeito rapidinho. :)</ul>
	</div>

	<div>
	<h3><a href="javascript: void(0);" class="ajuda"><i class="fa fa-plus-square-o"></i></a>&nbsp;Deu algum problema com meu cadastro via Facebook. O botão sumiu. E agora?</h3>
	<ul class="ajuda">Se o cadastro finalizou (i.e. você recebeu o email de boas vindas), lembre-se que você tem login e senha. Você pode usá-los para acessar normalmente, não precisa do facebook. Clique em "Entrar" ali em cima. Se você esqueceu sua senha, pode pedir uma nova na tela de login.
	Se você faz questão de acessar via facebook, tente acessar <a href="<?php echo base_url('usuario/logout')?>">esse link</a> e veja se o botão aparece para reiniciar. Se não funcionar, entre em <a href="<?php echo base_url('contato')?>">contato</a> que vamos investigar e resolver.</ul>
	</div>
<div>
