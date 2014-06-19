<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Parametros do site
| -------------------------------------------------------------------
*/

$config['site_params'] = array(
	'validade_interesse_pessoa' => 30, // em dias
	'validade_interesse_inst' => 360, // dias
	'raios_busca' => array(
		'0' => 'Qualquer',
		'5' => '5 km',
		'10' => '10 km',
		'25' => '25 km',
		'50' => '50 km'
		),
	'erro_generico' => 'Ocorreu um erro inesperado',
	'erro_acesso' => 'Acesso negado',
	'titulo_site' => 'QuemPrecisa',
	'image_settings' => array(
		'thumb_sizes' => array(40, 60, 80, 120, 200), // size of thumbs to generate
		'allowed_types' => array('jpeg', 'jpg', 'png'),
		'min_image_size' => '80'
	),
	'max_item_imgs' => 3,
	'upload' => array(
		'path' => './files/',
		'max_size' => (8*1024)
	),
	'facebook' => array('appId' => '649645738441266',
        		'secret' => '8d37a4c4dc26a772b0d9cafffab5169e'),
	'email' => array('charset'=>'ISO-8859-1', 'wordwrap'=>TRUE)
);