SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Vanguard
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Vanguard` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `Vanguard` ;

-- -----------------------------------------------------
-- Table `Vanguard`.`Estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Estado` (
  `estado_id` INT NOT NULL AUTO_INCREMENT,
  `nome_estado` VARCHAR(100) NOT NULL,
  `uf` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`estado_id`),
  UNIQUE INDEX `nome_estado_UNIQUE` (`nome_estado` ASC))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Cidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Cidades` (
  `cidade_id` INT NOT NULL AUTO_INCREMENT,
  `nome_cidade` VARCHAR(100) NOT NULL,
  `estado_id` INT NOT NULL,
  PRIMARY KEY (`cidade_id`),
  INDEX `fk_Cidades_Estado_idx` (`estado_id` ASC),
  CONSTRAINT `fk_cidades_estado`
    FOREIGN KEY (`Estado_id`)
    REFERENCES `Vanguard`.`Estado` (`estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `dt_nasc` DATE NOT NULL,
  `cidade_id` INT NOT NULL,
  `estado_id` INT NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  INDEX `fk_usuario_cidades1_idx` (`cidade_id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  CONSTRAINT `fk_usuario_cidades1`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `Vanguard`.`Cidades` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Vanguard`.`Produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Produto` (
  `produto_id` INT NOT NULL AUTO_INCREMENT,
  `nome_produto` VARCHAR(100) NOT NULL,
  `preco` DECIMAL(6,2) NOT NULL,
  `classe` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`produto_id`)
) ENGINE=InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`carrinho` (
  `carrinho_id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`carrinho_id`),
  INDEX `fk_carrinho_Usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_carrinho_Usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `Vanguard`.`Usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
