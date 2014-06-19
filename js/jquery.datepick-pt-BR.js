/* http://keith-wood.name/datepick.html
   Brazilian Portuguese localisation for jQuery Datepicker.
   Written by Leonildo Costa Silva (leocsilva@gmail.com). */
(function($) {
	$.datepick.regionalOptions['pt-BR'] = {
		monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter�a-feira','Quarta-feira','Quinta-feira','Sexta-feira','S�bado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S�b'],
		dayNamesMin: ['D','S','T','Q','Q','S','S'],
		dateFormat: 'dd/mm/yyyy', firstDay: 0, 
		renderer: $.datepick.defaultRenderer,
		prevText: '&lt;Anterior', prevStatus: 'Mostra o m�s anterior', 
		prevJumpText: '&lt;&lt;', prevJumpStatus: 'Mostra o ano anterior', 
		nextText: 'Pr�ximo&gt;', nextStatus: 'Mostra o pr�ximo m�s', 
		nextJumpText: '&gt;&gt;', nextJumpStatus: 'Mostra o pr�ximo ano',
		currentText: 'Atual', currentStatus: 'Mostra o m�s atual',
		todayText: 'Hoje', todayStatus: 'Vai para hoje', 
		clearText: 'Limpar', clearStatus: 'Limpar data',
		closeText: 'Fechar', closeStatus: 'Fechar o calend�rio',
		yearStatus: 'Selecionar ano', monthStatus: 'Selecionar m�s',
		weekText: 's', weekStatus: 'Semana do ano', 
		dayStatus: 'DD, d \'de\' M \'de\' yyyy', defaultStatus: 'Selecione um dia',
		isRTL: false
	};
	$.datepick.setDefaults($.datepick.regionalOptions['pt-BR']);
})(jQuery);
