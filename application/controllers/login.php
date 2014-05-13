<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('xlang');	
		$this->load->helper('cookie');	
	}

	public function fblogin() {
		$fbuser = null;
		$logoutURL = null;
		$loginURL = null;

        // load the facebook library
        $this->load->library("facebook",$this->params['facebook'] );

        // Get User ID
        $fbuser = $this->facebook->getUser();
        
        if( $fbuser ) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$fbuser = $this->facebook->api('/me');

				$this->load->model('usuario_model');
				$usuario = $this->usuario_model->get_data_email( $fbuser['email'] );

				if( FALSE!=$usuario ) { 
					set_user_session( $usuario['id'] );
					redirect( base_url() );
				} else { //novo
					$this->input->set_cookie('FbRegPending', "1", 259000 );

					$this->load->model('image_model');
					$avatar = @$this->image_model->import_fb_avatar( $fbuser['id'] );
					$fbuser['avatar'] = ( FALSE!=$avatar )?$avatar:"";

					$this->session->set_userdata('fbuserdata', $fbuser );
					$tipo = $this->session->userdata('tipo_cadastro');
					if( $tipo ) {
						redirect( base_url('usuario/new_user/'.$tipo ) );
					} else {
						redirect( base_url('usuario/tipo') );
					}
				}
			} catch (FacebookApiException $e) {
				error_log($e);
				$fbuser = null;
				// TODO tratar erro
			}
        } else {
        	$scope = array('scope' => 'email');
            $loginURL = $this->facebook->getLoginUrl( $scope );
        }
	}

	public function index($msg = "") {
		$head_data = array("min_template"=>"image_view",
			"title"=>$this->params['titulo_site'].": Login");
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
				/*$cookie = array(
				    'name'   => 'DoacoesUserCookie',
				    'value' => $user_data['id'],
				    'expire' => '86500',
				    'secure' => TRUE
				);*/
				$this->input->set_cookie('DoacoesUserCookie', $user_data['id'], 259000 );
			} else {
				delete_cookie('DoacoesUserCookie');
			}

			redirect( base_url() );
		} else {
			$this->index( xlang('dist_login_failed') );
		}
	}
}

