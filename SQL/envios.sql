CREATE TABLE `sistema_pedidos_swl`.`envios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `valor` DECIMAL(10,2) NULL,
  PRIMARY KEY (`id`));
INSERT INTO `sistema_pedidos_swl`.`envios` (`id`, `tipo`, `valor`) VALUES ('1', 'Expresso', '0');
INSERT INTO `sistema_pedidos_swl`.`envios` (`id`, `tipo`, `valor`) VALUES ('2', 'Normal', '0');
