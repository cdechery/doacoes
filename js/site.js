$.ajaxSetup({
	contentType: 'application/x-www-form-urlencoded; '+site_charset,
	beforeSend: function(jqXHR) {
		jqXHR.overrideMimeType('application/x-www-form-urlencoded; charset='+site_charset);
	}
});

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
	$('#usuario_insert').submit(function(e) {
		e.preventDefault();
		$.post($("#usuario_insert").attr("action"),
			$("#usuario_insert").serialize(), function(data) {

			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(lang['dist_newuser_ok2'], {title: lang['success'], 
					titleClass: 'success', modal: true,
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
				new Messi(json.msg, {title: lang['success'],
					titleClass: 'success', modal: true });
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
					new Messi(data.msg, {title: lang['success'], 
						titleClass: 'success', modal: true });
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
		$.post($("#item_insert").attr("action"),
			$("#item_insert").serialize(), function(data) {

			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(lang['dist_newuser_ok2'], {title: lang['success'], 
					titleClass: 'success', modal: true,
					buttons: [{id: 0, label: 'OK', val: 'S'}], 
					callback: function(val) { go_home(); } });

			} else {
				new Messi( json.msg, {title: 'Ops...', titleClass: 'anim error', 
					buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
			}
		}).fail( function() { general_error(); } );
		return false;
	});

	$('#interesse_insert').submit(function(e) {
		e.preventDefault();
		$.post($("#interesse_insert").attr("action"), 
			$("#interesse_insert").serialize(), function(data) {

			var json = myParseJSON( data );
			if( json.status=="OK" ) {
				new Messi(json.msg, {title: 'Interesse incluído com sucesso!',
					titleClass: 'success', modal: true });

				var interesseData = $.get( site_root +'interesse/get_single/'+json.user+'/'+json.cat );
                interesseData.success(function(data) {
                    $('#interesses_none').hide();
                    $('#interesses').append( data );
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
					new Messi(data.msg, {title: 'Interesse atualizado com sucesso!',
						titleClass: 'success', modal: true });
				} else {			
					new Messi( data.msg, {title: lang['dist_lbl_error'],
						titleClass: 'anim error',
						buttons: [{id: 0, label: 'Fechar', val: 'X'}]});
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

		if( btn.val()=='Ativar' ) {
			activ_deactiv_interesse(btn, 'activate');
		} else {
			if( activ_deactiv_interesse(btn, 'deactivate') ) {
			}
		}

		return false;
	}); // delete

	$(document).on('click', '.delete_file_link', function(e) {
		e.preventDefault();
		var btn = $(this);
		new Messi(lang['dist_imgdel_confirm'], {modal: true,
			buttons: [{id: 0, label: 'Sim', val: 'S'},
			{id: 1, label: 'Não', val: 'N'}], 
			callback: function(val) { if(val=='S') delete_image(btn); }});

		return false;
	}); // delete
});

function do_upload_item_image( img_id, isnew ) {

 	var img_tag_id = 'item_img_'+img_id;
	var file_tag_id = 'item_file_'+img_id;
	var action = '';

	if( isnew ) {
		img_tag_id = 'img_'+img_id;
		file_tag_id = 'file_'+img_id;
	}

	if( $('#id').val()==0 && isnew ) {
		action = 'upload_temp_item_image';
	} else if( $('#id').val()!=0 && isnew ) {
		action = 'upload_item_image';
	} else {
		action = 'update_item_image';
	}

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
	                $('#'+img_tag_id).attr('src', site_root+'files/'+imgdata.thumb200);
	                if( isnew ) {
	                	$('#'+img_tag_id).data('newid', data.file_id);
	                }
                });
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
}

function activ_deactiv_interesse( btn, action ) {
	$.ajax({
		url         : site_root + 'interesse/'+action+'/'+btn.data('catid'),
		contentType    : 'charset=utf-8',
		dataType : 'json',
		success     : function (data) {
			if ( data.status === "success" ) {
				if( action=='activate' ) {
					btn.val('Desativar');
					btn.closest('table').css('color','black');
				} else {
					btn.val('Ativar');
					btn.closest('table').css('color','lightgrey');
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

function delete_image( link ) {
	$.ajax({
		url         : site_root + 'image/delete_image/' + link.data('file_id'),
		contentType    : 'charset=utf-8',
		dataType : 'json',
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