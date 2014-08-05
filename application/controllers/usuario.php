<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->helper('xlang');
		$this->load->helper('cookie');
	}

	public function logout() {
		$logoutFB = false;
		$logoutURL = "";

        $this->load->library("facebook", $this->params['facebook'] );
        $fbuser = $this->facebook->getUser();

        if( $fbuser ) {
        	$logoutFB = true;
			try {
	        	$fbuser = $this->facebook->api('/me');
	        	//$revoke = $this->facebook->api("/me/permissions", "DELETE");
				$logoutURL = $this->facebook->getLogoutUrl( array('acess_token'=>$fbuser['id'],
					'next'=>base_url()) );
			} catch (FacebookApiException $e) {
				error_log($e);
				$fbuser = null;
			}
        }

		$this->session->sess_destroy();
		delete_cookie('DoacoesUserCookie'); //TODO colocar como param
		delete_cookie('FbRegPending');

		if( $logoutFB ) {
			redirect( $logoutURL );
		} else {
			redirect( base_url() );
		}
	}

	public function map_infowindow($user_id) {
		if( empty($user_id) ) {
			return;
		}

		$this->load->helper('image');

		$udata = $this->usuario_model->get_data($user_id);

		$this->load->model('item_model');
		$items = $this->item_model->get_user_items( $user_id );

		if( $udata['tipo']=='P' ) { 
			$this->load->view('pessoa_infowindow',
				array('udata'=>$udata, 'items'=>$items));
		} else {
			$this->load->model('interesse_model');
			$inters = $this->interesse_model->get( $user_id );
			$this->load->view('inst_infowindow',
				array('udata'=>$udata,
					'interesses'=>$inters,
					'items'=>$items));
		}

	}

	public function pref_email() {
		if( ! $this->is_user_logged_in ) {
			$next = urlencode( base64_encode("usuario/pref_email") );
			redirect( "login/".$next );
		}

		$udata = $this->usuario_model->get_data( $this->login_data['user_id'] );

		$head_data = array("title"=>"Preferências de Email");
		$this->load->view('head', $head_data);
		$this->load->view('pref_email', array('data'=>$udata));
		$this->load->view('foot');
	}

	public function salvar_pref_email() {
		$status = $msg = "";

		if( !$this->is_user_logged_in ) {
			$status = "error";
			$msg = xlang('dist_errsess_expire');
		} else {
			$user_data = $this->input->post(NULL, TRUE);

			$user_data['fg_geral_email'] = isset($user_data['fg_geral_email'])?'S':'N';
			$user_data['fg_notif_int_email'] = isset($user_data['fg_notif_int_email'])?'S':'N';
			$user_data['fg_de_inst_email'] = isset($user_data['fg_de_inst_email'])?'S':'N';
			$user_data['fg_de_pessoa_email'] = isset($user_data['fg_de_pessoa_email'])?'S':'N';

			if( $this->usuario_model->update_pref_email($user_data, 
				$this->login_data['user_id']) ) {

				$status = "OK";
				$msg = "Preferências salvas com sucesso!";
			} else {
				$status = "ERRO";
				$msg = "Ocorreu um erro ao salvar as preferências";
			}
		}

		echo json_encode( array('status'=>$status, 'msg'=>$msg) );
	}

	public function escolhe_tipo($windowed = "") {
		$this->session->unset_userdata('tipo_cadastro');

		if( $windowed==="" ) {
			$head_data = array("title"=>"Novo usuário: Qual tipo?");
			$this->load->view('head', $head_data);
			$this->load->view('tipo_usuario');
			$this->load->view('foot');
		} else {
			$this->load_ajax('tipo_usuario');
		}

	}

	public function novo($tipo = NULL) {
		$this->load->helper('image_helper');
		$this->load->helper('form');
	
		if( $this->is_user_logged_in ) {
			redirect( base_url() );
		}

		if( $tipo==NULL ) {
			redirect( base_url('usuario/escolhe_tipo') );
		}

		$this->session->set_userdata('tipo_cadastro', $tipo);

		if( $tipo!="P" && $tipo!="I" ) {
			show_error('Tipo de Usuário inválido');
		}

		$cust_js = array('js/jquery.plugin.min.js', 
			'js/jquery.datepick.min.js', 'js/jquery.datepick-pt-BR.js');
		$cust_css = array('css/redmond.datepick.css');

		if( $tipo=="I" ) {
			$cust_css = $cust_js = array();
		}
		
		$head_data = array("title"=>"Novo Usuário",
			'cust_js'=>$cust_js,
			'cust_css'=>$cust_css);
		$this->load->view('head', $head_data);

		$data = array('action' => 'insert');
		$fbReg = $this->input->cookie('FbRegPending');
		if( $fbReg ) {
			$fbdata = $this->session->userdata('fbuserdata');
			$data['nome'] = $fbdata['first_name'];
			$data['sobrenome'] = $fbdata['last_name'];
			$data['email'] = $fbdata['email'];
			$data['avatar'] = $fbdata['avatar'];
		}

		$this->load->view('user_form', array('data'=>$data,
				'tipo'=>$tipo) );
		$this->load->view('foot');
	}

	public function insert() {
		$status = "";
		$msg = "";
		$new_id = 0;

		$user_data = $this->input->post(NULL, TRUE);

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('login', 'Login',
			'required|min_length[3]|max_length[20]|is_unique[usuario.login]|xss_clean');
		$this->form_validation->set_rules('email', 'E-mail', 'required|is_unique[usuario.email]|valid_email');
		$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[120]');
		if( $user_data['tipo']=='P' ) { // Pessoa
			$this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required|min_length[3]|max_length[40]');
			$this->form_validation->set_rules('sexo', 'Sexo', 'required');
			$this->form_validation->set_rules('nascimento', 'Nascimento', 'required|callback_bday_check');
		}
		$this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('password_2', 'Confirmação de senha', 'required|matches[password]');
		$this->form_validation->set_rules('lat', 'Localização (no Mapa)', 'required');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {
			$new_id = $this->usuario_model->insert( $user_data );

			if( $new_id > 0 ) {
				$status = "OK";
				$msg = xlang('dist_newuser_ok').'<br>Um email foi enviado confirmando seu cadastro';
				$this->email_boasvindas( $user_data );
			} else {
				$status = "ERROR";
				$msg = xlang('dist_newuser_nok');
			}
		}

		$fbReg = $this->input->cookie('FbRegPending');
		if( $fbReg ) {
			delete_cookie('FbRegPending');
		}

		echo json_encode( array('status'=>$status, 'msg'=>$msg, 'fb'=>$fbReg) );
	}

	public function modificar() {
		if( !$this->is_user_logged_in ) {
			$this->show_access_error();
		}

		$this->load->helper('image_helper');
		$user_data = $this->usuario_model->get_data( $this->login_data['user_id'] );

		$cust_js = array('js/jquery.plugin.min.js', 
			'js/jquery.datepick.min.js', 'js/jquery.datepick-pt-BR.js');
		$cust_css = array('css/redmond.datepick.css');

		if( $user_data['tipo']=="I" ) {
			$cust_css = $cust_js = array();
		}

		$head_data = array("min_template"=>"image_upload",
			"title"=>"Modificar Usuário",
			'cust_css'=>$cust_css, 'cust_js'=>$cust_js);
		$this->load->view('head', $head_data);

		$user_data['action'] = 'update';

		if( !empty($user_data['avatar']) ) {
			$user_data['avatar'] = $user_data['avatar'];
		}

		$this->load->view('user_form', array('data'=>$user_data) );
		$this->load->view('foot');
	}

	public function update() {
		$status = "";
		$msg = "";

		if( !$this->is_user_logged_in ) {
			$status = "error";
			$msg = xlang('dist_errsess_expire');
		} else {
			$user_data = $this->input->post(NULL, TRUE);

			$this->load->helper('form');
			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','</br>');

			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[120]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('password', 'Senha', 'min_length[6]|max_length[8]');
			$this->form_validation->set_rules('password_2', 'Confirmação de senha', 'matches[password]');
			$this->form_validation->set_rules('lat', 'Localização (no Mapa)', 'required');

			if( $user_data['tipo']=='P' ) { // Pessoa
				$this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required|min_length[3]|max_length[40]');
				$this->form_validation->set_rules('sexo', 'Sexo', 'required');
				$this->form_validation->set_rules('nascimento', 'Nascimento', 'required|callback_bday_check');
			}

			if ($this->form_validation->run() == FALSE) {
				$status = "ERROR";
				$msg = validation_errors();
			} else {
				$ret_update = $this->usuario_model->update( $user_data, $this->login_data['user_id'] );

				if( $ret_update ) {
					$status = "OK";
					$msg = xlang('dist_upduser_ok');
				} else {
					$status = "ERROR";
					$msg = xlang('dist_upduser_nok');
				}
			}
		}

		echo json_encode( array('status'=>$status, 'msg'=>$msg) );
	}

	public function reset_password() {
		$action = $this->input->post('action', TRUE);
		$msg = ""; $status = "form";

		if( empty($action) ) {
			$action = "do_reset";
			$msg = xlang('dist_resetpw_email');
		} else {
			$email = $this->input->post('email', TRUE);

			if( !$this->usuario_model->email_exists($email) ) {
				$action = "form";
				$status = "error";
				$msg = xlang('dist_resetpw_email_nok');
			} else {
				// let's generate a new password
				// not a very tricky one, but feel free to improve this
				$pwd_len = "8";
				$letters = "abcdefghijklmnopqrstuvwxyz";
				$numbers = "1234567890";

				$letters_len = strlen($letters);
				$numbers_len = strlen($numbers);

				$new_pwd = "";
				for($i=0; $i<$pwd_len-1; $i++) {
					if( $i%2==0 ) {
						$idx = rand(0,$letters_len-1);
						$new_pwd .= $letters[$idx];
					} else {
						$idx = rand(0,$numbers_len-1);
						$new_pwd .= $numbers[$idx];
					}
				}

				if( $this->usuario_model->update_password($email, $new_pwd) ) {
					$status = "success";
					$msg = xlang('dist_resetpw_email_ok');
					$action = "success";

					$this->send_pwd_email($email, $new_pwd);
				} else {
					$status = "error";
					$msg = xlang('dist_resetpw_email_err');
					$action = "form";
				}
			}
		}

		$view_params = array('action'=>$action, 'msg'=>$msg, 'status'=>$status);
		$this->load_iframe('reset_password', $view_params);
	}

	public function email_check( $email ) {
		if( $this->usuario_model->email_exists($email, $this->login_data['user_id']) ) {
			$this->form_validation->set_message('email_check', xlang('dist_upduser_email') );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function bday_check( $date ) {
		$date_arr  = explode('/', $date);

		if (count($date_arr) == 3) {
		    if (checkdate($date_arr[1], $date_arr[0], $date_arr[2])) {
		        return TRUE;
		    } else {
				$this->form_validation->set_message('bday_check',
					'Data de Nascimento inválida (formato dd/mm/yyyy)' );
		        return FALSE;
		    }
		} else {
			$this->form_validation->set_message('bday_check',
				'Data de Nascimento inválida (formato dd/mm/yyyy)' );
		    return FALSE;
		}
	}

	private function send_pwd_email($email, $password) {
		$this->load->library('email');

		$this->email->from($this->params['email']['from'], $this->params['email']['name']);
		$this->email->to( $email ); 

		$this->email->subject('QuemPrecisa: Sua nova senha');
		$message = 'Vode pediu uma nova senha no nosso site.

					Aqui esta: '.$password.'
					
					Sugerimos que voce acesse agora mesmo, troque sua senha e 
					depois apague esse email. Voce sempre podera usar essa funcao 
					no futuro, se precisar. :)';

		$this->email->message( $message );	

		$this->email->send();		
	}

	public function ajuda_localizacao() {
		$this->load_ajax('ajuda_localizacao');
	}

	public function itens( $user_id = 0 ) {
		if( $user_id==0 ) {
			redirect( base_url() );
		}

		$this->load->helper('image');

		$user_data = $this->usuario_model->get_data( $user_id );

		$this->load->model('item_model');
		$itens = $this->item_model->get_user_items( $user_id );

		$head_data = array('min_template'=>'image_view', "title"=>'Itens do Usuário');
		$this->load->view('head', $head_data);

		$arrItems = array();
		foreach ($itens as $item) {
			$arrItems[ $item->item_id ]['data'] = $item;
			if( !empty($item->nome_arquivo ) ) {
				$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
			} else {
				$arrItems[ $item->item_id ]['imagens'] = array();
			}
		}

		$this->load->view('item_list',
			array('items'=>$arrItems, 'user'=>$user_data) );

		$this->load->view('foot'); // fecha tag section
	}

	public function meus_itens() {
		
		if( !$this->is_user_logged_in ) {
			$this->show_access_error();
		}

		$this->load->helper('image');

		$this->load->model('item_model');
		$itens = $this->item_model->get_user_items( $this->login_data['user_id'] );
		
		if( count($itens)==0 ) {
			redirect( base_url('item/novo') );
		}

		$head_data = array('min_template'=>'image_upload', "title"=>"Meus Itens");
		$this->load->view('head', $head_data);

		$arrItems = array();
		foreach ($itens as $item) {
			$arrItems[ $item->item_id ]['data'] = $item;
			if( !empty($item->nome_arquivo ) ) {
				$arrItems[ $item->item_id ]['imagens'][] = $item->nome_arquivo;
			} else {
				$arrItems[ $item->item_id ]['imagens'] = array();
			}
		}

		$this->load->view('user_item_list', array('items'=>$arrItems) );

		$this->load->view('foot'); // fecha tag section
	}

	public function interesses() {
		
		if( !$this->is_user_logged_in ) {
			$this->show_access_error();
		}

		$this->load->model('interesse_model');
		$result = $this->interesse_model->get( $this->login_data['user_id'] );

		$this->load->model('categoria_model');
		$categorias = $this->categoria_model->get_all();

		$this->load->view('head', array('title'=>'Interesses'));

		$interesses = array();

		$interesses['count'] = count($result);

		foreach ($result as $int) {
			$interesses['data'][$int->id] = $int;
		}

		$this->load->view('interesse_form', array('interesses'=>$interesses, 'categorias'=>$categorias));
		
		$this->load->view('foot');
	}

	private function email_boasvindas($user_data) {
		$this->load->library('email');
		$this->load->helper('email');

		$email_template = "email_boasvindas_pessoa";
		if( $user_data['tipo']=='I') {
			$email_template = "email_boasvindas_inst";
		}

		$corpo = $this->load->view($email_template,
			array('nome'=>$user_data['nome']), TRUE );

		$params = array(
			'to_email'=> $user_data['email'],
			'from_email'=>'noreply@interessa.org',
			'from_name'=> 'Interessa.org',
			'subject'=> 'Bem-vindo ao Interessa',
			'body'=>$corpo
		);

		return send_email( $params );
	}
}
?>
