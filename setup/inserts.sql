INSERT INTO `doacoes`.`categoria` (`id`, `nome`, `descricao`) VALUES ('1', 'Roupas', 'N/A');
INSERT INTO `doacoes`.`categoria` (`id`, `nome`, `descricao`) VALUES ('2', 'Móveis', 'N/A');
INSERT INTO `doacoes`.`categoria` (`id`, `nome`, `descricao`) VALUES ('3', 'Brinquedos', 'N/A');

INSERT INTO `doacoes`.`interesse` (`categoria_id`, `usuario_id`, `dt_inclusao`, `fg_ativo`, `raio_busca`) VALUES ('1', '1', NOW(), 'S', '5');
INSERT INTO `doacoes`.`interesse` (`categoria_id`, `usuario_id`, `dt_inclusao`, `fg_ativo`, `raio_busca`) VALUES ('2', '1', NOW(), 'N', '10');
INSERT INTO `doacoes`.`interesse` (`categoria_id`, `usuario_id`, `dt_inclusao`, `fg_ativo`, `raio_busca`) VALUES ('3', '1', NOW(), 'S', '20');