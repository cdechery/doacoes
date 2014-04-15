<?php
/*
 * Custom Xumb helper to provide session manipulation and login
 * functionality across Xumb.
 * Remember to call this from a Controller or a View before any output
 */
function set_user_session( $user_id ) {
	$CI = & get_instance();
	
	$session = $CI->session->all_userdata();
	if( FALSE!=$session["logged_in"] ) {
		return $session;
	}

	$CI->load->model('usuario_model');
	$user_data = $CI->usuario_model->get_data( $user_id );

	if( FALSE!=$user_data ) {
		$session_data = array('logged_in'=>TRUE,
		  	'user_id' => $user_data['id'],
		  	'name' => $user_data['nome'] );

		$CI->session->set_userdata( $session_data );
		return $session_data; 
	} else {
		return false;
	}
}
