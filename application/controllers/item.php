<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends MY_Controller { 
	
	public function __construct() {
		parent::__construct();
		$this->load->model('item_model');
	}

	public function insert() {
		$status = "";
		$msg = "";
		$new_id = 0;

		if( !$this->is_user_logged_in ) {
			$status = "ERROR";
			$msg = xlang('dist_errsess_expire');
			echo json_encode(array('status' => $status,
				'msg' => utf8_encode($msg) );
			return;
		}

		$inter_data = $this->input->post(NULL, TRUE);

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('desc', 'Descrição',
			'required|min_length[10]|max_length[200]|valid_email');
		$this->form_validation->set_rules('categ', 'Categoria', 'required');
		$this->form_validation->set_rules('sit', 'Situação', 'required');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {

			$item_data['usuario_id'] = $this->login_data['user_id'];

			$new_id = $this->item_model->insert( $inter_data );
			if( $new_id ) {
				$status = "OK";
				$msg = 'O Item foi incluído com sucesso';
			} else {
				$status = "ERROR";
				$msg = 'Não foi possível incluir o Item';
			}
		}

		echo json_encode( array('status'=>$status,
			'msg'=>utf8_encode($msg), 'item_id' => $new_id );
	}
}