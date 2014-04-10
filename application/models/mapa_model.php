<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$this->db->select('u.id as user_id, u.lat, u.lng, 
			c.id as cat_id, s.id as sit_id');
		$this->db->from('usuario u');
		$this->db->join('item i', 'u.id = i.usuario_id');
		$this->db->join('categoria c', 'c.id = i.categoria_id');
		$this->db->join('situacao s', 's.id = i.situacao_id');
		$this->db->where('i.status','I'); //Disponivel
		return $this->db->get()->result();
	}
}
