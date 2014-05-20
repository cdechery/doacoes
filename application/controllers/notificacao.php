<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends MY_Controller {
	private $last_email_err = "";

	public function index() {
		$this->load->model('usuario_model');
		$this->load->model('item_model');

		$this->load->model('notificacao_model');

		$old_notifs = $this->notificacao_model->get_pending_notifs();

		if( count($old_notifs) ) {
			$this->processa_notifs( $old_notifs );
			$this->notificacao_model->purge();
		}

		$prepare = $this->notificacao_model->prepare_notifs_table();
		if( $prepare>0 ) {
			$new_notifs = $this->notificacao_model->get_pending_notifs();
			$this->processa_notifs( $new_notifs );
			$this->notificacao_model->purge();
		}
	}

	private function processa_notifs( $result_set ) {
		$size = count($result_set);
		$user_id = 0;
		$user_email = "";
		$user_itens = array();

		foreach ($result_set as $row) {

			if( ($user_id!=0 && $row->usuario_id!=$user_id) ) {
				log_message('info',
					'Enviando email para $user_email, '.count($user_itens).' itens');
				$user_itens = array();

				if( $this->send_email($user_email, $user_itens) ) {}
					$this->notificacao_model->set_notificado( $user_id );
				} else {
					log_message('error', 
						'Erro ao enviar email\n'.$this->last_email_err);
				}
			}

			$user_itens[] = array( 'id'=>$row->item_id, 
				'titulo'=>$row->titulo, 'nome_arquivo'=>$row->nome_arquivo );
			$user_id = $row->usuario_id;
			$user_email = $row->email;
		}

		log_message('info',
			'Enviando email para $user_email, '.count($user_itens).' itens');
		if( $this->send_email($user_email, $user_itens) ) {}
			$this->notificacao_model->set_notificado( $user_id );
		} else {
			log_message('error', 'Erro ao enviar email\n'.$this->last_email_err);
		}
	}

	private function send_email($para, $itens) {
		$this->last_email_err = "";

		$this->email->clear();
		$this->email->initialize($this->params['email']);

		$this->email->from( 'alerta@quemprecisa.org', "QuemPrecisa" );
		$this->email->to( $para );
		$this->email->subject( 'Novos itens que podem te interessar' );

		$emailmsg = $this->load->view('email_notif_itens',
			array('itens'=>$itens), TRUE);
		$this->email->message( $emailmsg );

		$ret = $this->email->send();
		$this->last_email_err = $this->email->print_debugger();

		return $ret;
	}
}