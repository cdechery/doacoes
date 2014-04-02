<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public funcition get_all() {
		$sits =  $this->db->get('categoria')->result();
		return $sits;
	}

	public function get_by_id( $cat_id ) {
		$cats = $this->db->get_where('categoria', array('id'=>$cat_id))->result();
		retrun $cats;
	}

}
