<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {

	public function __construct() 	{
		parent::__construct();
		$this->table = "usuarios";
	}
	
	public function get_data($userid) {
		if(empty($userid) || $userid==0) {
			return false;
		}
		
		return $this->db->get_where('usuario', array('id'=>$userid))->row_array();
	}

	public function check_login($login, $password) {
		$encrypted_pwd = md5($password);

		$ret = $this->db->get_where('usuario', array('login'=>$login, 'password'=>$encrypted_pwd) );

		if( $ret->num_rows() > 0 ) {
			return $ret->row_array();
		} else {
			return FALSE;
		}
	}

	public function email_exists($email, $except_user_id = 0) {
		$query = $this->db->get_where('usuario', array('email'=> $email, 'id !=' => $except_user_id ) );

		return $query->num_rows() > 0;
	}

	public function insert($user_data) {

		$insert_data = array(
			'login' => $user_data['login'],
			'nome' => $user_data['name'],
			'sobrenome' => $user_data['surname'],
			'email' => $user_data['email'],
			'password' => md5( $user_data['password'] )
		);

		if( $user_data['tipo']=="P" ) { // Pessoa
			$insert_data['cpf'] = $user_data['cpf'];
		} else { // == "I"
			$insert_data['cnpj'] = $user_data['cnpj'];
		}

		$this->db->set('data_cadastro', 'NOW()', false);

		if( $this->db->insert('usuario', $insert_data ) ) {
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}

	public function update($user_data, $user_id) {

		if( empty($user_id) || $user_id==0 ) {
			return false;
		}

		$upd_data = array(
			'login' => $user_data['login'],
			'nome' => $user_data['name'],
			'sobrenome' => $user_data['surname'],
			'email' => $user_data['email']
		);

		if( $user_data['tipo']=="P" ) {
			$insert_data['cpf'] = $user_data['cpf'];
		} else { // == "I"
			$insert_data['cnpj'] = $user_data['cnpj'];
		}

		if( !empty($user_data['password']) ) {
			$upd_data['password'] = md5($user_data['password']);
		}
		
		return( $this->db->update('usuario', $upd_data, array('id' => $user_id)) );
	}

	public function update_lat_long($user_id, $lat, $long) {
		if( empty($lat) || empty($long) ) {
			return false;
		}

		$upd_data = array(
			'lat' => $lat,
			'long' => $long
		);

		return( $this->db->update('usuario', $upd_data, array('id' => $user_id)) );
	}

	public function update_password($email, $new_pwd) {
		if( empty($email) || empty($new_pwd) ) {
			return false;
		}

		$upd_data = array( 'password'=>md5($new_pwd) );
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
