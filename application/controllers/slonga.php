<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slonga extends MY_Controller {
	public function index() {
		$this->load->library('googlemaps');

		$config = array();
		$config['center'] = '-22.9035,-43.2096';
		$config['zoom'] = 'auto';	
		$config['geocodeCaching'] = FALSE;
		$config['minifyJS'] = TRUE;
		$config['places'] = FALSE;
		$config['cluster'] = FALSE;
		$config['sensor'] = TRUE;
		$config['ondblclick'] = 'createMarker({ map: map, position:event.latLng, draggable: true }, true);';

		$this->load->model('mapa_model');
		$map_result = $this->mapa_model->get_all();

		foreach($map_result as $row) {
			$marker = array();
			$marker['position'] = $row->lat.', '.$row->lng;
			$marker['infowindow_content'] = 'Item';
			$marker['clickable'] = true;
			$marker['id'] = $row->user_id;

			$this->googlemaps->add_marker($marker);
		}

		$this->googlemaps->initialize($config);
		$map = $this->googlemaps->create_map();

		$this->load->view('head', array('title'=>'Slonga!!!'));
		$this->load->view("slonga", array('map'=>$map));
		$this->load->view('foot');
	}
}