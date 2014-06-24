<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Email Helper - Custom Helper
*/
	function send_email( $params ) {

		$CI =& get_instance();
		extract( $params );

		if( empty($from_email) || empty($to_email) ||
			empty($subject) || empty($body) ) {

			$caller = $CI->router->method;
			log_message('error', 'Tentativa de enviar email com parametros invalidos ('.$caller.')');

			return FALSE;
		}

		$CI->email->clear();

		if( isset($from_name) ) {
			$CI->email->from( $from_email, $from_name );
		} else {
			$CI->email->from( $from_email );
		}

		if( isset($reply_to) ) {
			$CI->email->reply_to( $reply_to );
		}

		if( isset($to_name) ) {
			$CI->email->to( $to_email, $to_name );
		} else {
			$CI->email->to( $to_email );
		}

		$CI->email->subject( $subject );

		$emailmsg = $CI->load->view('email_head', TRUE);
		$emailmsg .= $body;
		$emailmsg .= $CI->load->view('email_foot',
			 array('email_para'=>$to_email), TRUE);

		$CI->email->message( $emailmsg );

		return $CI->email->send();
	}
?>