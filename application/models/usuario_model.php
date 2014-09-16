<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends MY_Model {

	public function __construct() 	{
		parent::__construct();
		$this->table = "usuario";
	}
	
	public function get_data( $id ) {
		if(empty($id) || $id==0) {
			return false;
		}
		
		return $this->db->get_where('usuario',
			array('id'=>$id))->row_array();
	}

	public function get_data_email( $email ) {
		return $this->db->get_where('usuario',
			array('email'=>$email))->row_array();
	}

	public function check_login($login, $password) {
		$encrypted_pwd = md5($password);

		$ret = $this->db->get_where('usuario', array('login'=>$login,
			'senha'=>$encrypted_pwd) );

		if( $ret->num_rows() > 0 ) {
			return $ret->row_array();
		} else {
			return FALSE;
		}
	}

	public function email_exists($email, $except_user_id = 0) {
		$query = $this->db->get_where('usuario',
			array('email'=> $email,
				'id !=' => $except_user_id ) );

		return $query->num_rows() > 0;
	}

	public function insert($user_data) {

		$insert_data = array(
			'login' => $user_data['login'],
			'nome' => $user_data['nome'],
			'email' => $user_data['email'],
			'senha' => md5( $user_data['password'] ),
			'tipo' => $user_data['tipo'],
			'lat' => $user_data['lat'],
			'lng' => $user_data['lng']
		);

		if( $user_data['tipo']=="P" ) { // Pessoa
			$insert_data['sobrenome'] = $user_data['sobrenome'];

			$dt_parts = explode('/', $user_data['nascimento'] );
			$data = $dt_parts[2]."-".$dt_parts[1]."-".$dt_parts[0];
			$insert_data['data_nascimento'] = $data;

			$insert_data['sexo'] = $user_data['sexo'];
		}

		if( !empty($user_data['avatar']) ) {
			$insert_data['avatar'] = $user_data['avatar'];
		}

		$this->db->set('data_cadastro', 'NOW()', false);

		if( $this->db->insert('usuario', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

	public function update($user_data, $id) {

		if( empty($id) || $id==0 ) {
			return false;
		}

		$upd_data = array(
			'nome' => $user_data['nome'],
			'email' => $user_data['email'],
			'lat' => $user_data['lat'],
			'lng' => $user_data['lng']
		);

		if( $user_data['tipo']=="P" ) { // Pessoa
			$dt_parts = explode('/', $user_data['nascimento'] );
			$data = $dt_parts[2]."-".$dt_parts[1]."-".$dt_parts[0];
			$upd_data['sobrenome'] = $user_data['sobrenome'];

			$upd_data['data_nascimento'] = $data;
			$upd_data['sexo'] = $user_data['sexo'];
		}

		if( !empty($user_data['password']) ) {
			$upd_data['senha'] = md5($user_data['password']);
		}
		
		$this->db->set('data_atualizacao', 'NOW()', false);

		return( $this->db->update('usuario', 
			$upd_data, array('id' => $id) ) );
	}

	public function update_pref_email($pref_data, $user_id) {
		$upd_data = array(
			'fg_geral_email' => $pref_data['fg_geral_email'],
			'fg_notif_int_email' => $pref_data['fg_notif_int_email'],
			'fg_de_inst_email' => $pref_data['fg_de_inst_email'],
			'fg_de_pessoa_email' => $pref_data['fg_de_pessoa_email'],
			'lim_emails_item' => $pref_data['lim_emails_item'],
		);

		return( $this->db->update('usuario', 
			$upd_data, array('id' => $user_id) ) );
	}

	public function get_newsletter( $filter_emails = NULL ) {
		$this->db->select('nome, email');
		$this->db->where('fg_geral_email = \'S\'');

		if( $filter_emails ) {
			$this->db->where_in('email', $filter_emails);
		}

		$r = $this->db->get('usuario')->result();

		return $r;
	}

	public function exists_lat_long($lat, $long, $id = 0) {
		if( empty($lat) || empty($long) ) {
			return false;
		}

		$this->db->select('id');
		$this->db->where('round(lat,5) = round('.$lat.', 5)',
			NULL, FALSE);
		$this->db->where('round(lng,5) = round('.$long.', 5)',
			NULL, FALSE);

		if( $id != 0 ) {
			$this->db->where('id !=', $id);
		}

		$ret = $this->db->get('usuario')->result();

		return count( $ret ) > 0;
	}

	public function update_password($email, $new_pwd) {
		if( empty($email) || empty($new_pwd) ) {
			return false;
		}

		$upd_data = array( 'senha'=>md5($new_pwd) );
		return( $this->db->update('usuario', $upd_data, array('email' => $email)) );
	}

	public function update_avatar($img_data, $user_id, $thumb_sizes = array() ) {
		if( empty($img_data) || $user_id==0 ) {
			return false;
		}

		$upd_data = array(
			'avatar' => $img_data['file_name']
		);

		$this->load->helper('image_helper');
		if( count($thumb_sizes) ) {
			foreach( $thumb_sizes as $size ) {
				create_square_cropped_thumb( $img_data['full_path'], $size );
			}
		}

		return( $this->db->update('usuario', $upd_data, array('id' => $user_id)) );
	}
}
?>
