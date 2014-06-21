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
		$status = "";
		$msg = "";

		$form_data = $this->input->post(NULL, TRUE);

		$this->load->model('item_model');
		$item = $this->item_model->get( $form_data['item_id'] );

		$assunto = $form_data['assunto'];
		if( empty($assunto) ) {
			$assunto = "Me interessei por um item seu";
		}

		$corpo = "O(a) usuario(a) ".$form_data['de_nome']." se interessou pelo seu item: ".$item['titulo']."<br><br>";
		$corpo .= "Para entrar em contato com ele(a), basta responder a este email.";
		if( !empty($form_data['corpo']) ) { 
			$corpo .= "<br><br>Abaixo a mensagem que ele(a) deixou pra você: <br>".$form_data['corpo'];
		}

		$this->load->library('email');

		$this->email->from( 'noreply@interessa.org', $form_data['de_nome']." - Interessa" );
		$this->email->reply_to( $form_data['de_email'] );
		$this->email->to( $form_data['para_email'], $form_data['para_nome'] );
		$this->email->subject( $assunto );

		$emailmsg = $this->load_email('email_quer_item',
			array('corpo'=>$corpo));

		$this->email->message( $emailmsg );

		if( $this->email->send() ) {
			$status = "OK";
			$msg = "Email enviado com sucesso";
		} else {
			$status = "ERROR";
			$msg = "Não foi possível enviar o email";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
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
		$status = "";
		$msg = "";

		$form_data = $this->input->post(NULL, TRUE);

		$this->load->library('email');

		$this->email->from( $form_data['de_email'], "QuemPrecisa [".$form_data['de_nome']."]" );
		$this->email->to( $form_data['para_email'], $form_data['para_nome'] );
		$this->email->subject( $assunto );

		$corpo = "Olá ".$form_data['para_nome'].", o(a) ".$form_data['de_nome']." usou nosso site ".
			"para te mandar uma mensagem, veja abaixo:<br> ";
		$corpo .= $form_data['corpo'];

		$emailmsg = $this->load_email('email_contato_inst',
			array('corpo'=>$corpo));

		$this->email->message( $emailmsg );

		if( $this->email->send() ) {
			$status = "OK";
			$msg = "Email enviado com sucesso";
		} else {
			$status = "ERROR";
			$msg = "Não foi possível enviar o email";
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

}