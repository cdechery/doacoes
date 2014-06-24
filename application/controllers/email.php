<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller { 
	public function __construct() {
		parent::__construct();
	}

	public function quer_item( $item_id = 0) {
		if( !$this->is_user_logged_in ) {
			$this->show_access_error("ajax");
		}

		$this->load->model('item_model');
		$this->load->model('usuario_model');
		$this->load->helper('image_helper');

		$item = $this->item_model->get( $item_id );
		$from_user = $this->usuario_model->get_data( $this->login_data['user_id'] );
		$to_user = $this->usuario_model->get_data( $item['usuario_id'] );

		$this->load_ajax('email_item_form',
			array('item'=>$item, 'from_user'=>$from_user,
				'to_user'=>$to_user) );
	}

	public function enviar_quer_item() {
		$this->load->library('email');
		$this->load->helper('email');

		$status = "";
		$msg = "";

		$form_data = $this->input->post(NULL, TRUE);

		$this->load->model('item_model');
		$item = $this->item_model->get( $form_data['item_id'] );

		$assunto = $form_data['assunto'];
		if( empty($assunto) ) {
			$assunto = "Me interessei por um item seu";
		}

		$msg = "O(a) usuario(a) ".$form_data['de_nome']." se interessou pelo seu item: ".$item['titulo']."<br><br>";
		$msg .= "Para entrar em contato com ele(a), basta responder a este email.";
		if( !empty($form_data['corpo']) ) { 
			$msg .= "<br><br>Abaixo a mensagem que ele(a) deixou pra você: <br>".$form_data['corpo'];
		}
		$corpo = $this->load->view('email_quer_item',
			array('corpo'=>$corpo), TRUE);

		$params = array(
			'to_email'=> $form_data['para_email'],
			'to_name'=>$form_data['para_nome'],
			'from_email'=>'noreply@interessa.org',
			'from_name'=>$form_data['de_nome']." - Interessa",
			'subject'=>$assunto,
			'body'=>$corpo
		);

		if( send_email( $params ) ) {
			$status = "OK";
			$msg = "Email enviado com sucesso";
		} else {
			$status = "ERROR";
			$msg = "Não foi possível enviar o email";
		}

		echo json_encode( array('status'=>$status,
			'msg'=>utf8_encode($msg)) );
	}

	public function contato_inst( $inst_id = 0 ) {
		if( !$this->is_user_logged_in ) {
			$this->show_access_error("ajax");
		}

		$this->load->model('usuario_model');
		$this->load->helper('image_helper');

		$from_user = $this->usuario_model->get_data( $this->login_data['user_id'] );
		$to_user = $this->usuario_model->get_data( $inst_id );

		$this->load_ajax('email_contato_inst_form',
			array('from_user'=>$from_user,
				'to_user'=>$to_user) );
	}

	public function enviar_contato_inst() {
		$this->load->library('email');
		$this->load->helper('email');

		$status = "";
		$msg = "";

		$form_data = $this->input->post(NULL, TRUE);

		$msg = "Olá ".$form_data['para_nome'].", o(a) ".$form_data['de_nome']." usou nosso site ".
			"para te mandar uma mensagem, veja abaixo:<br> ";
		$msg .= $form_data['corpo'];
		$corpo = $this->load->view('email_contato_inst',
			array('corpo'=>$corpo), TRUE);

		$params = array(
			'to_email'=> $form_data['para_email'],
			'to_name'=>$form_data['para_nome'],
			'from_email'=>'noreply@interessa.org',
			'from_name'=>$form_data['de_nome']." - Interessa",
			'subject'=>$assunto,
			'body'=>$corpo
		);

		if( send_email($params) ) {
			$status = "OK";
			$msg = "Email enviado com sucesso";
		} else {
			$status = "ERROR";
			$msg = "Não foi possível enviar o email";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

}