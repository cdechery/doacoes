<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('xlang');	
		$this->load->helper('cookie');	
	}

	public function index($msg = "") {
		$head_data = array("min_template"=>"image_view", "title"=>$this->params['titulo_site'].": Login");
		$this->load->view('head', $head_data);
		$this->load->view('login', array('msg'=>$msg));
		$this->load->view('foot');
	}

	public function verify() {
		$this->load->model('usuario_model');
		$this->load->helper('url');

		$form_data = $this->input->post(NULL, TRUE);

		$user_data = $this->usuario_model->check_login( $form_data['login'],
			$form_data['password'] );

		if( $user_data ) {
			$session_data = array('logged_in'=>TRUE,
					  		'user_id' => $user_data['id'],
					  		'name' => $user_data['nome'] );

			$this->session->set_userdata( $session_data );


			if( isset($form_data['lembrar']) ) {
				$cookie = array(
				    'name'   => 'DoacoesUserCookie',
				    'value' => $user_data['id'],
				    'expire' => '518400',
				    'secure' => TRUE
				);
				set_cookie( $cookie );
			} else {
				delete_cookie('DoacoesUserCookie');
			}

			redirect( base_url() );
		} else {
			$this->index( xlang('dist_login_failed') );
		}
	}
}

