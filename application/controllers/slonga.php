<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slonga extends MY_Controller {
	public function index() {
		$this->load->view("slonga");
	}
}