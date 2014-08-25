<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Custom html assets helper
 */
	function meinteressa_button($item_id, $custom_css = "") {
		$CI =& get_instance();
		$CI->load->model('item_model');

		$btn_data = $CI->item_model->get_item_button_data( $item_id );

		$strqtd = "";
		$tooltip = "Ninguém se interessou por esse Item ainda";
		$href = "href='".base_url("email/quer_item/".$item_id)."'";
		$class = "itembox fancybox.ajax ".$custom_css;
		$icon = "";

		if( $btn_data['iqtd'] > 0 ) {
			$strqtd = " (".$btn_data['iqtd'].")";

			if( $btn_data['iqtd'] >= $btn_data['uqtd'] ) {
				$tooltip = "Esse Item já recebeu o máximo de mensagens de Interessados";
				$href = "";
				$class = "int_button_disabled";
				$icon = "<i class='fa fa-check-square-o'></i>&nbsp;";
			} else {
				if( $btn_data['iqtd']==1 ) {
					$tooltip = "Uma pessoa interessada apenas enviou mensagem para esse Item";
				} else {
					$tooltip = "".$btn_data['iqtd']." pessoas interessadas já enviaram mensagem para esse Item";
				}
			}
		}

		$ret = "<button id='btnitem".$item_id."' class='".$class."' ".$href." title='".$tooltip."' onClick='$(this).tipsy(\"hide\");'>".$icon."Me interessa!".$strqtd."</button>\n";
		$ret .= "<script type='text/javascript'>$('#btnitem".$item_id."').tipsy( {gravity: 's', opacity: 1 } );</script>";

		return $ret;
	}
 ?>