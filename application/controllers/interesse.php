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

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('categ', 'Categoria', 'required');
		//$this->form_validation->set_rules('raio', 'Raio de Busca', 'required');

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

	public function activate( $categoria_id ) {
		$status = "";
		$msg = "";

		$msg = $this->check_owner($this->interesse_model,$categoria_id);
		if( $msg ) {
			$status = "error";
			echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
			return;
		}

		$user_id = $this->login_data['user_id'];

		if( $this->interesse_model->activate($categoria_id, $user_id) ) {
			$status = "success";
			$msg = "O Interesse foi ativado com sucesso";
		} else {
			$status = "error";
			$msg = "Ocorreu uma falha ao ativar o Interesse, tente novamente";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function deactivate( $categoria_id ) {
		$status = "";
		$msg = "";

		$msg = $this->check_owner($this->interesse_model,$categoria_id);
		if( $msg ) {
			$status = "error";
			echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
			return;
		}

		$user_id = $this->login_data['user_id'];

		if( $this->interesse_model->deactivate($categoria_id, $user_id) ) {
			$status = "success";
			$msg = "O Interesse foi desativado com sucesso";
		} else {
			$status = "error";
			$msg = "Ocorreu uma falha ao desativar o Interesse, tente novamente";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function update( $categoria_id, $raio ) {
		$status = "";
		$msg = "";

		$msg = $this->check_owner($this->interesse_model,$categoria_id);
		if( $msg ) {
			$status = "error";
			echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
			return;
		}

		$inter_data = array('user_id'=>$this->login_data['user_id'],
			'cat_id'=> $categoria_id,
			'raio'=>$raio );

		if( $this->interesse_model->update( $inter_data ) ) {
			$status = "success";
			$msg = 'O Interesse foi atualizado com sucesso';
		} else {
			$status = "error";
			$msg = 'Não foi possível atualizar o interesse';
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function purge_old() {
		$this->require_auth();

		log_message('info', 'Iniciando processo de limpeza de Interesses');
		$this->load->library('email');

		$dias_pessoa = $this->params['validade_interesse_pessoa'];
		$dias_inst = $this->params['validade_interesse_inst'];

		$old_ints = $this->interesse_model->get_old( $dias_pessoa, $dias_inst );
		log_message('info', 'Foram encontrados '.count($old_ints).' expirados');

		if( count($old_ints)==0 ) {
			log_message('info', 'Nada a fazer. Terminando processo!');
			return;
		}

		$categorias = array();
		$user_id = 0;

		log_message('info', 'Processando notificacoes e exclusao de Interesses');
		foreach ($old_ints as $int) {
			if( $user_id!=0 && $user_id!=$int->usuario_id ) {
				$this->notify_delete($int->email, $categorias, $int->nome_usuario);
				$this->interesse_model->delete($int->categoria_id, $int->usuario_id);

				$categorias = array();
			}

			$categorias[] = $int->nome_cat;
			$user_id = $int->usuario_id;
		}

		$this->notify_delete($int->email, $categorias, $int->nome_usuario);
		$this->interesse_model->delete($int->categoria_id, $int->usuario_id);

		log_message('info', 'Fim do processo de exclusao de Interesses');
	}

	private function notify_delete($para, $cats, $nome) {
		$this->last_email_err = "";

		$this->email->clear();

		$this->email->from( 'alerta@quemprecisa.org', "QuemPrecisa" );
		$this->email->to( $para );
		$this->email->subject( 'Interesses expirados' );

		$emailmsg = $this->load_email('email_notif_interesses',
			array('categorias'=>$cats, 'nome'=>$nome) );
		$this->email->message( $emailmsg );

		echo $emailmsg; 

		$ret = $this->email->send();
		$this->last_email_err = $this->email->print_debugger();

		return $ret;
	}
} // Image class
