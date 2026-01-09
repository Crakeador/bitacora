-- Historial de ingresos por usuario
CREATE TABLE IF NOT EXISTS `user_login` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `ts` DATETIME NOT NULL,
  `ip` VARCHAR(64) NULL,
  `ua` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_user_login_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;