function matchFilters(marker, cats, sits) {
	var mrkCats = marker.cats;
	var mrkSits = marker.sits;

	var hasCat = false;
	var hasSit = false;

	if( cats.length==0 ) {
		hasCat = true;
	} else {
		for(var i=0; i<cats.length; i++) {
			if( $.inArray(cats[i], mrkCats)>-1 ) {
				hasCat = true;
				break;
			}
		} // for
	}

	if( sits.length==0 ) {
		hasSit = true;
		console.log('tei');
	} else {
		for(var i=0; i<sits.length; i++) {
			if( $.inArray(sits[i], mrkSits)>-1 ) {
				hasSit = true;
				break;
			}
		} // for
	}

	return hasCat && hasSit;
}

function showAll() {
	$('#filtro_insts').hide();
	$('#filtro_pessoas').hide();
	$('#filtro_texto').show();

	for(var i=0; i<markers_settings.length; i++) {
		markers_settings[i].mrk.setVisible( true );
	}

}

function showPeople() {
	$('#filtro_insts').hide();
	$('#filtro_texto').hide();
	$('#filtro_pessoas').show();

	for(var i=0; i<markers_settings.length; i++) {
		var isPessoa = ( markers_settings[i]['type']=='P' );
		var mrk = markers_settings[i].mrk;
		mrk.setVisible( isPessoa );
	}
}

function showInstitutions() {
	$('#filtro_pessoas').hide();
	$('#filtro_texto').hide();
	$('#filtro_insts').show();

	for(var i=0; i<markers_settings.length; i++) {
		var isInst = ( markers_settings[i]['type']=='I' );
		var mrk = markers_settings[i].mrk;
		mrk.setVisible( isInst );
	}
}

function filterPessoa() {
	var checkedCats = Array();
	$('.filtroPessoaCat:checked').each(function() {
		checkedCats.push( $(this).val() );
	});

	var checkedSits = Array();
	$('.filtroPessoaSit:checked').each(function() {
		checkedSits.push( $(this).val() );
	});

	if( checkedCats.length==0 && checkedSits.length==0 ) {
		showPeople();
		return;
	}

	for(var i=0; i<markers_settings.length; i++) {
		var mrk = markers_settings[i];

		var isPessoa = ( mrk['type']=='P' );
		var match = matchFilters(mrk, checkedCats, checkedSits);

		mrk.mrk.setVisible( isPessoa && match );
	}
}

function filterInst() {
	var checkedCats = Array();
	$('.filtroInstCat:checked').each(function() {
		checkedCats.push( $(this).val() );
	});

	if( checkedCats.length==0 ) {
		showInstitutions();
		return;
	}

	for(var i=0; i<markers_settings.length; i++) {
		var mrk = markers_settings[i];

		var isPessoa = ( mrk['type']=='I' );
		var matchCats = matchFilters(mrk, checkedCats, Array() );

		mrk.mrk.setVisible( isPessoa && matchCats );
	}
}

function filterPessoaSit() {
	var checkedSits = Array();
	$('.filtroPessoaSit:checked').each(function() {
		checkedCats.push( $(this).val() );
	});

	if( checkedCats.length==0 ) {
		showPeople();
		return;
	}

	for(var i=0; i<markers_settings.length; i++) {
		var mrk = markers_settings[i];

		var isPessoa = ( mrk['type']=='P' );
		var matchCats = matchFiltersCats(mrk, checkedCats);

		mrk.mrk.setVisible( isPessoa && matchCats );
	}
}

var radiusShown = true;
function hideRadiusCircles() {
	radiusShown = !radiusShown;
	for(var i=0; i<radiusCircles.length; i++) {
		radiusCircles[i].setVisible(radiusShown);
	}
}
