<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$sits =  $this->db->get('categoria')->result();
		return $sits;
	}

	public function get_by_id( $cat_id ) {
		$cats = $this->db->get_where('categoria', array('id'=>$cat_id))->result();
		return $cats;
	}

}
