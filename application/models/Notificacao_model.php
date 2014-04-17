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

	public function set_notificado($usuario_id) {
		$upd_data = array(
			'fg_email_enviado' => 'S'
		);

		$where = array('usuario_id' => $usuario_id);

		return $this->db->update('controle_notif_email', $upd_data, $where);
	}

	public function purge() {
		$this->db->where('fg_email_enviado', 'S');
		$this->db->delete('controle_notif_email');
	}

	public function prepare_notifs_table() {
		$q = $this->db->query('
			INSERT IGNORE INTO controle_notif_email
			(item_id, usuario_id)
			SELECT n.item_id, t.usuario_id
			FROM controle_notif_email n, item i, interesse t, usuario u, usuario o
			WHERE n.item_id = i.id
			AND i.usuario_id = o.id
			AND i.categoria_id = t.categoria_id
			AND t.usuario_id = u.id
			AND (
				((ACOS(SIN(u.lat * PI() / 180) * SIN(o.lat * PI() / 180) + 
         		COS(u.lat * PI() / 180) * COS(o.lat * PI() / 180) * COS((u.lng - o.lng) * 
         		PI() / 180)) * 180 / PI()) * 60 * 1.1515)*1.6 < t.raio_busca
				OR t.raio_busca = 0
				)
			');

		if( $q ) {
			$this->db->where('usuario_id', '-1');
			$this->db->delete('controle_notif_email');
		}
	}

	public function get_pending_notifs() {
		$this->db->select('item_id, usuario_id');
		$this->db->from('controle_notif_email');
		$this->db->where('usuario_id !=', '-1');
		$this->db->where('fg_email_enviado', 'N');
		return $this->db->get()->result();
	}
}