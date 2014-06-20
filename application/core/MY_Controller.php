<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $login_data = array('logged_in'=>FALSE);
	protected $params = array();
	protected $is_user_logged_in = FALSE;

	public function __construct() {

		parent::__construct();
		$this->load->helper('xlogin');
		$this->load->helper('cookie');

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
		$this->load->vars( array('login_data' => $this->login_data,
			'params'=>$this->params)  );
		
		$this->output->set_header('Content-type: text/html; charset='.$this->config->item('charset'));
	}

	protected function require_auth() {
		$user = (isset($_SERVER['PHP_AUTH_USER']))?$_SERVER['PHP_AUTH_USER']:"";
		$pass = (isset($_SERVER['PHP_AUTH_PW']))?$_SERVER['PHP_AUTH_PW']:"";

		$basic_auth = $this->params['basic_auth'];

		$validated = ($user==$basic_auth['user'] && $pass==$basic_auth['pass']);

		if ( !$validated ) {
			header('WWW-Authenticate: Basic realm="Interessa.org"');
			header('HTTP/1.0 401 Unauthorized');
			die ("Not authorized");
		}
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

	protected function check_session() {
		$cookie = $this->input->cookie('DoacoesUserCookie');
		$fbReg = $this->input->cookie('FbRegPending');
		$session = $this->session->all_userdata();

		if( $cookie!=FALSE && !isset($session['user_id']) ) {
			$session = set_user_session( $cookie );
		} else if( $fbReg && !isset($session['fbuserdata']) ) {
			deauth_facebook();
			delete_cookie('FbRegPending');
		}

		$login_status = array('user_id' => 0,
			'logged_in'=>FALSE,
			'name'=>'',
			'type'=>'',
			'email'=>'');

		if( isset($session["user_id"]) ) {
			$login_status = array_merge( $login_status, $session );
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

	protected function load_iframe($view_name, $data = array(), $return = FALSE) {
		if( !$return ) {
			$this->load->view('iframe_head', $data, FALSE);
			$this->load->view($view_name, $data, FALSE);
		} else {
			$out = $this->load->view('iframe_head', $data, TRUE);
			$out .= $this->load->view($view_name, $data, TRUE);
			return $out;
		}
	}

	protected function load_ajax($view_name, $data = array(), $return = FALSE) {
		if( !$return ) {
			$this->load->view('ajax_head', $data, FALSE);
			$this->load->view($view_name, $data, FALSE);
		} else {
			$out = $this->load->view('ajax_head', $data, TRUE);
			$out .= $this->load->view($view_name, $data, TRUE);
			return $out;
		}
	}

	protected function load_email($view_name, $data = array()) {
		$out = $this->load->view('email_head', $data, TRUE);
		$out .= $this->load->view($view_name, $data, TRUE);
		$out .= $this->load->view('email_foot', $data, TRUE);
		return $out;
	}

	public function show_access_error($type = "") {
		$this->load->helper('xlang');
		$this->load->helper('xerror');

		if( $type==="" ) {
			show_error( xlang('dist_errsess_expire'),
				403, $this->params['erro_acesso']);
		} else {
			show_error_windowed( xlang('dist_errsess_expire'),
				200, $this->params['erro_acesso'], $type);
		}
	}
}

