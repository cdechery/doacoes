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

		$config['map_width'] = '100%'; // usar 960px para mapa largura fixa (não 100%)
		$config['map_height'] = '400px';
		$config['map_div_id'] = 'map_canvas_full'; // para mapa 100% de largura

		$this->load->model('mapa_model');
		$map_result = $this->mapa_model->get_all();

		$custom_js_global = "";
		$custom_js_init = "";

		$this->load->model('categoria_model');
		$categorias = $this->categoria_model->get_all();

		$this->load->model('situacao_model');
		$situacoes = $this->situacao_model->get_all();

		$custom_js_global .= "var markers_settings = new Array();\n";

		$markers_created = array();
		foreach($map_result as $row) {
			
			if( $row->user_id == $this->login_data['user_id'] ) {
				continue;
			}

			if( in_array($row->user_id, $markers_created) ) {
				$custom_js_init .= "marker_".$row->user_id."_settings.items.push( new Array('".$row->cat_id."', '".$row->sit_id."') ) ;";
				continue;
			}

			$marker = array();
			$marker['position'] = $row->lat.', '.$row->lng;
			$marker['infowindow_content'] = 'Item';
			$marker['clickable'] = true;
			$marker['onclick'] = 'map.setCenter(event.latLng); map.panBy(0, -120);';
			$marker['icon'] = base_url().'icons/red-dot.png';
			$marker['id'] = $row->user_id;

			$this->googlemaps->add_marker($marker);

			$custom_js_global .= "var marker_".$row->user_id."_settings = {};\n";
			$custom_js_init .= "marker_".$row->user_id."_settings[\"type\"] = '".$row->tipo."';\n";
			$custom_js_init .= "marker_".$row->user_id."_settings[\"items\"] = new Array();\n";
			$custom_js_init .= "marker_".$row->user_id."_settings.items.push( new Array('".$row->cat_id."','".$row->sit_id."') );\n";
			$custom_js_init .= "marker_".$row->user_id."_settings[\"mrk\"] = marker_".$row->user_id.";";
			$custom_js_init .= "markers_settings.push( marker_".$row->user_id."_settings );";

			$markers_created[] = $row->user_id;
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

			$custom_js_global .= "var radiusCircles = new Array();";
			$numCircles = 0;

			$raios = $this->params['raios_busca'];
			$cores = array('blue', 'green', 'yellow', 'orange', 'red');
			foreach ($raios as $raio => $desc_raio) {
				if($raio==0) continue;

				$circle = array();
				$circle['center'] = $user_data['lat'].', '.$user_data['lng'];
				$circle['radius'] = $raio*1000;
				$circle['fillOpacity'] = '0.3';
				$circle['fillColor'] = $cores[ $numCircles ];
				$this->googlemaps->add_circle($circle);

				$custom_js_init .= "radiusCircles.push(circle_".$numCircles.");";

				$numCircles++;
			}
		}

		$custom_js_global .= "var num_circles = ".count($this->googlemaps->circles).";";

		$config['custom_js_global'] = $custom_js_global;
		$config['custom_js_init'] = $custom_js_init;

		$this->googlemaps->initialize($config);
		$map = $this->googlemaps->create_map();

		$view_data = array('map'=>$map,
			'categorias'=>$categorias,
			'situacoes'=>$situacoes );

		$cust_js = array('js/map.js');

		$this->load->view('head', array('title'=>'Slonga!!!',
			'min_template'=>'image_view', 'cust_js'=>$cust_js));
		$this->load->view("slonga", $view_data);
		$this->load->view('foot');
	}
}