<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends MY_Model {
	
	public function __construct() 	{
		parent::__construct();
		$this->load->helper('image');
		$this->table = "imagem";
	}
 
	public function insert($upload_data,
		$image_data, $thumb_sizes = array())	{
		
		$insert_data = array(
			'item_id' => (int)$image_data["item_id"],
			'nome_arquivo' => $upload_data['file_name'],
			'descricao'  => $image_data["descricao"]
		);

		if( isset($image_data['temp_id']) ) {
			$insert_data['temp_item_id'] = (int)$image_data['temp_id'];
		}

		if( $this->db->insert('imagem', $insert_data) ) {
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

	public function update() {
		// TODO
	}
	
	public function move_temp_images( $usuario_id, $item_id, $temp_id ) {
		$upd_data = array("item_id"=>$item_id);
		$this->db->set("temp_item_id", "NULL", false);
		$this->db->where("temp_item_id", $temp_id);
		$this->db->limit( $this->params['max_item_imgs'] );
		$this->db->update("imagem", $upd_data);

		$this->db->delete("item_temp", array("id"=>$temp_id));
	}

	public function get_user_item_images( $usuario_id ) {
		$this->db->select('it.id as item_id, im.id, im.nome_arquivo');
		$this->db->from('imagem im');
		$this->db->join('item it', 'it.id = im.item_id');
		$this->db->join('usuario u','u.id = it.usuario_id');
		$this->db->where('u.id', $usuario_id);
		$images = $this->db->get()->result();

		return $images;
	}

	public function get_item_images( $item_id ) {
		$images =  $this->db->get_where('imagem',
			array('item_id'=>$item_id))->result();
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
			return $this->db->get_where('imagem', array('id' => $id))->row();
		}
	}	

	public function import_fb_avatar( $fid ) {
		$img = file_get_contents('https://graph.facebook.com/'.$fid.'/picture?type=large');
		$path = realpath( $this->params['upload']['path'] );
		$filename = uniqid("fb").'.jpg';
		$ret = file_put_contents($path."/".$filename, $img);
		if( $ret>0 ) {
			$thumbs = $this->params['image_settings']['thumb_sizes'];
			foreach( $thumbs as $size ) {
				create_square_cropped_thumb( $path."/".$filename, $size );
			}
			return $filename;
		} else {
			return FALSE;
		}
	}
}