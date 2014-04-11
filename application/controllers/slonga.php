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

		$this->load->model('mapa_model');
		$map_result = $this->mapa_model->get_all();

		foreach($map_result as $row) {
			if( $row->user_id == $this->login_data['user_id'] ) {
				continue;
			}

			$marker = array();
			$marker['position'] = $row->lat.', '.$row->lng;
			$marker['infowindow_content'] = 'Item';
			$marker['clickable'] = true;
			$marker['icon'] = base_url().'icons/red-dot.png';
			$marker['id'] = $row->user_id;

			$this->googlemaps->add_marker($marker);
		}

		if( $this->is_user_logged_in ) {
			$this->load->model('usuario_model');
			$user_data = $this->usuario_model->get_data( $this->login_data['user_id'] );

			$marker = array();
			$marker['position'] = $user_data['lat'].', '.$user_data['lng'];
			$marker['infowindow_content'] = 'Você';
			$marker['clickable'] = false;
			$marker['icon'] = base_url().'icons/yellow-dot.png';
			$marker['id'] = $user_data['id'];

			$this->googlemaps->add_marker( $marker );

			$config['center'] = $user_data['lat'].', '.$user_data['lng'];
		}

		$this->googlemaps->initialize($config);
		$map = $this->googlemaps->create_map();

		$this->load->view('head', array('title'=>'Slonga!!!'));
		$this->load->view("slonga", array('map'=>$map));
		$this->load->view('foot');
	}
}