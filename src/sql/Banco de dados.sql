-- MySQL Script generated by MySQL Workbench
-- Tue Aug 20 09:00:32 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Vanguard
-- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS `Vanguard` DEFAULT CHARACTER SET utf8;
SHOW WARNINGS;
USE `Vanguard`;

-- -----------------------------------------------------
-- Table `Vanguard`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`estado` (
  `estado_id` INT NOT NULL AUTO_INCREMENT,
  `nome_estado` VARCHAR(100) NOT NULL,
  `uf` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`estado_id`)
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`cidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`cidades` (
  `cidade_id` INT NOT NULL AUTO_INCREMENT,
  `nome_cidade` VARCHAR(100) NOT NULL,
  `estado_id` INT NOT NULL,
  PRIMARY KEY (`cidade_id`),
  INDEX `fk_Cidades_Estado_idx` (`estado_id` ASC),
  CONSTRAINT `fk_Cidades_Estado`
    FOREIGN KEY (`estado_id`)
    REFERENCES `Vanguard`.`estado` (`estado_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `dt_nasc` DATE NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `cpf` CHAR(11) NOT NULL,
  `foto` LONGBLOB NULL,
  `estado_id` INT NOT NULL,
  `cidade_id` INT NOT NULL,
  `avaliacao` INT(6) NULL,
  `comentario` TEXT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC),
  INDEX `fk_usuario_estado_idx` (`estado_id` ASC),
  INDEX `fk_Usuario_Cidade_idx` (`cidade_id` ASC),
  CONSTRAINT `fk_Usuario_Cidade`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `Vanguard`.`cidades` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_estado`
    FOREIGN KEY (`estado_id`)
    REFERENCES `Vanguard`.`estado` (`estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`produto` (
  `produto_id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `preco` DECIMAL(6,2) NOT NULL,
  `classe` VARCHAR(20) NOT NULL,
  `descricao` TEXT NOT NULL,
  `imagem` LONGBLOB NOT NULL,
  PRIMARY KEY (`produto_id`)
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`carrinho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carrinho_Usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_carrinho_Usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `Vanguard`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`produto_carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`produto_carrinho` (
  `produto_carrinho_id` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `produto_id` INT NOT NULL,
  `carrinho_id` INT NOT NULL,
  PRIMARY KEY (`produto_carrinho_id`),
  INDEX `fk_Produto_carrinho_Produto_idx` (`produto_id` ASC),
  INDEX `fk_Produto_carrinho_Carrinho_idx` (`carrinho_id` ASC),
  CONSTRAINT `fk_Produto_carrinho_Produto`
    FOREIGN KEY (`produto_id`)
    REFERENCES `Vanguard`.`produto` (`produto_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produto_carrinho_Carrinho`
    FOREIGN KEY (`carrinho_id`)
    REFERENCES `Vanguard`.`carrinho` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`funcionario` (
  `usuario_id` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `usuario_estado_id` INT NOT NULL,
  `usuario_cidade_id` INT NOT NULL,
  PRIMARY KEY (`usuario_id`),
  INDEX `fk_funcionario_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_funcionario_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `Vanguard`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_estado`
    FOREIGN KEY (`usuario_estado_id`)
    REFERENCES `Vanguard`.`estado` (`estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_cidade`
    FOREIGN KEY (`usuario_cidade_id`)
    REFERENCES `Vanguard`.`cidades` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`relatorio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`relatorio` (
  `relatorio_id` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NOT NULL,
  `funcionario_usuario_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`relatorio_id`),
  INDEX `fk_relatorio_funcionario_idx` (`funcionario_usuario_id` ASC),
  CONSTRAINT `fk_relatorio_funcionario`
    FOREIGN KEY (`funcionario_usuario_id`)
    REFERENCES `Vanguard`.`funcionario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`solicitacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`solicitacao` (
  `solicitacao_id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(50) NOT NULL,
  `comentario` TEXT NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`solicitacao_id`),
  INDEX `fk_solicitacao_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_solicitacao_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `Vanguard`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
