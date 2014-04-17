<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends MY_Controller {
	public function index() {
		$this->load->model('notificacao_model');

		$old_notifs = $this->notificacao_model->get_pending_notifs();

		if( count($old_notifs) ) {
			$this->send_emails( $old_notifs );
			$this->notificacao_model->purge();
		}

		$prepare = $this->notificacao_model->prepare_notifs_table();
		if( $prepare>0 ) {
			$new_notifs = $this->notificacao_model->get_pending_notifs();
			$this->send_emails( $new_notifs );
			$this->notificacao_model->purge();
		}
	}

	private function send_emails( $result_set ) {
		$size = count($result_set);
		$user_id = 0;
		$user_email = "";
		$user_itens = array();

		foreach ($result_set as $row) {

			if( ($user_id!=0 && $row->usuario_id!=$user_id) ) {
				echo "Enviando email para ".$user_email;
				echo " [itens: ".join(",",$user_itens)."]<br>";
				$user_itens = array();
			}

			$user_itens[] = $row->item_id;
			$user_id = $row->usuario_id;
			$user_email = $row->email;

			$this->notificacao_model->set_notificado( $row->usuario_id );
		}

		echo "Enviando email para ".$user_email;
		echo " [itens: ".join(",",$user_itens)."]<br>";
		$this->notificacao_model->set_notificado( $user_id );
	}
}