<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$this->db->select('u.id as user_id, u.lat, u.lng, 
			u.tipo, c.id as cat_id, s.id as sit_id');
		$this->db->from('usuario u');
		$this->db->join('item i', 'u.id = i.usuario_id');
		$this->db->join('categoria c', 'c.id = i.categoria_id');
		$this->db->join('situacao s', 's.id = i.situacao_id');
		$this->db->where('i.status','I'); //Disponivel
		$this->db->where('u.tipo','P'); 
		$this->db->order_by('u.id', 'asc');
		$pessoas = $this->db->get()->result();

		$this->db->select('u.id as user_id, u.lat, u.lng, 
			u.tipo, c.id as cat_id, 0 as sit_id', FALSE);
		$this->db->from('usuario u');
		$this->db->join('interesse i', 'u.id = i.usuario_id');
		$this->db->join('categoria c', 'c.id = i.categoria_id');
		$this->db->where('i.fg_ativo', 'S');
		$this->db->where('u.tipo','I'); 
		$this->db->order_by('u.id', 'asc');
		$insts = $this->db->get()->result();

		return array_merge($pessoas, $insts);
	}
}
