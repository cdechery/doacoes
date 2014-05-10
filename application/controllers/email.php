<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller { 
	public function __construct() {
		parent::__construct();
	}

	public function quer_item( $item_id = 0) {
		if( !$this->is_user_logged_in || $item_id==0) {
			return;
		}

		$this->load->model('item_model');
		$this->load->model('usuario_model');
		$this->load->helper('image_helper');

		$item = $this->item_model->get( $item_id );
		$from_user = $this->usuario_model->get_data( $this->login_data['user_id'] );
		$to_user = $this->usuario_model->get_data( $item['usuario_id'] );

		$this->load_iframe('email_item',
			array('item'=>$item, 'from_user'=>$from_user,
				'to_user'=>$to_user) );
	}
}