<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends MY_Model {
	
	public function __construct() 	{
		parent::__construct();
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

	public function update($upload_data,
		$image_data, $thumb_sizes = array()) {

		$update_data = array(
			'nome_arquivo' => $upload_data['file_name'],
			'descricao'  => $image_data["descricao"]
		);

		if( $this->db->update('imagem', $update_data, array('id'=>$image_data['id'])) ) {
			if( count($thumb_sizes) ) {
				foreach( $thumb_sizes as $size ) {
					create_square_cropped_thumb( $upload_data['full_path'], $size );
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function move_temp_images( $usuario_id, $item_id, $temp_id ) {
		$upd_data = array("item_id"=>$item_id);

		$this->db->set("temp_item_id", "NULL", false);
		$this->db->where("temp_item_id", $temp_id);
		$this->db->limit( $this->params['max_item_imgs'] );
		$this->db->update("imagem", $upd_data);

		$this->db->delete("item_temp", array("id"=>$temp_id));
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
		$ret = file_put_contents($path.'/'.$filename, $img);
		if( $ret>0 ) {
			$thumbs = $this->params['image_settings']['thumb_sizes'];
			foreach( $thumbs as $size ) {
				create_square_cropped_thumb( $path.'/'.$filename, $size );
			}
			return $filename;
		} else {
			return FALSE;
		}
	}

	/* == FUNCOES UTILIZADAS PARA ROTINA DE LIMPEZA */
	public function prepare_tmp_table() {
		$this->db->query('TRUNCATE table tmp_imagem_arquivos');
	}

	public function insert_temp( $arq ) {
		$data = array('nome_arquivo'=>$arq);
		$this->db->insert('tmp_imagem_arquivos', $data);
	}

	public function clear_empty_avatars() {
		$this->db->set('u.avatar', NULL);

		$this->db->where('u.avatar IS NOT NULL');
		$this->db->where('NOT EXISTS '.
			'(SELECT 1 FROM tmp_imagem_arquivos '.
 			'WHERE nome_arquivo = u.avatar)',NULL, FALSE);
		$this->db->update('usuario u');
	}

	public function delete_empty_imgs() {
		$this->db->query('DELETE i FROM `imagem` AS i '.
			'WHERE NOT EXISTS '.
			'(SELECT 1 FROM tmp_imagem_arquivos t '.
 			'WHERE t.nome_arquivo = i.nome_arquivo)');

		$this->db->query('DELETE u FROM `usuario` AS u '.
			'WHERE avatar IS NOT NULL '.
			'AND NOT EXISTS '.
			'(SELECT 1 FROM tmp_imagem_arquivos t '.
 			'WHERE t.nome_arquivo = u.avatar)');
	}

	public function get_old_temp_images() {
		$this->db->select('im.nome_arquivo');
		$this->db->from('item_temp it');
		$this->db->join('imagem im', 'im.temp_item_id = it.id');
		$this->db->where('it.data_criacao < SUBDATE(NOW(),1)');
		return $this->db->get()->result();
	}

	public function get_all_images() {
		$this->db->select('im.nome_arquivo');
		$this->db->from('imagem im');
		$imgs = $this->db->get()->result();

		$this->db->select('u.avatar as nome_arquivo');
		$this->db->from('usuario u');
		$this->db->where('u.avatar IS NOT NULL', NULL, FALSE);
		$avatars = $this->db->get()->result();

		return array_merge( $imgs, $avatars );
	}

	public function get_orphan_images() {
		$this->db->select('nome_arquivo');
		$this->db->from('imagem im');
		$this->db->where('NOT EXISTS '.
			'(SELECT 1 FROM item it '.
		 	'WHERE im.item_id = it.id)', NULL, FALSE);

		return $this->db->get()->result();
	}

	public function delete_orphan_images() {
		$this->db->where('NOT EXISTS '.
			'(SELECT 1 FROM item it '.
		 	'WHERE imagem.item_id = it.id)', NULL, FALSE);
		$this->db->delete('imagem');
	}

	public function purge_old_temp_images() {
		$this->db->query('DELETE im FROM imagem im '.
			'INNER JOIN item_temp it ON im.temp_item_id = it.id '.
			'AND it.data_criacao < SUBDATE(NOW(),1)');
	}

	public function get_unlinked_images() {
		$this->db->select('t.nome_arquivo');
		$this->db->from('tmp_imagem_arquivos t');
		$this->db->where('NOT EXISTS '.
			'(SELECT 1 FROM imagem im'.
			' WHERE im.nome_arquivo = t.nome_arquivo)', NULL, FALSE);
		$this->db->where('NOT EXISTS '.
			'(SELECT 1 FROM usuario u'.
			' WHERE u.avatar = t.nome_arquivo)', NULL, FALSE);
		return $this->db->get()->result();
	}

	/* == (FIM) FUNCOES UTILIZADAS PARA ROTINA DE LIMPEZA */
}
