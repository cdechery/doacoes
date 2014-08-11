<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends MY_Controller {
	private $last_email_err = "";

	public function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->helper('email');
	}

	public function index() {
		$this->require_auth();

		$this->load->model('usuario_model');
		$this->load->model('item_model');
		$this->load->model('notificacao_model');
		$this->load->helper('image_helper');

		log_message('info',
			'Iniciando processo de notificacoes');
		$old_notifs = $this->notificacao_model->get_pending_notifs();
		log_message('info',
			'Encontradas '.count($old_notifs).' notificacoes pendentes');

		if( count($old_notifs) ) {
			$this->processa_notifs( $old_notifs );
			log_message('info',
				'Notificacoes pendentes processadas');
			$this->notificacao_model->purge();
			log_message('info',
				'Notificacoes processadas expurgadas');
		} 

		log_message('info',
			'Preparando tabela para novas notificacoes');
		$prepare = $this->notificacao_model->prepare_notifs_table();
		if( $prepare > 0 ) {
			$new_notifs = $this->notificacao_model->get_pending_notifs();
			log_message('info',
				'Encontradas '.count($new_notifs).' novas notificacoes');
			$this->processa_notifs( $new_notifs );
			$this->notificacao_model->purge();
			log_message('info',
				'Novas notificacoes expurgadas');
		} else {
			log_message('info',
				'Sem novas notificacoes');
		}

		log_message('info',
			'Fim do processo de notificacoes');
	}

	private function processa_notifs( $result_set ) {
		$size = count($result_set);
		$user_id = 0;
		$user_email = $name = "";
		$user_itens = array();
		$fg_notif = "";

		foreach ($result_set as $row) {

			if( $user_id!=0 && $row->usuario_id!=$user_id ) {
				$mail_sent = false;

				if( $fg_notif ) {
					log_message('info',
						'Enviando email para $user_email, '.count($user_itens).' itens');

					$params = $this->monta_email( $user_email, $name, $user_itens);
					$mail_sent = send_email( $params );
				}

				if( ($fg_notif && $mail_sent) || !$fg_notif ) {
					$this->notificacao_model->set_notificado( $user_id );
				} else {
					log_message('error', 
						'Erro ao enviar email\n'.$this->last_email_err);
				}
				$user_itens = array();
			}

			$fg_notif = $row->fg_notif_int_email=='S';
			$user_itens[] = array( 'id'=>$row->item_id, 
				'titulo'=>$row->titulo, 'nome_arquivo'=>$row->nome_arquivo );
			$user_id = $row->usuario_id;
			$user_email = $row->email;
			$name = $row->nome;
		}

		
		if( $fg_notif ) {
			log_message('info',
				'Enviando email para $user_email, '.count($user_itens).' itens');

			$params = $this->monta_email( $user_email, $name, $user_itens);
			$mail_sent = send_email( $params );
		}

		if( ($fg_notif && $mail_sent) || !$fg_notif ) {
			$this->notificacao_model->set_notificado( $user_id );
		} else {
			log_message('error', 
				'Erro ao enviar email\n'.$this->last_email_err);
		}
	}

	private function monta_email($para, $nome, $itens) {
		$corpo = $this->load->view('email_notif_itens',
			array('itens'=>$itens, 'nome'=>$nome), TRUE);

		$params = array(
			'to_email'=> $para,
			'from_email'=>'noreply@interessa.org',
			'from_name'=> 'Interessa.org',
			'subject'=> 'Novos Itens que podem te interessar',
			'body'=>$corpo
		);

		return $params;
	}
}