<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interesse_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = "interesse";
	}

	public function get_by_userid( $user_id ) {
		$ints =  $this->db->get_where('interesse',array('usuario_id'=>$user_id))->result();
		return $ints;
	}

	public function activate( $id ) {
		$upd_data = arra('fg_ativo'=> 'S');

		return( $this->db->update('interesse', $upd_data, array('id' => $id)) );
	}

	public function deactivate( $id ) {
		$upd_data = arra('fg_ativo'=> 'N');

		return( $this->db->update('interesse', $upd_data, array('id' => $id)) );
	}

	public function insert( $inter_data ) {
		$insert_data = array(
			'user_id' => $inter_data['usuario_id'],
			'raio_busca' => $inter_data['raio'],
			'categoria_id' => $inter_data['categoria_id']
		);

		$this->db->set('data_cadastro', 'NOW()', false);

		if( $this->db->insert('interesse', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

	public function update( $inter_id, $raio ) {
		$upd_data = array('raio_busca'=> 'raio');

		return( $this->db->update('interesse', $upd_data, array('id' => $inter_id)) );
	}

	public function delete( $inter_id ) {
		$this->db->delete('interesse', array('id' => $inter_id) );
	}
}
