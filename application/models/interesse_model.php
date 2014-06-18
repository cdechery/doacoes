<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interesse_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = "interesse";
		$this->pk = "categoria_id";
	}

	public function get( $user_id, $categoria_id = 0 ) {
		$this->db->select('c.id, c.nome as categoria, i.raio_busca, i.fg_ativo');
		$this->db->select("date_format(i.data_inclusao, '%d/%m/%Y') as data", FALSE);
		$this->db->from('interesse i');
		$this->db->join('categoria c', 'c.id = i.categoria_id');
		$this->db->where('i.usuario_id', $user_id);

		if( $categoria_id!= 0 ) {
			$this->db->where('i.categoria_id', $categoria_id);
			$ints = $this->db->get()->row();
		} else {
			$ints = $this->db->get()->result();
		}

		return $ints;
	}

	public function get_old($dias_pessoa, $dias_inst) {
		$q = $this->db->query('SELECT i.categoria_id, i.usuario_id, '.
			'c.nome nome_cat, u.nome nome_usuario, u.email '.
			'FROM interesse i, usuario u, categoria c '.
			'WHERE i.usuario_id = u.id '.
			'AND i.categoria_id = c.id'.
			'AND ( ( '.
			'	date_sub(curdate(),INTERVAL 30 day) > i.data_inclusao'.
			'	AND u.tipo=\'P\''.
			') OR ( '.
			'	date_sub(curdate(),INTERVAL 180 day) > i.data_inclusao'.
			'	AND u.tipo=\'I\''.
			') ) GROUP BY u.id');

		return $q;
	}


	public function activate( $categoria_id, $user_id ) {
		if( empty($categoria_id) || empty($user_id) ) {
			return FALSE;
		}

		$upd_data = array('fg_ativo' => 'S');
		$where = array('categoria_id'=>$categoria_id, 'usuario_id'=>$user_id);

		return( $this->db->update('interesse', $upd_data, $where) );
	}

	public function deactivate( $categoria_id, $user_id ) {
		if( empty($categoria_id) || empty($user_id) ) {
			return FALSE;
		}

		$upd_data = array('fg_ativo'=> 'N');
		$where = array('categoria_id'=>$categoria_id, 'usuario_id'=>$user_id);

		return( $this->db->update('interesse', $upd_data, $where) );
	}

	public function insert( $inter_data ) {
		$insert_data = array(
			'usuario_id' => $inter_data['user_id'],
			'raio_busca' => $inter_data['raio'],
			'categoria_id' => $inter_data['categ']
		);

		$this->db->set('data_inclusao', 'NOW()', false);

		if( $this->db->insert('interesse', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

	public function update( $inter_data ) {
		$upd_data = array('raio_busca'=> $inter_data['raio']);
		$where = array(
			'categoria_id'=>$inter_data['cat_id'],
		 	'usuario_id'=>$inter_data['user_id']
		 );

		$this->db->update('interesse', $upd_data, $where);
		return( $this->db->affected_rows()>=0 );
	}

	public function delete( $categoria_id, $user_id ) {
		if( empty($categoria_id) || empty($user_id) ) {
			return FALSE;
		}

		$where = array('categoria_id'=>$categoria_id, 'usuario_id'=>$user_id);
		$this->db->delete('interesse', $where);

		return( $this->db->affected_rows()>0 );
	}
}
