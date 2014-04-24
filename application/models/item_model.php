<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = "item";
	}

	public function get($item_id) {
		return $this->db->get_where('item', array('id'=>$id))->row_array();
	}

	public function get_user_items($usuario_id) {
		$items = $this->db->get_where('item', array('id'=>$usuario_id))->result();
		return $items;
	}

	public function insert( $item_data ) {
		$insert_data = array(
			'descricao' => $item_data['desc'],
			'status' => 'I', // disponivel
			'categoria_id' => $item_data['categ'],
			'usuario_id' => $item_data['usuario_id'],
			'situacao_id' => $item_data['sit'],
		);

		$this->db->set('dt_inclusao', 'NOW()', false);

		if( $this->db->insert('item', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

}
