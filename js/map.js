var activeMarkers = null;

function showHideMarker(marker, visible) {
	if( visible ) {
		marker.setVisible(true);
	} else {
		marker.infowindow.close();
		marker.setVisible(false);
	}
}

function findCategory(cat, marker) {
	for(var i=0; i<marker.items.length; i++) {
		if( marker.items[i][0]==cat ) {
			return true;
		}
	}

	return false;
}

function findSituation(sit, marker) {
	for(var i=0; i<marker.items.length; i++) {
		if( marker.items[i][1]==sit ) {
			return true;
		}
	}

	return false;
}

function findCatWithSit(cat, sit, marker) {
	for(var i=0; i<marker.items.length; i++) {
		if( marker.items[i][0]==cat &&
			marker.items[i][1]==sit ) {
			return true;
		}
	}

	return false;
}


function matchFilters(marker, cats, sits) {
	var hasCat = false;
	var hasSit = false;

	if( sits.length==0 ) {
		hasSit = true;
	}

	if( cats.length==0 ) {
		hasCat = true;
	}

	if( hasSit && !hasCat ) {
		for(var i=0; i<cats.length; i++) {
			if( findCategory(cats[i], marker) ) {
				hasCat = true;
				break;
			}
		} // for
	} else if( !hasSit && hasCat ) {
		for(var i=0; i<sits.length; i++) {
			if( findSituation(sits[i], marker) ) {
				hasSit = true;
				break;
			}
		} // for
	} else {
		for(var i=0; i<cats.length; i++) {
			for(var j=0; j<sits.length; j++) {
				if( findCatWithSit(cats[i], sits[j], marker) ) {
					hasCat = true;
					hasSit = true;
					break;
				}
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
		showHideMarker(markers_settings[i].mrk, true);
	}
}

function showPeople() {
	$('#filtro_insts').hide();
	$('#filtro_texto').hide();
	$('#filtro_pessoas').show();

	activeMarkers = new Array();
	for(var i=0; i<markers_settings.length; i++) {
		var isPessoa = ( markers_settings[i]['type']=='P' );
		var mrk = markers_settings[i].mrk;

		showHideMarker( mrk, isPessoa );

		activeMarkers.push( markers_settings[i] );
	}
}

function showInstitutions() {
	$('#filtro_pessoas').hide();
	$('#filtro_texto').hide();
	$('#filtro_insts').show();

	activeMarkers = new Array();
	for(var i=0; i<markers_settings.length; i++) {
		var isInst = ( markers_settings[i]['type']=='I' );
		var mrk = markers_settings[i].mrk;

		showHideMarker( mrk, isInst );

		activeMarkers.push( markers_settings[i] );
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

	for(var i=0; i<activeMarkers.length; i++) {
		var mrk = activeMarkers[i];

		if( mrk['type']!='P' ) {
			showHideMarker(mrk.mrk, false);
		} else {
			var match = matchFilters(mrk, checkedCats, checkedSits);
			showHideMarker(mrk.mrk, match);
		}
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

	for(var i=0; i<activeMarkers.length; i++) {
		var mrk = activeMarkers[i];

		if( mrk['type']=='I' ) {
			showHideMarker(mrk.mrk, false);
		} else {
			var matchCats = matchFilters(mrk, checkedCats, Array() );
			showHideMarker(mrk.mrk, matchCats);
		}			
	}
}

var radiusShown = true;
function hideRadiusCircles() {
	radiusShown = !radiusShown;
	for(var i=0; i<radiusCircles.length; i++) {
		radiusCircles[i].setVisible(radiusShown);
	}
}