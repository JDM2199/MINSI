-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2023 a las 03:11:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_ventas`
--
CREATE DATABASE IF NOT EXISTS `gestion_ventas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion_ventas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--
-- Creación: 11-09-2023 a las 13:36:17
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Baja', 'Categoría de productos de baja calidad'),
(2, 'Media', 'Categoría de productos de calidad media'),
(3, 'Alta', 'Categoría de productos de alta calidad'),
(4, 'Premium', 'Categoría de productos premium'),
(5, 'cono_media', 'cono simple'),
(6, 'cono_alta', 'cono premium'),
(7, 'vaso', 'vaso'),
(8, 'paleta_baja', 'paleta de agua'),
(9, 'paleta_media', 'paleta de crema'),
(10, 'paleta_alta', 'paleta con glasiado'),
(11, 'galleta', 'galleta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--
-- Creación: 11-09-2023 a las 13:35:54
--

CREATE TABLE `clientes` (
  `rut` varchar(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion_calle` varchar(255) DEFAULT NULL,
  `direccion_numero` varchar(10) DEFAULT NULL,
  `direccion_comuna` varchar(100) DEFAULT NULL,
  `direccion_ciudad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`rut`, `nombre`, `direccion_calle`, `direccion_numero`, `direccion_comuna`, `direccion_ciudad`) VALUES
('20', 'dsvsd', 'vssv', '555', 'svdsv', 'sdvsv'),
('52', 'asc', '456', '565', 'sca', 'saca'),
('66', 'sagc', 'scajn', '414', 'scs', 'dvvs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_ventas`
--
-- Creación: 13-09-2023 a las 00:39:08
--

CREATE TABLE `detalles_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `monto_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_ventas`
--

INSERT INTO `detalles_ventas` (`id`, `id_venta`, `nombre_producto`, `cantidad`, `monto_total`) VALUES
(83, 14, 'Pincha Globo', 5, 13.50),
(84, 14, 'pol', 10, 585.00),
(85, 21, 'Pincha Globo', 12, 27.00),
(86, 21, 'Vasito', 35, 78.75),
(87, 25, 'Corneto', 54, 205.20),
(88, 25, 'Fiesta', 65, 296.40),
(89, 54, 'Corneto', 20, 90.00),
(90, 74, 'Pincha Globo', 200, 360.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 13-09-2023 a las 00:37:10
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio_actual` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `rut_proveedor` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio_actual`, `stock`, `id_categoria`, `rut_proveedor`) VALUES
(5, 'Vasito', 3.00, 1000, 7, '101'),
(6, 'Pincha Globo', 3.00, 1000, 9, '502'),
(7, 'Bombon', 2.00, 1000, 5, '521'),
(8, 'Corneto', 5.00, 1000, 6, '502'),
(9, 'Fiesta', 6.00, 1000, 10, '101'),
(20, 'pol', 65.00, 32, 6, '11'),
(21, 'loo', 65.00, 2555, 6, '502'),
(23, 'sdsd', 3.00, 2555, 4, '12'),
(24, 'qe', 5.00, 4, 3, '120');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--
-- Creación: 11-09-2023 a las 13:35:41
--

CREATE TABLE `proveedores` (
  `rut` varchar(15) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion_calle` varchar(255) DEFAULT NULL,
  `direccion_numero` varchar(10) DEFAULT NULL,
  `direccion_comuna` varchar(100) DEFAULT NULL,
  `direccion_ciudad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `pagina_web` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`rut`, `nombre`, `direccion_calle`, `direccion_numero`, `direccion_comuna`, `direccion_ciudad`, `telefono`, `pagina_web`) VALUES
('101', 'lou', 'kuh', '594', 'liu', 'huyt', '611526', 'we'),
('11', 'loo', 'daf', '34', 'adas', 'ju', '888', 'www'),
('12', 'luu', 'ew ', '33', 'dan', 'dani', '34', 'wdw'),
('120', 'uu', 'll', '451', 'loi', 'pio', '955', 'wwwer'),
('1205', 'loo', 'rr', '00', 'adas', 'ju', '1651651', 'www'),
('45', 'luoo', 'poo', '121', 'koi', 'muj', '3232', 'wwwwpoo'),
('502', 'Alvaro', 'Olimpo', '451', 'Lomas Zamora', 'Buenos Aires', '456555', 'www.proveedorArgsf.com'),
('521', 'Luis', 'Helada', '561', 'Olimpo', 'La Plata', '1651651', 'www.proveedorOlimp.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos_clientes`
--
-- Creación: 11-09-2023 a las 13:36:05
--

CREATE TABLE `telefonos_clientes` (
  `id` int(11) NOT NULL,
  `rut_cliente` varchar(15) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonos_clientes`
--

INSERT INTO `telefonos_clientes` (`id`, `rut_cliente`, `telefono`) VALUES
(26, '52', '6561'),
(27, '66', '456'),
(28, '20', '565126');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--
-- Creación: 22-09-2023 a las 22:50:01
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `rut_cliente` varchar(15) DEFAULT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `rut_cliente`, `monto_final`, `descuento`) VALUES
(14, '2023-09-07', '20', 588.50, 10.00),
(21, '2023-09-07', '52', 80.75, 25.00),
(25, '2023-09-12', '66', 477.60, 24.00),
(54, '2023-09-11', '66', 80.00, 10.00),
(74, '2023-09-14', '66', 320.00, 40.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`rut`);

--
-- Indices de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `nombre_producto` (`nombre_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `rut_proveedor` (`rut_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`rut`);

--
-- Indices de la tabla `telefonos_clientes`
--
ALTER TABLE `telefonos_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rut_cliente` (`rut_cliente`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rut_cliente` (`rut_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `telefonos_clientes`
--
ALTER TABLE `telefonos_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1229;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD CONSTRAINT `detalles_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalles_ventas_ibfk_2` FOREIGN KEY (`nombre_producto`) REFERENCES `productos` (`nombre`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`rut_proveedor`) REFERENCES `proveedores` (`rut`);

--
-- Filtros para la tabla `telefonos_clientes`
--
ALTER TABLE `telefonos_clientes`
  ADD CONSTRAINT `telefonos_clientes_ibfk_1` FOREIGN KEY (`rut_cliente`) REFERENCES `clientes` (`rut`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`rut_cliente`) REFERENCES `clientes` (`rut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
