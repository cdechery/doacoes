<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends MY_Controller {
	private $last_email_err = "";

	public function index() {
		$this->load->model('usuario_model');
		$this->load->model('item_model');

		$this->load->model('notificacao_model');

		log_message('info',
			'Iniciando processo de notificacoes');
		$old_notifs = $this->notificacao_model->get_pending_notifs();
		log_message('info',
			'Encontradas '.$old_notifs.' notificacoes pendentes');

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
		if( $prepare>0 ) {
			$new_notifs = $this->notificacao_model->get_pending_notifs();
			log_message('info',
				'Encontradas '.$new_notifs.' novas notificacoes');
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
		$user_email = "";
		$user_itens = array();

		foreach ($result_set as $row) {

			if( $user_id!=0 && $row->usuario_id!=$user_id ) {
				log_message('info',
					'Enviando email para $user_email, '.count($user_itens).' itens');
				$user_itens = array();

				if( $this->send_email($user_email, $user_itens) ) {
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

		$emailmsg = $this->load_email('email_notif_itens',
			array('itens'=>$itens) );
		$this->email->message( $emailmsg );

		$ret = $this->email->send();
		$this->last_email_err = $this->email->print_debugger();

		return $ret;
	}
}