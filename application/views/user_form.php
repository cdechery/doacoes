<body>
<?php
	$nome = $sobrenome = $lat = $lng = $email = "";
	$cpf = $cnpj = $login = $avatar = $action = "";
	$id = "";

	if( !empty($data) ) {
		extract($data);
	}

	$actions = array("insert"=>xlabel('insert'), "update"=>xlabel('update'));
	$fbReg = $this->input->cookie('FbRegPending');

	$hiddenAvatar = "";
	$fromFacebook = false;
	if( $fbReg ) {
		// veio do facebook
		$fromFacebook = true;
		$hiddenAvatar = '<input type="hidden" name="avatar" value="'.$avatar.'">';
	}

	$avatar = user_avatar($avatar, 200);

	$login_disabled = "";
	if( $action=="update" ) {
		$login_disabled = "disabled";
	}

	$doc = "cpf";
	if( $tipo=="I" ) { // Instituicao
		$doc = "cnpj";
	}
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&libraries=places"></script>
<script type="text/javascript">
//<![CDATA[
var map; // Global declaration of the map
var userLocMarker = null;
var placesService;
var placesAutocomplete;

function updateFormLatLng(lat, lng) {
	document.userData.lat.value = lat;
	document.userData.lng.value = lng;
}

function createMarker( markerOptions ) {
	if( userLocMarker!=null ) {
		return false;
	}

	var marker = new google.maps.Marker( markerOptions );
	marker.set("content", "Sua localização");

	userLocMarker = marker;
	google.maps.event.addListener(marker, "dragend", function(event) {
		updateFormLatLng(event.latLng.lat(), event.latLng.lng());
	});
		
	updateFormLatLng( marker.getPosition().lat(),
		marker.getPosition().lng() );
}

function initialize() {
	
	var myLatlng = new google.maps.LatLng(-22.9035,-43.2096);
	var myOptions = {
  		zoom: 13,
		center: myLatlng,
  		mapTypeId: google.maps.MapTypeId.ROADMAP}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	google.maps.event.addListener(map, "dblclick", function(event) {
		if( userLocMarker!=null ) {
			userLocMarker.setMap(null);
			userLocMarker = null;
		}
		createMarker({ map: map, position:event.latLng, draggable: true });
	});

	var autocompleteOptions = { }
	var autocompleteInput = document.getElementById('myPlaceTextBox');
				
	placesAutocomplete = new google.maps.places.Autocomplete(autocompleteInput, autocompleteOptions);
	placesAutocomplete.bindTo('bounds', map);
	google.maps.event.addListener(placesAutocomplete, 'place_changed', function() {
		var loc = placesAutocomplete.getPlace().geometry.location;
		createMarker({ map: map, position:loc, draggable: true });
		map.setCenter(loc);
	});	

<?php
	if( !empty($lat) && !empty($lng) ) {
?>
	var myLatlng = new google.maps.LatLng(<?php echo $lat?>, <?php echo $lng?>);	
	createMarker( { map: map, position:myLatlng, draggable: true } );
	map.setZoom(15);
	map.setCenter( myLatlng );
<?php		
	} 
?>
} // initialize

window.onload = initialize;
//]]>
<?php
	if( $fromFacebook ) {
?>
	new Messi('Para finalizar o cadastro, precisamos de mais algumas informações');
<?php	
	}
?>
</script>
<table cellpadding=5 cellspacing=5 border=0>
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:text-top;">
		<img id="user_avatar" src="<?php echo base_url($avatar)?>"/><br>
<?php
	if( $action=="update" ) {
?>
	    <form method="post" action="<?php echo base_url();?>image/upload_avatar" id="upload_avatar" enctype="multipart/form-data">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
	    <input type="hidden" name="thumbs" id="thumbs" value="<?php echo implode('|',$params['image_settings']['thumb_sizes'])?>"/>
		<input type="file" id="userfile" name="userfile" style="display: none;" />
		<input type="button" value="Browse ..." onclick="document.getElementById('userfile').click();" />

	      <br><input type="submit" name="Upload" id="submit" value="<?php echo xlabel('upload')?>" />
	   </form>
<?php
	}
?>
		</td>
		<td>
		<form method="POST" name="userData" action="<?php echo base_url()?>usuario/<?php echo $action; ?>" id="usuario_<?php echo $action?>" onSubmit="clearInlineLabels(this);">
		<input type="hidden" name="id" value="<?php echo $id ?>">
		<input type="hidden" name="lat" value="<?php echo $lat ?>">
		<input type="hidden" name="lng" value="<?php echo $lng ?>">
		<input type="hidden" name="tipo" value="<?php echo $tipo ?>">
		<?php echo $hiddenAvatar?>

		<input type="text" name="login" value="<?php echo $login; ?>" size="50" <?php echo $login_disabled; ?> title="Login"/><br>
		<input type="text" name="nome" value="<?php echo $nome ?>" size="50" title="Nome" /><br>
<?php
	if( $tipo=="P") {
?>		
		<input type="text" name="sobrenome" value="<?php echo $sobrenome; ?>" size="50" title="Sobrenome"/><br>
<?php
	}
?>
		<input type="text" name="email" value="<?php echo $email?>" size="50" title="Email" /><br>
		<input type="text" name="<?php echo ${'doc'}?>" value="<?php echo ${$doc}?>" size="50" title="<?php echo strtoupper($doc)?>"/><br>
		Senha<br>
		<input type="password" name="password" value="" size="10"><br>
		Repita a senha<br>
		<input type="password" name="password_2" value="" size="10" /><br>
		<div style="margin-bottom:15px"><strong>Encontre sua localização:</strong> <input type="text" id="myPlaceTextBox" /></div>
		<div id="map_canvas" style="width: 420px; height:300px;"></div>		

		<p><br><input type="submit" value="<?php echo $actions[ $action ]; ?>"/></p>
		</form>
		<td>
		</td>
	</tr>
</table>
<a href="<?php echo base_url()?>map">Back to the Map</a>
</p>
<script>
$( document ).ready(function() {
	processInLineLabels();
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});
</script>