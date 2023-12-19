CREATE TABLE `sistema_pedidos_swl`.`enderecos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cep` VARCHAR(255) NOT NULL,
  `uf` VARCHAR(2) NULL,
  `cidade` VARCHAR(255) NULL,
  `bairro` VARCHAR(255) NULL,
  `rua` VARCHAR(255) NULL,
  PRIMARY KEY (`id`));
ALTER TABLE `sistema_pedidos_swl`.`enderecos` 
ADD COLUMN `numero` VARCHAR(45) NULL AFTER `rua`;
