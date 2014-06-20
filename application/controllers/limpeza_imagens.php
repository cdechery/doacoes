<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Limpeza_imagens extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->require_auth();

		log_message('info',
			'Iniciando processo de manutencao/limpeza de imagens');

		$this->load->model('image_model');
		$path = $this->params['upload']['path'];

		if( $handle = opendir($path) ) {
			$this->image_model->prepare_tmp_table();

			log_message('info',
				'Carregando tabela temporaria de imagens');
			while (false !== ($file = readdir($handle))) {
				if( $file!="." && $file!=".." && 
					!strstr($file, "_t") && !strstr($file, "html") ) {

        			$this->image_model->insert_temp( $file );
        		}
    		}
		} else {
			log_message('error',
				'Não foi possível abrir o diretorio de imagens!');
			return;
		}

		log_message('info',
			'Obtendo imagens temporarias com mais de 24h');
		$old_tmp_imgs = $this->image_model->get_old_temp_images();
		log_message('info',
			'Obtendo imagens sem referencia no banco de dados');
		$unlinked_imgs = $this->image_model->get_unlinked_images();

		log_message('info',
			'Obtendo imagens que o item foi apagado');
		$orphan_imgs = $this->image_model->get_orphan_images();

		log_message('info',
			'Apagando arquivos de imagem selecionados');
		$to_delete = array_merge($old_tmp_imgs, $unlinked_imgs, $orphan_imgs);
		foreach ($to_delete as $img) {
			@unlink($path.$img->nome_arquivo);
		}

		log_message('info',
			count($to_delete).' arquivos de imagens foram apagados');

		// TODO limpeza de imagens orfãs (sem item)

		log_message('info',
			'Limpando avatars com arquivos inexistentes');
		$this->image_model->clear_empty_avatars();
		log_message('info',
			'Removendo imagens com arquivos inexistentes');
		$this->image_model->delete_empty_imgs();
		log_message('info',
			'Removendo imagens temporarias');
		$this->image_model->purge_old_temp_images();
	}
}