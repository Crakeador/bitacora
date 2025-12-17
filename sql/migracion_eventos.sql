-- Script de migración para agregar campos a la tabla eventos
-- Ejecutar este script en la base de datos para agregar los nuevos campos

-- Verificar si la tabla eventos existe, si no existe crearla
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `descripcion` text,
  `backgroundColor` varchar(7) DEFAULT '#3c8dbc',
  `borderColor` varchar(7) DEFAULT '#3c8dbc',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Agregar campo user_id si no existe
ALTER TABLE `eventos` 
ADD COLUMN IF NOT EXISTS `user_id` int(11) DEFAULT NULL AFTER `id`,
ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);

-- Agregar campo persona_contacto si no existe
ALTER TABLE `eventos` 
ADD COLUMN IF NOT EXISTS `persona_contacto` varchar(255) DEFAULT NULL AFTER `descripcion`;

-- Agregar campo lugar si no existe
ALTER TABLE `eventos` 
ADD COLUMN IF NOT EXISTS `lugar` varchar(255) DEFAULT NULL AFTER `persona_contacto`;

-- Agregar índice para búsquedas por usuario
ALTER TABLE `eventos` 
ADD INDEX IF NOT EXISTS `idx_user_active` (`user_id`, `is_active`);

-- Comentarios de los campos
ALTER TABLE `eventos` 
MODIFY COLUMN `user_id` int(11) DEFAULT NULL COMMENT 'ID del usuario que registra el evento',
MODIFY COLUMN `persona_contacto` varchar(255) DEFAULT NULL COMMENT 'Nombre de la persona de contacto',
MODIFY COLUMN `lugar` varchar(255) DEFAULT NULL COMMENT 'Lugar o dirección de la reunión';

