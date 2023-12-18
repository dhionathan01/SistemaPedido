CREATE TABLE `sistema_pedidos_swl`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `endereco_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));

  -- Adicionando índices
ALTER TABLE `sistema_pedidos_swl`.`pedidos`
ADD INDEX `fk_user_id_pedidos_idx` (`user_id` ASC),
ADD INDEX `fk_endereco_id_pedidos_idx` (`endereco_id` ASC);

-- Adicionando chaves estrangeiras
ALTER TABLE `sistema_pedidos_swl`.`pedidos`
ADD CONSTRAINT `fk_user_id_pedidos`
  FOREIGN KEY (`user_id`)
  REFERENCES `sistema_pedidos_swl`.`usuarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_endereco_id_pedidos`
  FOREIGN KEY (`endereco_id`)
  REFERENCES `sistema_pedidos_swl`.`enderecos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
