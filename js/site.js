jQuery.extend({
    handleError: function( s, xhr, status, e ) {
        // If a local callback was specified, fire it
        if ( s.error ) {
            s.error( xhr, status, e );
        	setErrorDiv( xhr.responseText );
        }
        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
        else if(xhr.responseText) {
        	console.log(xhr.responseText);
			setErrorDiv( xhr.responseText );
		}
    }
});

function setErrorDiv( errorData ) {
	$('#error-details').html( errorData );
}

var nonJSONret = $.parseJSON( '{ "status": "nonJSONreturn", '
	+'"msg": "'+lang['dist_general_error']+'" }' );

function myParseJSON( jsonString ) {
	try {
		var json = $.parseJSON( jsonString );
		return json;
	} catch(err) {
		setErrorDiv( jsonString );
		return nonJSONret;
	}
}

function countOcurrences(str, value){
   var regExp = new RegExp(value, "gi");
   return str.match(regExp) ? str.match(regExp).length : 0;  
}

function go_home() {
	location.href = site_root;
}

function general_error( msg ) {
	if( msg==null ) {
		msg = lang['dist_general_error'];
	}
	new Messi( msg, {title: 'Oops...', titleClass: 'anim error', 
		buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
}

function load_infowindow_content(infowindow, user_id){
		$.ajax({
		url: site_root +'usuario/map_infowindow/' + user_id,
		success: function(data) {
			infowindow.setContent(data);
		}
	});
}

$(function() {

	var showmap = true;

	$('#map #hide').on('click', function(){
		if(showmap == true) {
			$('#map #filtros').toggle();
			$(this).html('<i class="fa fa-plus-square"></i>').find('i').css('color', '#000');
		} else {
			$('#map #filtros').toggle();
			$(this).html('<i class="fa fa-minus-square"></i>').find('i').css('color', '#fff');
		}
		showmap = !showmap;
	});

	$('#user-btn').on('mouseover', function(){
		$('#user-menu').css('display','block').hover(
			function() {
				$(this).show();
			},
			function() {
				$(this).hide();
			}
		);
	});
	
	$('#pref_email').submit(function(e) {
		e.preventDefault();
		$.post($("#pref_email").attr("action"),
			$("#pref_email").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status == "OK" ) {
				new Messi(json.msg, {title: lang['dist_lbl_success'],
					titleClass: 'anim success', modal: true,
					buttons: [{id: 0, label: 'OK', val: 'S'}] });
			} else {
				new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$('#usuario_insert').submit(function(e) {
		e.preventDefault();
		$.post($("#usuario_insert").attr("action"),
			$("#usuario_insert").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(lang['dist_newuser_ok2'], {title: lang['dist_lbl_success'], 
					titleClass: 'dist_lbl_success', modal: true,
					buttons: [{id: 0, label: 'OK', val: 'S'}], 
					callback: function(val) { go_home(); } });

			} else {
				new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$('#usuario_update').submit(function(e) {
		e.preventDefault();
		$.post($("#usuario_update").attr("action"),
			$("#usuario_update").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(json.msg, {title: lang['dist_lbl_success'],
					titleClass: 'dist_lbl_success', modal: true });
			} else {
				new Messi( json.msg, {title: 'Oops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$('#upload_avatar').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 		   : site_root +'image/upload_avatar/',
			secureuri      : false,
			fileElementId  :'userfile',
			contentType    : 'application/json; charset=utf-8',
			dataType	   : 'json',
			data        : {
				'thumbs'           : $('#thumbs').val()
			},
			success  : function (data) {
				if( data.status != 'error') {
					$('#user_avatar').attr('src',data.img_src);
					new Messi(data.msg, {title: lang['dist_lbl_success'], 
						titleClass: 'dist_lbl_success', modal: true });
				} else {
					new Messi(data.msg, {title: lang['dist_lbl_error'],
						titleClass: 'anim error',
						buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
				}
			},
			error : function (data, status, e) {
				general_error( lang['dist_error_upload'] );
			}
		});
		return false;
	});

	$('#item_insert').submit(function(e) {
		e.preventDefault();
		$.post($("#item_insert").attr("action"), $("#item_insert").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(json.msg, {title: lang['dist_lbl_success'], 
					titleClass: 'dist_lbl_success', modal: true, buttons: [{id: 0, label: 'OK', val: 'S'}], 
					callback: function(val) { location.href = site_root+'usuario/itens'; } });
			} else {
				new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$('#item_update').submit(function(e) {
		e.preventDefault();
		$.post($("#item_update").attr("action"),
			$("#item_update").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(json.msg, {title: lang['dist_lbl_success'], 
					titleClass: 'anim success', modal: true,
					buttons: [{id: 0, label: 'OK', val: 'S'}] });

			} else {
				new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$(document).on('click', '.itemdel', function(e) {
		e.preventDefault();
		var itemid = $(this).data('itemid');
		var parentDiv = $(this).parents('.item_single');
		new Messi('Tem certeza que deseja remover este item?', {title: 'Remover item', 
				titleClass: 'dist_lbl_success', modal: true,
				buttons: [{id: 0, label: 'Sim', val: 'S'},{id: 1, label: 'Não', val: 'N'}], callback: function(val) { 
					if (val=='S') {
						$.post(site_root+'item/delete/'+itemid, function(data){
							var json = myParseJSON(data);
							if (json.status=="OK") {
								parentDiv.remove(); 
							};
						}).fail( function(){ general_error();} );
					}
				}
			}
		);
		return false;
	});

	$(document).on('click', '.item-modify', function(e) {
		e.preventDefault();
		var itemid = $(this).data('itemid');
		location.href = site_root+'item/modificar/'+itemid;
		return false;
	});

	$(document).on('click', '.item-status', function(e){
		e.preventDefault();
		var btn = $(this);
		var itemstatus = btn.attr('data-status');
		if (itemstatus == 'I') {
			activ_deactiv_item(btn, '0');
		} else {
			activ_deactiv_item(btn, 'I');
		}
		return false;
	});

	$(document).on('click', '.item-doado', function(e){
		e.preventDefault();
		var btn = $(this);
		var itemstatus = btn.attr('data-status');
		if (itemstatus == 'D') {
			new Messi('Este item já foi marcado como doado', { title: 'Atenção', titleClass: 'anim error', modal: false });
		} else {
			new Messi('Confirma que o item foi doado? Após marcar como doado você não poderá mais fazer alterações neste item.', {
					title: 'Confirmar doação', 
					titleClass: 'dist_lbl_success', 
					modal: true, 
					buttons: [{id: 0, label: 'Sim', val: 'S'},{id: 1, label: 'Não', val: 'N'}], callback: function(val) { 
						if (val=='S') {
							marca_item_doado(btn);
						}
					}
				}
			);
		};
		return false;
	});

	$('#interesse_insert').submit(function(e) {
		e.preventDefault();
		$.post($("#interesse_insert").attr("action"),
			$("#interesse_insert").serialize(), function(data) {
			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(json.msg, {title: 'Interesse incluído com sucesso!', titleClass: 'dist_lbl_success', modal: true });
				var interesseData = $.get( site_root +'interesse/get_single/'+json.user+'/'+json.cat );
                interesseData.success(function(data) {
                	$('#interesses_none').hide();
                    $('#interesses table').append(data);
                });
			} else {
				new Messi( json.msg, {title: 'Oops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$(document).on('click', '.update_interesse_btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		var raio = $('#raio_'+btn.data('catid')).val();
		$.ajax({
			url 		: site_root + 'interesse/update/'+btn.data('catid')+'/'+raio,
			contentType : 'charset=utf-8',
			dataType	: 'json',
			success     : function (data) {
				if ( data.status === "success" ) {
					new Messi(data.msg, {title: 'Interesse atualizado com sucesso!', titleClass: 'dist_lbl_success', modal: true });
				} else {			
					new Messi( data.msg, {title: lang['dist_lbl_error'], titleClass: 'anim error', buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
				}
			},
			error : function (data, status, e) {
				general_error( 'Ocorreu uma falha ao Atualizar o Interesse, tente mais tarde' );
			}
		});
		return false;
	});

	$(document).on('click', '.activ_interesse_btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		if( !btn.hasClass('blue') ) {
			activ_deactiv_interesse(btn, 'activate');
		} else {
			activ_deactiv_interesse(btn, 'deactivate');
		}
		return false;
	});

	$(document).on('click', '.delete_file_link', function(e) {
		e.preventDefault();
		var btn = $(this);
		new Messi(lang['dist_imgdel_confirm'], {modal: true,
			buttons: [{id: 0, label: 'Sim', val: 'S'},
			{id: 1, label: 'Não', val: 'N'}], 
			callback: function(val) { if(val=='S') delete_image(btn); }});

		return false;
	});

});

function do_upload_item_image( img_id, isnew ) {

 	var img_tag_id = 'item_img_'+img_id;
	var file_tag_id = 'item_file_'+img_id;
	var action = '';

	if( $('#id').val()==0 && isnew ) {
		img_tag_id = 'img_'+img_id;
		file_tag_id = 'file_'+img_id;
		action = 'upload_temp_item_image';
	} else if( $('#id').val()!=0 && isnew ) {
		action = 'upload_item_image';
	} else {
		action = 'update_item_image';
	}

	var originalImg = $('#'+img_tag_id).attr('src');
	$('#'+img_tag_id).attr('src', site_root+'icons/ajax-loader.gif');

    $.ajaxFileUpload({
        url : site_root +'image/'+action+'/',
        secureuri : false,
        fileElementId : file_tag_id,
        contentType : 'application/json; charset=utf-8',
        dataType        : 'json',
        data : {
            'id' : $('#id').val(),
            'thumbs' : $('#thumbs').val(),
            'file_tag_name': file_tag_id,
            'temp_id': $('#temp_id').val(),
            'img_id': img_id
        },
        success : function(data) {
            if( data.status != 'error') {
                var imageData = $.getJSON( site_root + 'image/get_image/'+data.file_id );
                imageData.success(function(imgdata) {
	                $('#'+img_tag_id).attr('src', site_root+'files/'+imgdata.thumb80);
	                if( isnew ) {
	                	$('#'+img_tag_id).data('newid', data.file_id);
	                }
                });
            } else {
                new Messi(data.msg, {title: lang['dist_lbl_error'],
                	titleClass: 'anim error', 
                	buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
				$('#'+img_tag_id).attr('src', originalImg);
            }
        },
        error : function (data, status, e) {
			general_error( lang['dist_error_upload'] );
			$('#'+img_tag_id).attr('src', originalImg);
		}
    });
    return false;
}

function activ_deactiv_interesse( btn, action ) {
	$.ajax({
		url         : site_root + 'interesse/'+action+'/'+btn.data('catid'),
		contentType : 'charset=utf-8',
		dataType 	: 'json',
		success 	: function (data) {
			if ( data.status === "success" ) {
				if( action=='activate' ) {
					btn.html('<i class="fa fa-square-o"></i>&nbsp;Desativar');
					btn.addClass('blue');
					btn.parents('tr').removeClass('disabled');
				} else {
					btn.html('<i class="fa fa-check-square-o"></i>&nbsp;Ativar');
					btn.removeClass('blue');
					btn.parents('tr').addClass('disabled');
				}
				return true;
			} else {
				new Messi( data.msg, {title: lang['dist_lbl_error'],
					titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
				return false;
			}
		},
		error : function (data, status, e) {
			general_error( 'Ocorreu uma falha ao Ativar/Desativar o Interesse, tente mais tarde' );
			return false;
		}
	});
}

function activ_deactiv_item(btn, action) {
	$.post(site_root+'item/changestatus/'+btn.data('itemid'), { status: action } ,function(data){
		var json = myParseJSON(data);
		if (json.result === "OK") {
			new Messi(json.msg, {title: 'O status do item foi alterado com sucesso',
				titleClass: 'dist_lbl_success', modal: true });
			if (json.status === 'I') {
				btn.removeClass('active');
				btn.html('<i class="fa fa-square-o"></i>&nbsp;Cancelar Item');
				btn.attr('data-status', 'I');
				btn.next().removeClass('disabled').attr('disabled', false);
			} else {
				btn.addClass('active');
				btn.html('<i class="fa fa-check-square-o"></i>&nbsp;Ativar Item');
				btn.attr('data-status', '0');
				btn.next().addClass('disabled').attr('disabled', true);
			};
		};
	}).fail( function() { general_error(); } );;
}

function marca_item_doado(btn) {
	$.post(site_root+'item/doado/'+btn.data('itemid'), { status: 'D' }, function(data) {
		var json = myParseJSON( data );
		if (json.result === "OK") {
			new Messi(json.msg, { title: 'Doação realizada', titleClass: 'dist_lbl_success', modal: false });
			btn.addClass('active');
			btn.html('<i class="fa fa-check-square-o"></i>&nbsp;Doado');
			btn.attr('data-status', 'D');
			btn.siblings('button').addClass('disabled').attr('disabled', true);
		} else {
			new Messi(json.msg, { title: 'Erro na atualização do item', titleClass: 'anim error', modal: false });
		};
	}).fail( function() { general_error(); } );
};

function delete_image( link ) {
	$.ajax({
		url         : site_root + 'image/delete_image/' + link.data('file_id'),
		contentType : 'charset=utf-8',
		dataType 	: 'json',
		success     : function (data) {
			var images = $('#images');
			if (data.status === "success") {
				link.parent('div').fadeOut('fast', function() {
					$(this).remove();
					if (images.find('div').length === 0) {
						images.html('<p>Sem imagens.</p>');
					}
				});
				mrkImagesCount--;
			} else {
				new Messi(data.msg, {title: lang['error'], titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		},
		error : function (data, status, e) {
			general_error( lang['dist_imgdel_nok'] );
		}
	});
}