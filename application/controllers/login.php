<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('xlang');	
		$this->load->helper('cookie');	
	}

	public function _remap( $param ) {
		if( $param=="verificar" ) {
			$this->verificar( $param );
		} else if( $param=="fblogin" ) {
			$this->fblogin( $param );
		} else {
			$this->index( $param );
		}
	}

	public function index( $next="", $msg="" ) {

		if( $next=="index") {
			$next = "";
		}

		$head_data = array("min_template"=>"image_view",
			"title"=>$this->params['titulo_site'].": Login");

		$this->load->view('head', $head_data);
		$this->load->view('login',
			array('next'=>$next, 'msg'=>$msg) );
		$this->load->view('foot');
	}

	public function verificar() {
		$this->load->model('usuario_model');

		$form_data = $this->input->post(NULL, TRUE);

		$user_data = $this->usuario_model->check_login( $form_data['login'],
			$form_data['password'] );

		$next = "";
		if( !empty($form_data['next']) ) {
			$next = base64_decode( $form_data['next'] );
		}

		if( $user_data ) {
			$session_data = set_user_session( $user_data );
			$this->session->set_userdata( $session_data );

			if( isset($form_data['lembrar']) ) {
				$this->input->set_cookie('DoacoesUserCookie',
					$user_data['id'], 259000 );
			} else {
				delete_cookie('DoacoesUserCookie');
			}

			redirect( base_url($next) );
		} else {
			if( !empty($next) ) {
				$next = base64_encode( $next );
			}
			$this->index( $next, xlang('dist_login_failed') );
		}
	}

	public function fblogin() {
		$fbuser = null;
		$logoutURL = null;
		$loginURL = null;

		$this->session->set_userdata('FbLoginPending', "1");

        // load the facebook library
        $this->load->library("facebook",$this->params['facebook'] );

		try {
	        // Get User ID
	        $fbuser = $this->facebook->getUser();
	        
	        if( $fbuser ) {
				// Proceed knowing you have a logged in user who's authenticated.
				$fbuser = $this->facebook->api('/me');

				$this->load->model('usuario_model');
				$usuario = $this->usuario_model->get_data_email( $fbuser['email'] );

				if( FALSE!=$usuario ) {
					set_user_session( $usuario['id'] );
					$this->session->unset_userdata('FbLoginPending');
					redirect( base_url() );
				} else { //novo
					$this->input->set_cookie('FbRegPending', "1", 7200 );
					$this->session->unset_userdata('FbLoginPending');

					$this->load->model('image_model');
					$avatar = @$this->image_model->import_fb_avatar( $fbuser['id'] );
					$fbuser['avatar'] = ( FALSE!=$avatar )?$avatar:"";

					$this->session->set_userdata('fbuserdata', $fbuser );
					$tipo = $this->session->userdata('tipo_cadastro');

					if( $tipo ) {
						redirect( base_url('usuario/novo/'.$tipo ) );
					} else {
						redirect( base_url('usuario/escolhe_tipo' ) );
					}
				}
			} else {
				error_log("Login: não foi possivel conectar com o facebook");
        		$this->index("", "Falha ao conectar com o Facebook, faça aqui o login ou registro.");
			}
		} catch( FacebookApiException $e ) {
			error_log("Login: ".$e);
        	$this->index("", "Falha ao conectar com o Facebook, faça aqui o login ou registro.");
		}
	}
}
