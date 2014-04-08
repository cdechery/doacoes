<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->helper('xlang');
		$this->load->helper('form');
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect( base_url() );
	}

	public function new_user() {
		if( $this->is_user_logged_in ) {
			redirect( base_url() );
		}

		$head_data = array("title"=>$this->params['titulo_site']);
		$this->load->view('head', $head_data);

		$data = array('action' => 'insert');
		$this->load->view('user_form', array('data'=>$data) );
		$this->load->view('foot');
	}

	public function insert() {
		$status = "";
		$msg = "";
		$new_id = 0;

		$user_data = $this->input->post(NULL, TRUE);

		$this->load->helper(array('url'));
		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('','</br>');

		$this->form_validation->set_rules('login', 'Login',
			'required|min_length[5]|max_length[20]|is_unique[usuario.login]|xss_clean');
		$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[120]');
		if( $user_data['tipo']=='P' ) { // Pessoa
			$this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required|min_length[5]|max_length[40]');
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|is_unique[usuario.email]|valid_email');
		$this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('password_2', 'Confirmação de senha', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$status = "ERROR";
			$msg = validation_errors();
		} else {
			$new_id = $this->usuario_model->insert( $user_data );

			if( $new_id > 0 ) {
				$status = "OK";
				$msg = xlang('dist_newuser_ok');
			} else {
				$status = "ERROR";
				$msg = xlang('dist_newuser_nok');
			}
		}

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function modify() {
		if( !$this->is_user_logged_in ) {
			show_error( xlang('dist_errsess_expire') );
		}

		$this->load->helper('image_helper');

		$head_data = array("min_template"=>"image_upload", "title"=>$this->params['titulo_site']);
		$this->load->view('head', $head_data);

		$user_data = $this->usuario_model->get_data( $this->login_data['user_id'] );
		$user_data['action'] = 'update';

		if( !empty($user_data['avatar']) ) {
			$user_data['avatar'] = thumb_filename($user_data['avatar'], 150);
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

			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('','</br>');

			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[5]|max_length[120]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('password', 'Senha', 'min_length[6]|max_length[8]');
			$this->form_validation->set_rules('password_2', 'Confirmação de senha', 'matches[password]');

			if( $user_data['tipo']=='P' ) { // Pessoa
				$this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required|min_length[5]|max_length[40]');
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

		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
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
		$this->load->view('reset_password', $view_params);
	}

	public function email_check( $email ) {
		if( $this->usuario_model->email_exists($email, $this->login_data['user_id']) ) {
			$this->form_validation->set_message('email_check', xlang('dist_upduser_email') );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	private function send_pwd_email($email, $password) {
		$this->load->library('email');

		$this->email->from($this->params['email']['from'], $this->params['email']['name']);
		$this->email->to( $email ); 

		$this->email->subject('Your New Password');
		$message = 'You requested a password reset at the '.$this->params['titulo_site'].' website.

					Here it is: '.$password.'
					
					We suggest you login right now, change your password and 
					then delete this email. You can always use this feature later in
					the future in case you forget it again. ;)';

		$this->email->message( $message );	

		$this->email->send();		
	}

	private function set_location($lat, $long) {
		$status = "";
		$msg = "";

		if( !$this->is_user_logged_in ) {
			$status = "error";
			$msg = xlang('dist_errsess_expire');
		} else {
			$ret = $this->usuario_model->update_lat_long($this->login_data['user_id'], $lat, $long);
			if( $ret ) {
				$status = "OK";
				$msg = "Localização atualizada com sucesso";
			} else {
				$status = "ERRO";
				$msg = "Não foi possível atualizar a localização";
			}
		}
		
		echo json_encode( array('status'=>$status, 'msg'=>utf8_encode($msg)) );
	}

	public function interesses() {
		$this->load->model('interesse_model');

		$interesses = $this->interesse_model->get_by_userid( $this->login_data['user_id'] );

		$this->load->view('lista_interesses');
	}
}
?>
