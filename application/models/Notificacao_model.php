<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function insert_item($item_id, $usuario_id = 0) {
		$insert_data = array(
			'item_id' => $item_id
		);

		if( $user_id != 0 ) {
			$insert['usuario_id'] = $usuario_id; 
		}

		return $this->db->insert('controle_notif_email', $insert_data);
	}

	public function set_notificado($item_id, $usuario_id) {
		$upd_data = array(
			'fg_email_enviado' => 'S'
		);

		$where = array('item_id' => $item_id,
			'usuario_id' => $usuario_id);

		return $this->db->update('controle_notif_email', $upd_data, $where);
	}

	public function purge() {
		return $this->tb->truncate('controle_notif_email');
	}

	public 
}