<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('head', array('title'=>'Contato'));
		$this->load->view('contato');
		$this->load->view('foot');
	}
}