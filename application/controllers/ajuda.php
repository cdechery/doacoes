<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajuda extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('head', array('title'=>'Ajuda do Interessa.org'));
		$this->load->view('ajuda');
		$this->load->view('foot');
	}
}