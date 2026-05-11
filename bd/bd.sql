-- Crear la base de datos si no existe
-- CREATE DATABASE IF NOT EXISTS `web_la_lupe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `web_la_lupe`;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('cliente', 'admin') DEFAULT 'cliente',
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de Platos 
CREATE TABLE IF NOT EXISTS `platos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10, 2) NOT NULL,
  `imagen` VARCHAR(255) DEFAULT 'default_plato.jpg',
  `disponible` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- Tabla de Pedidos 
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT,
  `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `total` DECIMAL(10, 2),
  `estado` ENUM('pendiente', 'preparando', 'completado') DEFAULT 'pendiente',
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE `platos` ADD `categoria` VARCHAR(50) DEFAULT 'General' AFTER `imagen`;

-- Insertar un administrador de prueba (la contraseña es 'admin123')
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`) VALUES 
('Admin La Lupe', 'admin@lalupe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Limpiar platos anteriores
TRUNCATE TABLE `platos`;

-- Insertar platos desde la carta real
INSERT INTO `platos` (`nombre`, `descripcion`, `precio`, `categoria`, `imagen`) VALUES 
-- BAGUETTES
('Baguette La Lupe', 'Carne kebab, lechuga, tomate, cebolla, salsa yogurt y picante (opcional).', 4.00, 'Baguettes', 'img/platos/BL.webp'),
('Baguette Pollo al Mojo Picón', 'Pollo marinado con salsa de mojo picón canario.', 3.00, 'Baguettes', 'img/platos/BMP.webp'),
('Baguette San Bernardo', 'Salchicha, tortilla y queso fundido.', 3.00, 'Baguettes', 'img/platos/BSB.webp'),

-- PERRITOS
('Perrito Lechero', 'Salchicha grande, queso, huevo, mostaza, ketchup y mahonesa.', 3.00, 'Perritos', 'img/platos/PL.webp'),

-- HAMBURGUESAS
('Hamburguesa Especial del Lobato', '2,5 Kg aprox. Queso, doble de carne, 4 huevos fritos, bacon, tomate, lechuga y cebolla.', 14.50, 'Hamburguesas', 'img/platos/HEL.webp'),
('Hamburguesa Gigante de Pollo', '1,5 Kg aprox. Pollo, lechuga, tomate, cebolla y queso.', 9.50, 'Hamburguesas', 'img/platos/HGP.webp'),
('Hamburguesa completa', 'Queso, huevo, lechuga, tomate y cebolla.', 3.00, 'Hamburguesas', 'img/platos/HC.webp'),

-- KEBAB
('Kebab Mixto (Pollo y Ternera)', 'Carne mixta con vegetales y salsa a elegir.', 4.00, 'Kebab', 'img/platos/km.webp'),

-- TARRINAS Y COMBINADOS
('Sultán (Plato Combinado)', 'Patatas, carne, arroz, pique y queso.', 5.00, 'Combinados', 'img/platos/TS.webp'),
('Patatas con Queso Fundido', 'Patatas fritas crujientes cubiertas de queso fundido.', 3.00, 'Patatas', 'img/platos/TQ.webp'),

-- SANDWICHS
('Sandwich Especial de la Casa', 'Pollo, bacon, huevo, jamón, queso, lechuga, tomate, cebolla y mahonesa.', 4.50, 'Sandwichs', 'img/platos/SM.webp');

