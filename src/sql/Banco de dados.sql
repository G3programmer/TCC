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
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_estado` VARCHAR(100) NOT NULL,
  `uf` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_estado_UNIQUE` (`nome_estado` ASC))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Cidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Cidades` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_cidade` VARCHAR(100) NOT NULL,
  `Estado_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Cidades_Estado_idx` (`Estado_id` ASC),
  CONSTRAINT `fk_Cidades_Estado`
    FOREIGN KEY (`Estado_id`)
    REFERENCES `Vanguard`.`Estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(50) NOT NULL,
  `dt_nasc` DATE NOT NULL,
  `cep` INT(8) NOT NULL,
  `bairro` VARCHAR(100) NOT NULL,
  `rua` VARCHAR(100) NOT NULL,
  `num_predial` INT(5) NOT NULL,
  `Cidades_id` INT NOT NULL,
  `Cidades_Estado_id` INT NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cep_UNIQUE` (`cep` ASC),
  INDEX `fk_Usuario_Cidades1_idx` (`Cidades_id` ASC, `Cidades_Estado_id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  CONSTRAINT `fk_Usuario_Cidades1`
    FOREIGN KEY (`Cidades_id`, `Cidades_Estado_id`)
    REFERENCES `Vanguard`.`Cidades` (`id`, `Estado_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `preco` DECIMAL(6,2) NOT NULL,
  `cor` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`carrinho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carrinho_Usuario1_idx` (`Usuario_id` ASC),
  CONSTRAINT `fk_carrinho_Usuario1`
    FOREIGN KEY (`Usuario_id`)
    REFERENCES `Vanguard`.`Usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Vanguard`.`Produto_carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vanguard`.`Produto_carrinho` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `Produto_id` INT NOT NULL,
  `carrinho_id` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_Produto_carrinho_Produto1_idx` (`Produto_id` ASC),
  INDEX `fk_Produto_carrinho_carrinho1_idx` (`carrinho_id` ASC),
  CONSTRAINT `fk_Produto_carrinho_Produto1`
    FOREIGN KEY (`Produto_id`)
    REFERENCES `Vanguard`.`Produto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produto_carrinho_carrinho1`
    FOREIGN KEY (`carrinho_id`)
    REFERENCES `Vanguard`.`carrinho` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
