<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Situacao_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$sits =  $this->db->get('situacao')->result();
		return $sits;
	}

	public function get_by_id( $sit_id ) {
		$sits = $this->db->get_where('situacao', array('id'=>$sit_id))->row_array();
		return $sits;
	}
}