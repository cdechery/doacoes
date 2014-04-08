<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interesse extends MY_Controller { 
	
	public function __construct() {
		parent::__construct();
		$this->load->model('interesse_model');
	}

	public function get_single($user_id, $categoria_id) {
		$int = $this->interesse_model->get($user_id, $categoria_id);
		$this->load->view( 'interesse_single', array('interesse'=> $int) );
	}

	public function insert() {
		$status = "";
		$msg = "";
		$new_id = 0;

		$inter_data = $this->input->post(NULL, TRUE);

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('categ', 'Categoria', 'required');
		$this->form_validation->set_rules('raio', 'Raio de Busca', 'required');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {
			$existente = $this->interesse_model->get( $this->login_data['user_id'],
				$inter_data['categ'] );

			if( $existente ) {
				$status = "ERROR";
				$msg = "Já existe um Interesse para esta Categoria";
				echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
				return;
			}

			$inter_data['user_id'] = $this->login_data['user_id'];

			if( $this->interesse_model->insert( $inter_data ) ) {
				$status = "OK";
				$msg = 'O Interesse foi incluído com sucesso';
			} else {
				$status = "ERROR";
				$msg = 'Não foi possível incluir o interesse';
			}
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg),
			'user'=>$this->login_data['user_id'],
			'cat'=>$inter_data['categ']) );
	}

	public function activate( $categoria_id, $user_id ) {
		$status = "";
		$msg = "";

		if( $this->interesse_model->activate($categoria_id, $user_id) ) {
			$status = "OK";
			$msg = "O Interesse foi ativado com sucesso";
		} else {
			$status = "ERRO";
			$msg = "Ocorreu uma falha ao ativar o Interesse, tente novamente";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function deactivate( $categoria_id, $user_id ) {
		$status = "";
		$msg = "";

		if( $this->interesse_model->deactivate($categoria_id, $user_id) ) {
			$status = "OK";
			$msg = "O Interesse foi desativado com sucesso";
		} else {
			$status = "ERRO";
			$msg = "Ocorreu uma falha ao desativar o Interesse, tente novamente";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function update( $inter_data ) {
		$status = "";
		$msg = "";

		$inter_data = $this->input->post(NULL, TRUE);

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('raio', 'Raio de Busca', 'required');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {
			$inter_data['user_id'] = $this->login_data['user_id'];
			$new_id = $this->interesse_model->update( $inter_data );

			if( $new_id > 0 ) {
				$status = "OK";
				$msg = 'O Interesse foi atualizado com sucesso';
			} else {
				$status = "ERROR";
				$msg = 'Não foi possível atualizar o interesse';
			}
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg), 'new_id'=>$new_id) );
	}

	public function delete( $id ) {
		$status = "";
		$msg = "";

		if( $this->interesse_model->delete( $id ) ) {
			$status = "OK";
			$msg = "O Interesse foi excluído com sucesso";
		} else {
			$status = "ERRO";
			$msg = "Ocorreu uma falha ao excluir o Interesse, tente novamente";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

} // Image class
