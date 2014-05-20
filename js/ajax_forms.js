$('#email_queroitem').submit(function(e) {
	e.preventDefault();

	var action = $("#email_queroitem").attr("action");
	var formdata = $("#email_queroitem").serialize();

	$.fancybox.close();
	$.post(action, formdata, function(data) {

		var json = myParseJSON( data );
		if( json.status=="OK" ) {
			new Messi('O email foi enviado!', {title: 'Sucesso',
				titleClass: 'success', modal: true });
		} else {
			new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
				buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
		}
	}).fail( function() { general_error(); } );
	return false;
});