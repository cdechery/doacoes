<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends MY_Controller {
	public function index() {
		$this->load->model('notificacao_model');

		$notifs = $this->notificacao_model->get_pending_notifs();

		if( count($notifs) ) {
			// envia emails
			$this->notificacao_model->purge();
		}

		$prepare = $this->notificacao_model->prepare_notifs_table();
		if( $prepare ) {
			// envia emails
			$this->notificacao_model->purge();
		}
	}
}