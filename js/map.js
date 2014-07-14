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

function findInterest(inter, marker) {
	for(var i=0; i<marker.items.length; i++) {
		if( marker.items[i][2]==inter ) {
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


function matchFiltersItem(marker, cats, sits) {
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

function matchFiltersInt(marker, ints) {
	if( ints.length==0 ) {
		return true;
	}

	for(var i=0; i<ints.length; i++) {
		if( findInterest(ints[i], marker) ) {
			return true;
		}
	} // for

	return false;
}

function showAllActive() {
	for(var i=0; i<activeMarkers.length; i++) {
		showHideMarker(activeMarkers[i].mrk, true);
	}
}

function showAll() {
	$('#filtro_ints').hide();
	$('#filtro_itens').hide();
	$('#filtro_texto').show();

	activeMarkers = markers_settings;
	for(var i=0; i<activeMarkers.length; i++) {
		showHideMarker(activeMarkers[i].mrk, true);
	}
}

function showPeople() {
	$('#filtro_ints').hide();
	$('#filtro_itens').hide();
	$('#filtro_texto').show();

	activeMarkers = new Array();
	for(var i=0; i<markers_settings.length; i++) {
		var isPessoa = ( markers_settings[i]['type']=='P' );
		var mrk = markers_settings[i].mrk;

		showHideMarker( mrk, isPessoa );

		if( isPessoa ) {
			activeMarkers.push( markers_settings[i] );
		}
	}
}

function showInstitutions() {
	$('#filtro_ints').hide();
	$('#filtro_itens').hide();
	$('#filtro_texto').show();

	activeMarkers = new Array();
	for(var i=0; i<markers_settings.length; i++) {
		var isInst = ( markers_settings[i]['type']=='I' );
		var mrk = markers_settings[i].mrk;

		if( isInst ) {
			activeMarkers.push( markers_settings[i] );
		}
		showHideMarker( mrk, isInst );
	}
}

function showFilterItem() {
	$('#filtro_ints').hide();
	$('#filtro_texto').hide();
	$('#filtro_itens').show();
}

function showFilterInt() {
	$('#filtro_itens').hide();
	$('#filtro_texto').hide();
	$('#filtro_ints').show();
}

function filterItem() {

	var checkedCats = Array();
	$('.filterItemCat:checked').each(function() {
		checkedCats.push( $(this).val() );
	});

	var checkedSits = Array();
	$('.filterItemSit:checked').each(function() {
		checkedSits.push( $(this).val() );
	});

	if( checkedCats.length==0 && checkedSits.length==0 ) {
		showAllActive();
		return;
	}

	for(var i=0; i<activeMarkers.length; i++) {
		var mrk = activeMarkers[i];

		var match = matchFiltersItem(mrk, checkedCats, checkedSits);
		showHideMarker(mrk.mrk, match);
	}
}

function filterInt() {
	var checkedCats = Array();
	$('.filtroInstCat:checked').each(function() {
		checkedCats.push( $(this).val() );
	});

	if( checkedCats.length==0 ) {
		showAllActive();
		return;
	}

	for(var i=0; i<activeMarkers.length; i++) {
		var mrk = activeMarkers[i];

		var matchCats = matchFiltersInt(mrk, checkedCats, Array() );
		showHideMarker(mrk.mrk, matchCats);
	}
}

var radiusShown = true;
function hideRadiusCircles() {
	radiusShown = !radiusShown;
	for(var i=0; i<radiusCircles.length; i++) {
		radiusCircles[i].setVisible(radiusShown);
	}
}