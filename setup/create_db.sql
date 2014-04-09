SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `doacoes` ;
CREATE SCHEMA IF NOT EXISTS `doacoes` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `doacoes` ;

-- -----------------------------------------------------
-- Table `doacoes`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `sobrenome` VARCHAR(40) NULL ,
  `login` VARCHAR(20) NOT NULL ,
  `senha` VARCHAR(32) NOT NULL ,
  `email` VARCHAR(120) NOT NULL ,
  `cpf` BIGINT NULL ,
  `cnpj` BIGINT NULL ,
  `lat` FLOAT(10,6) NULL ,
  `lng` FLOAT(10,6) NULL ,
  `avatar` VARCHAR(100) NULL ,
  `data_cadastro` DATETIME NOT NULL ,
  `data_atualizacao` DATETIME NULL ,
  `tipo` CHAR(1) NOT NULL ,
  `fg_notif_email` CHAR(1) NOT NULL DEFAULT 'S' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) ,
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC) ,
  UNIQUE INDEX `cnpj_UNIQUE` (`cnpj` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doacoes`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`categoria` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  `descricao` VARCHAR(100) NULL ,
  `icone` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doacoes`.`situacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`situacao` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`situacao` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doacoes`.`item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`item` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`item` (
  `id` INT NOT NULL ,
  `descricao` VARCHAR(200) NOT NULL ,
  `status` CHAR(1) NOT NULL ,
  `data_inclusao` DATETIME NOT NULL ,
  `data_doacao` DATETIME NULL ,
  `usuario_id` INT NOT NULL ,
  `categoria_id` INT NOT NULL ,
  `situacao_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_item_doador_idx` (`usuario_id` ASC) ,
  INDEX `fk_item_categoria1_idx` (`categoria_id` ASC) ,
  INDEX `fk_item_situacao1_idx` (`situacao_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doacoes`.`imagem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`imagem` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`imagem` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome_arquivo` VARCHAR(50) NOT NULL ,
  `descricao` VARCHAR(40) NULL ,
  `item_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_imagem_item1_idx` (`item_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `doacoes`.`interesse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `doacoes`.`interesse` ;

CREATE  TABLE IF NOT EXISTS `doacoes`.`interesse` (
  `categoria_id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_id` INT NOT NULL ,
  `dt_inclusao` DATETIME NOT NULL ,
  `fg_ativo` CHAR(1) NOT NULL DEFAULT 'S' ,
  `raio_busca` SMALLINT NOT NULL DEFAULT 5 ,
  PRIMARY KEY (`categoria_id`, `usuario_id`) ,
  INDEX `fk_categoria_has_pessoa_pessoa1_idx` (`usuario_id` ASC) ,
  INDEX `fk_categoria_has_pessoa_categoria1_idx` (`categoria_id` ASC) )
ENGINE = InnoDB;

USE `doacoes` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
