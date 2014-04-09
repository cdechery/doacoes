<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Parametros do site
| -------------------------------------------------------------------
*/

$config['site_params'] = array(
	'validade_interesse_default' => 90, // em dias
	'validade_interesse_inst' => 360, // dias
	'erro_generico' => 'Ocorreu um erro inesperado',
	'raios_busca' => array(1, 5, 10, 25, 50, 100),
	'titulo_site' => 'QuemPrecisa',
	'image_settings' => array(
		'thumb_sizes' => array(80, 150), // size of thumbs to generate
		'allowed_types' => array('jpeg', 'jpg', 'png'),
		'min_image_size' => '200'
	),
	'upload' => array(
		'path' => './files/',
		'max_size' => (8*1024)
	)
);