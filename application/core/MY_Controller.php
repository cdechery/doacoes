<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $login_data = array();
	protected $params = array();
	protected $is_user_logged_in = FALSE;
	
	public function __construct() {

		parent::__construct();
		$this->load->helper('xlogin');

		// This header code was necessary due to some issues with AJAX calls. It doesn't work with CI's header
		// only with PHP's native header() function for some reason
		$allowed_urls = $this->allowed_urls();
		foreach( $allowed_urls as $url ) {
			header('Access-Control-Allow-Origin: '.$url);
		}
		
		// params settings available to all Controllers
		$this->params = $this->config->item('site_params');
		
		$this->login_data = $this->check_session();
		$this->is_user_logged_in = $this->login_data["logged_in"];

		// load 'login_status' to the views
		$this->load->vars( array('login_data' => $this->login_data, 'params'=>$this->params)  );
		
		$this->output->set_header('Content-type: text/html; charset='.$this->config->item('charset'));
	}
	
	protected function check_owner( $model, $id ) {
		$this->load->helper('xlang');
		if( !$this->is_user_logged_in ) {
			return xlang('dist_errsess_expire');
		}
		
		if( $model->is_owner( $this->login_data['user_id'], $id ) ) {
			return NULL;
		} else {
			return xlang('dist_errperm');
		}
	}

	private function check_session() {
		$cookie = $this->input->cookie('DoacoesUserCookie');
		$session = $this->session->all_userdata();

		if( $cookie!=FALSE && !isset($session['user_id']) ) {
			$session = set_user_session( $cookie );
		}

		$login_status = array('user_id' => 0, 'logged_in'=>FALSE);
		if( isset($session["user_id"]) ) {
			$login_status = array("logged_in"=>TRUE,
				"user_id" => $session["user_id"],
				"name" => $session["name"] );
		}
		
		return $login_status;
	}
	
	private function allowed_urls() {
		$alurls = array( rtrim( base_url(), '/') );
		$custom_urls = $this->config->item('allowed_urls');
		if( !empty($custom_urls) ) {
			$alurls = array_merge( $alurls, $this->config->item('allowed_urls') );
		}
		return $alurls;
	}
}