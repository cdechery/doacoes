<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends MY_Controller { 
	
	public function __construct() {
		parent::__construct();
		$this->load->model('item_model');
		$this->load->helper('xlang');
	}

	public function novo() {
		if( !$this->is_user_logged_in ) {
			$this->show_access_error();
		}

		$this->load->model('categoria_model');
		$categorias = $this->categoria_model->get_all();

		$this->load->model('situacao_model');
		$situacoes = $this->situacao_model->get_all();

		$head_data = array('min_template'=>'image_upload', "title"=>$this->params['titulo_site']);
		$this->load->view('head', $head_data);

		$temp_id = $this->item_model->get_temp_id($this->login_data['user_id']);

		$data = array('action' => 'insert',
			'temp_id'=>$temp_id,
			'situacoes'=>$situacoes,
			'categorias'=>$categorias);
		$this->load->view('item_form', array('data'=>$data) );
		$this->load->view('foot');
	}

	public function insert() {
		$status = "";
		$msg = "";
		$new_id = 0;

		if( !$this->is_user_logged_in ) {
			$status = "ERROR";
			$msg = xlang('dist_errsess_expire');
			echo json_encode(array('status' => $status,
				'msg' => utf8_encode($msg)) );
			return;
		}

		$input = $this->input->post(NULL, TRUE);

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('titulo', 'Título',
			'required|min_length[10]|max_length[70]');
		$this->form_validation->set_rules('desc', 'Descrição',
			'required|min_length[10]|max_length[250]');
		$this->form_validation->set_rules('categ', 'Categoria', 'required');
		$this->form_validation->set_rules('sit', 'Situação', 'required');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {

			$item_data['usuario_id'] = $this->login_data['user_id'];

			$new_id = $this->item_model->insert( $input );
			if( $new_id ) {
				$this->load->model('image_model');
				$this->image_model->move_temp_images($item_data['usuario_id'],
					$new_id, $input['temp_id'] );
				$status = "OK";
				$msg = 'O Item foi incluído com sucesso';
			} else {
				$status = "ERROR";
				$msg = 'Não foi possível incluir o Item';
			}
		}

		echo json_encode( array('status'=>$status,
			'msg'=>utf8_encode($msg), 'item_id' => $new_id) );
	}

	public function modify( $item_id ) {
		$msg = $this->check_owner($this->item_model, $item_id);
		if( $msg ) {
			show_error($msg);
		}

		$this->load->helper('image_helper');

		$head_data = array("min_template"=>"image_upload", "title"=>$this->params['titulo_site']);
		$this->load->view('head', $head_data);

		$item_data = $this->item_model->get( $item_id );
		$item_data['action'] = 'update';

		$images = $this->get_images( $item_id );

		$this->load->view('item_form',
			array('data'=>$item_data, 'images'=>$images) );
		$this->load->view('foot');
	}

	public function get_images( $item_id ) {
		$this->load->model('image_model');
		return $this->image_model->get_item_images( $item_id );
	}

	public function map_view( $item_id ) {
		$item_data = $this->item_model->get( $item_id );
		$img_data = $this->get_images( $item_id );

		$this->load_iframe('item_view', 
			array('idata'=>$item_data, 'imgdata'=>$img_data));
	}
}