<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = "item";
	}

	public function get($item_id) {
		return $this->db->get_where('item',
			array('id'=>$item_id))->row_array();
	}

	public function get_list( $item_ids ) {
		$this->db->select('it.id, it.titulo, 
			it.descricao, it.categoria_id, im.id imagem_id,
			im.nome_arquivo, max(im.id)', FALSE);
		$this->db->from('item it');
		$this->db->join('imagem im', 'it.id = im.item_id', 'left');
		$this->db->where_in('it.id', $item_ids );
		$this->db->group_by('it.id');
		$items = $this->db->get()->result();

		return $items;
	}

	public function get_temp_id($usuario_id) {
		$item = $this->db->get_where('item_temp',
			array('usuario_id'=>$usuario_id))->row();

		if( count($item) ) {
			return $item->id;
		} else {
			$insert_array = array('usuario_id'=>$usuario_id);
			$this->db->set('data_criacao', 'NOW()', false);
			$this->db->insert('item_temp', $insert_array);
			
			return $this->get_temp_id($usuario_id);
		}
	}

	public function get_user_items( $usuario_id ) {
		$this->db->select('it.id item_id, it.titulo, 
			it.descricao, it.status, it.categoria_id, im.id imagem_id, im.nome_arquivo');
		$this->db->from('item it');
		$this->db->join('imagem im', 'it.id = im.item_id', 'left');
		$this->db->where('it.usuario_id', $usuario_id);
		$items = $this->db->get()->result();

		return $items;
	}

	public function insert( $item_data ) {
		$insert_data = array(
			'descricao' => $item_data['desc'],
			'status' => 'I', // disponivel
			'titulo' => $item_data['titulo'],
			'categoria_id' => $item_data['categ'],
			'usuario_id' => $item_data['usuario_id'],
			'situacao_id' => $item_data['sit'],
		);

		$this->db->set('data_inclusao', 'NOW()', false);

		if( $this->db->insert('item', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

	public function delete( $item_id ) {
		if( empty($item_id) ) {
			return false;
		};
		if ($this->db->delete('item', array('id'=>$item_id))) {
			return true;
		} else {
			return false;
		}
	}

	public function change_status( $id, $status ) {
		if($this->db->update('item', array('status'=>$status), array('id'=>$id))) {
			return true;
		} else {
			return false;
		}
	}

	public function given( $id, $status ) {
		$this->db->set('data_doacao', 'NOW()', false);
		if($this->db->update('item', array('status'=>$status), array('id'=>$id))) {
			return true;
		} else {
			return false;
		}
	}

	public function update( $item_data ) {
		$upd_data = array(
			'descricao' => $item_data['desc'],
			'titulo' => $item_data['titulo'],
			'categoria_id' => $item_data['categ'],
			'situacao_id' => $item_data['sit'],
		);

		if( $this->db->update('item', $upd_data,
			array('id'=>$item_data['id']) ) ) {
			return true;
		} else {
			return false;
		}
	}

}
