<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$this->db->select('u.id as user_id, u.lat, u.lng, 
			u.tipo, c.id as cat_id, s.id as sit_id,
			ifnull(it.categoria_id,0) as int_id', FALSE);
		$this->db->from('usuario u');
		$this->db->join('interesse it',
			'u.id = it.usuario_id AND it.fg_ativo = \'S\'', 'left');
		$this->db->join('item i', 'u.id = i.usuario_id');
		$this->db->join('categoria c', 'c.id = i.categoria_id');
		$this->db->join('situacao s', 's.id = i.situacao_id');
		$this->db->where('u.tipo','P'); //Pessoa
		$this->db->where('i.status','A'); //Ativo
		$this->db->order_by('u.id', 'asc');
		$pessoas = $this->db->get()->result();


		$this->db->select('u.id as user_id, u.lat, u.lng, 
			u.tipo, ifnull(c.id,0) as cat_id, ifnull(s.id,0) as sit_id,
			ifnull(it.categoria_id,0) as int_id', FALSE);
		$this->db->from('usuario u');
		$this->db->join('interesse it',
			'u.id = it.usuario_id AND it.fg_ativo = \'S\'', 'left');
		$this->db->join('item i', 'u.id = i.usuario_id AND i.status=\'I\'', 'left');
		$this->db->join('categoria c', 'c.id = i.categoria_id', 'left');
		$this->db->join('situacao s', 's.id = i.situacao_id', 'left');
		$this->db->where('u.tipo','I'); //Instituicao
		$this->db->order_by('u.id', 'asc');
		$insts = $this->db->get()->result();

		return array_merge($pessoas, $insts);
	}
}
