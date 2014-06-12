<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Image Helper - Custom Helper (not a part of CodeIgniter's)
	
	All functions regarding Imagem manipulation goes here
*/

function add_thumb_suffix(&$data, $key, $thumb_size) {
	$data->filename = thumb_filename( $data->filename, $thumb_size );
}

function thumb_filename($filename, $thumbSize) {
	$newFileArray = pathinfo( $filename );
	return $newFileArray['filename']."_t".$thumbSize.".jpg";
	
}

function user_avatar($avatar, $size) {
	$default = 'images/default_avatar_'.$size.'.gif';
	if( empty($avatar) ) {
		return base_url($default);
	} else {
		$CI =& get_instance();
		$params = $CI->config->item('site_params');
		$path = $params['upload']['path'];
		return base_url($path.thumb_filename($avatar, $size));
	}
}

function item_image($img, $size) {
	$default = 'images/default_item_img_'.$size.'.png';
	if( empty($img) ) {
		return base_url($default);
	} else {
		$CI =& get_instance();
		$params = $CI->config->item('site_params');
		$path = $params['upload']['path'];
		return base_url($path.thumb_filename($img, $size));
	}
}

function create_square_cropped_thumb($imgFullPath, $size) {

	// generate thumb
	$type = exif_imagetype( $imgFullPath );
	switch( $type ) {
		case IMAGETYPE_JPEG:
			$img = imagecreatefromjpeg( $imgFullPath );
			break;
		case IMAGETYPE_GIF:
			$img = imagecreatefromgif( $imgFullPath );
			break;
		case IMAGETYPE_PNG:
			$img = imagecreatefrompng( $imgFullPath );
			break;
		default:
			return;
	}

	$width = imagesx( $img );
	$height = imagesy( $img );

	$newH = $newW = 0;
	$limiting_dim = 0;

	/* Calculate the New Image Dimensions */
	if( $height > $width){
		/* Portrait */
		$newW = $size;
		$newH = $height * ( $size / $newW );
		$limiting_dim = $width;
	}else{
		/* Landscape */
		$newH = $size;
		$newW = $width * ( $size / $newH );
		$limiting_dim = $height;
	}

	$tmp_img = imagecreatetruecolor( $size, $size );
	imagecopyresampled( $tmp_img, $img , 0 , 0 , ($width-$limiting_dim )/2 , ( $height-$limiting_dim )/2 , $size , $size , $limiting_dim , $limiting_dim );

	// novo nome
	$newFileArray = pathinfo( $imgFullPath );
	$thmbFileName = $newFileArray['dirname']."/".$newFileArray['filename']."_t".$size.".jpg";

	imagejpeg( $tmp_img, $thmbFileName );

	imagedestroy( $img );
	imagedestroy( $tmp_img );
}

