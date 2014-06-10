<?php
	$nome = $sobrenome = $lat = $lng = $email = "";
	$data_nascimento = $sexo = $login = $avatar = $action = "";
	$id = "";

	if( !empty($data) ) {
		extract($data);

		if( !empty($data_nascimento) ) {
			$dt_parts = explode('-', $data_nascimento );
			$data_nascimento = $dt_parts[2]."/".$dt_parts[1]."/".$dt_parts[0];
		}
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

	$lblTipo = "Pessoa";
	if( $tipo=="I" ) { // Instituicao
		$lblTipo = "Instituição";
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

<section id="user" class="contents">
	<div class="wrap960">

		<h2>
			Cadastro de <?php echo $lblTipo ?>
		</h2>

		<div id="foto">
			<img id="user_avatar" src="<?php echo base_url($avatar)?>"/>
			<?php if( $action=="update" ) { ?>
				<form method="post" action="<?php echo base_url();?>image/upload_avatar" id="upload_avatar" enctype="multipart/form-data">
					<div class="form-group">
						<label>Mude sua foto:</label>
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
						<input type="hidden" name="thumbs" id="thumbs" value="<?php echo implode('|',$params['image_settings']['thumb_sizes'])?>"/>
						<input type="file" id="userfile" name="userfile" style="display: none;" />
						<input type="button" value="Procurar" onclick="document.getElementById('userfile').click();" />
					</div>
					<div class="form-group">
						<input type="submit" name="Upload" id="submit" value="<?php echo xlabel('upload')?>" />
					</div>
				</form>
			<?php } ?>
		</div>

		<div id="user-form">
			<form method="POST" name="userData" action="<?php echo base_url()?>usuario/<?php echo $action; ?>" id="usuario_<?php echo $action?>">
				<input type="hidden" name="id" value="<?php echo $id ?>">
				<input type="hidden" name="lat" value="<?php echo $lat ?>">
				<input type="hidden" name="lng" value="<?php echo $lng ?>">
				<input type="hidden" name="tipo" value="<?php echo $tipo ?>">
				<?php echo $hiddenAvatar?>
				<div class="form-group">
					<label>Login</label>
					<input type="text" name="login" value="<?php echo $login; ?>" size="50" <?php echo $login_disabled; ?> title="Login" placeholder="Seu login" />
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="email" value="<?php echo $email?>" size="50" title="Email" placeholder="Seu email" />
				</div>
				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="nome" value="<?php echo $nome ?>" size="50" title="Nome" placeholder="Seu nome" />
				</div>
<?php
	if( $tipo=="P") {
		$sexoM = ($sexo=="M")?"checked":"";
		$sexoF = ($sexo=="F")?"checked":"";
?>
					<div class="form-group">
						<label>Sobrenome</label>
						<input type="text" name="sobrenome" value="<?php echo $sobrenome; ?>" size="50" title="Sobrenome" placeholder="Seu sobrenome" />
					</div>
					<div class="form-group">
						<label>Nascimento</label>
						<input type="text" id="dtnascimento" name="nascimento" value="<?php echo $data_nascimento; ?>" size="50" title="Data de Nascimento" placeholder="Sua data de nascimento" />
					</div>
					<div class="form-group">
						<label>Sexo</label>
						<br><input type="radio" name="sexo" value="M" <?php echo $sexoM?>> Masculino
						<input type="radio" name="sexo" value="F" <?php echo $sexoF?>> Feminino
					</div>
<?php
	} // tipo==P
?>
				<div class="form-group">
					<label>Senha</label>
					<input type="password" name="password" value="" size="10" placeholder="Escolha uma senha" >
					<input type="password" name="password_2" value="" size="10" placeholder="Repita a senha">
				</div>
				<div class="form-group">
					<label>Localização</label>
					<input type="text" id="myPlaceTextBox" placeholder="Digite sua localização" />
				</div>
				<div id="map_canvas"></div>
				<div class="form-group">
					<input type="submit" value="<?php echo $actions[ $action ]; ?>"/>
				</div>
			</form>
		</div>

		<aside>
			Preencha seu formulário rules para poder dar ou ganhar coisas.
		</aside>

		<script>
		$( document ).ready(function() {
			$(window).keydown(function(event){
				if(event.keyCode == 13) {
					event.preventDefault();
					return false;
				}
			});
		});
		$('#dtnascimento').datepick( {prevText: '',nextText: '', yearRange: 'any', alignment: 'bottomRight' } );
		</script>

	</div>
</section>