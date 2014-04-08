<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slonga extends MY_Controller {
	public function index() {
		$this->output->enable_profiler(TRUE);
		$this->load->view("slonga");
		$this->load->model('mapa_model');
		$this->mapa_model->get_all();

	}
}