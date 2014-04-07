<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends MY_Model {
	
	public function __construct() 	{
		parent::__construct();
		$this->load->helper('image');
		$this->table = "imagem";
	}
 
	public function insert($upload_data, $image_data, $thumb_sizes = array())	{
		
		$insert_data = array(
			'item_id' => (int)$image_data["item_id"],
			'nome_arquivo'     => $upload_data['filename'],
			'descricao'  => $image_data["desc"]
		);
		
		if( $this->db->insert('image', $insert_data) ) {
			if( count($thumb_sizes) ) {
				foreach( $thumb_sizes as $size ) {
					create_square_cropped_thumb( $upload_data['full_path'], $size );
				}
			}
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function get_item_images( $item_id ) {
		$images =  $this->db->get_where('imagem', array('item_id'=>$marker_id))->result();
		return $images;
	}
	
	public function delete($id = 0) {
		if( $id === 0 ) {
			return false;
		} else {
			$thumb_sizes = $this->params['image_settings']['thumb_sizes'];
			$path = $this->params['upload']['path'];
			
			$image = $this->get_by_id( $id );
			$filename = "";
			if( !$image ) {
				return false;
			} else {
				$filename = $image->filename;
			}
			
			$this->db->delete('imagem', array('id' => $id) );
			
			if( $this->db->affected_rows() ) {
				@unlink( $path . $filename );
				foreach( $thumb_sizes as $size ) {
					@unlink( $path . thumb_filename($filename, $size ) ); 
				}
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function get_by_id($id = 0) {
		if( $id === 0 ) {
			return false;
		} else {
			return $this->db->get_where('image', array('id' => $id))->row();
		}
	}	
}