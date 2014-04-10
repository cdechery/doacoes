<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('xlogin');
		$this->logged_user_id = $this->login_data['user_id'];
	}

	public function user_location() {
		$this->load->library('googlemaps');

		$config = array();
		$config['center'] = '-22.9035,-43.2096';
		$config['zoom'] = 'auto';	
		$config['geocodeCaching'] = FALSE;
		$config['minifyJS'] = FALSE;
		$config['places'] = FALSE;
		$config['cluster'] = FALSE;
		$config['sensor'] = TRUE;
		$config['ondblclick'] = 'createMarker({ map: map, position:event.latLng, draggable: true }, true);';

		$this->googlemaps->initialize($config);
		
		$data['map'] = $this->googlemaps->create_map();

		echo $data['map']['js'];
		echo $data['map']['html'];
		/*echo '<a href=# onclick="lala();">a</a>
		<script>function lala() { var marker = markers[0];
		var lat = marker.getPosition().lat();
		var lng = marker.getPosition().lng(); alert("lat="+lat+"long="+lng); }</script>';*/
	}
}
