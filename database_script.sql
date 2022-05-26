CREATE SCHEMA IF NOT EXISTS `db_filmes` DEFAULT CHARACTER SET utf8 ;
USE `db_filmes` ;

CREATE TABLE IF NOT EXISTS `db_filmes`.`tb_filme` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `categoria` VARCHAR(45) NOT NULL,
  `duracao` INT NOT NULL,
  PRIMARY KEY (`id`));
  
  
-- select * from tb_filme;
  
-- insert into tb_filme Values (null, "Poeira em alto mar", "Terror", 240);