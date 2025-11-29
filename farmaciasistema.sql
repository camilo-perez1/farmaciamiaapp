-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2025 a las 16:38:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `farmaciasistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL,
  `det_cantidad` int(11) NOT NULL,
  `det_vencimiento` date NOT NULL,
  `id__det_lote` int(11) NOT NULL,
  `id__det_prod` int(11) NOT NULL,
  `lote_id_prov` int(255) NOT NULL,
  `id_det_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id_laboratorio` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `laboratorio`
--

INSERT INTO `laboratorio` (`id_laboratorio`, `nombre`, `avatar`) VALUES
(1, 'L.P.S.A', '6928c9dd5d544-hogar.png'),
(2, 'MK', '6928bedd8306b-joji good.jpg'),
(3, 'Ramos', '6928bee95d9bd-educacion.png'),
(9, 'sandiego S.A', 'lab_default.png'),
(10, 'La Sante', 'lab_default.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_lote` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `vencimiento` date NOT NULL,
  `lote_id_prod` int(11) NOT NULL,
  `lote_id_prov` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_lote`, `stock`, `vencimiento`, `lote_id_prod`, `lote_id_prov`) VALUES
(1, 25, '2026-11-27', 6, 1),
(2, 49, '2027-06-27', 5, 2),
(3, 49, '2027-07-28', 2, 2),
(4, 0, '2026-02-28', 4, 2),
(5, 3, '2026-12-28', 7, 1),
(6, 80, '2027-02-28', 1, 1),
(7, 73, '2027-12-28', 4, 1),
(8, 9, '2025-11-06', 62, 1),
(9, 10, '2026-07-28', 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_presentacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_presentacion`, `nombre`) VALUES
(1, 'Tableta'),
(5, ''),
(8, ''),
(12, 'Inyeccion'),
(13, 'Jarabe'),
(14, 'Suspension en polvo'),
(15, 'Capsulas'),
(16, 'Gotas'),
(17, 'Envase'),
(18, 'Paquete'),
(19, 'crema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `concentracion` varchar(255) DEFAULT NULL,
  `adicional` varchar(255) DEFAULT NULL,
  `precio` float NOT NULL,
  `prod_lab` int(11) NOT NULL,
  `prod_tip` int(11) NOT NULL,
  `prod_pre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `concentracion`, `adicional`, `precio`, `prod_lab`, `prod_tip`, `prod_pre`) VALUES
(1, 'Losartan potasico', '50mg', 'Caja envase blister tabletas', 5, 1, 1, 1),
(2, 'ViroGrip am', '-----....', 'Caja * 25', 15, 9, 1, 1),
(4, 'Loratadina', '50 mg', 'caja * 100', 3, 1, 1, 1),
(5, 'Macrovitan', '150 mg', 'caja * 50', 6, 10, 1, 1),
(6, 'Irbesartan', '300 mg', 'caja * 50', 12, 1, 1, 1),
(7, 'Acetaminofen + acido clavulanico Jarabe', '100mg', 'Jarabe', 175, 1, 1, 13),
(58, 'Paracetamol', '500 mg', 'Caja * 10', 15, 1, 1, 1),
(60, 'Ibuwin Ibuprofeno', '800 mg', 'caja * 100', 9, 9, 1, 1),
(62, 'Amoxicilina + acidoClavulanico', '1000 mg', 'Frasco', 12, 2, 1, 1),
(63, 'Amoxicilina', '500 mg', 'Caja x 30', 25, 10, 1, 1),
(64, 'Zepol deportists', '350', '--', 90, 10, 1, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `direccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `telefono`, `correo`, `direccion`) VALUES
(1, 'Paisa', 22648571, 'info@lospaisas.com.ni', 'Costado oeste mercado israel lewites'),
(2, 'Joyce S.A', 8476, 'info@joycedist.com.ni', 'Costado oesteMercado Mayoreo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id_tip_prod` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id_tip_prod`, `nombre`) VALUES
(1, 'Generico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_us`
--

CREATE TABLE `tipo_us` (
  `id_tipo_us` int(11) NOT NULL,
  `nombre_tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_us`
--

INSERT INTO `tipo_us` (`id_tipo_us`, `nombre_tipo`) VALUES
(1, 'Administrador'),
(2, 'Tecnico'),
(3, 'Root');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_us` varchar(45) NOT NULL,
  `apellidos_us` varchar(45) NOT NULL,
  `edad` date NOT NULL,
  `dni_us` varchar(45) NOT NULL,
  `contrasena_us` varchar(45) NOT NULL,
  `telefono_us` varchar(20) DEFAULT NULL,
  `residencia_us` varchar(45) DEFAULT NULL,
  `correo_us` varchar(25) DEFAULT NULL,
  `sexo_us` varchar(25) DEFAULT NULL,
  `adicional_us` varchar(500) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `us_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_us`, `apellidos_us`, `edad`, `dni_us`, `contrasena_us`, `telefono_us`, `residencia_us`, `correo_us`, `sexo_us`, `adicional_us`, `avatar`, `us_tipo`) VALUES
(1, 'Camilo', 'Perez Garcia', '2003-04-29', '290403', '123456', '84767215', 'villalibertad,lomas de guagalupe', 'abc@gmail.com', 'masculino', 'trabajador de farmacia mia 12fgdffdgdfgdfgfgdfgdfg', '6924f425850c8-doctor.png', 3),
(2, 'Michael Joel', 'Ruiz', '2005-08-27', '181818', '123456', '58559927', 'km18 carretera nueva león', 'ruizmichael466@gmail.com', 'masculino', '', '6924e167ba4a8-R.jpeg', 1),
(3, 'Melida', 'Vanegas', '0000-00-00', '040506', '123456', '81314600', '7 sur', 'melida_fransh@gmail.com', 'Femenino', '------------------', '6924e05ca389f-10718738.png', 1),
(4, 'Juan', 'Roman', '2006-02-22', '011200', '111222', '21001222', 'Mi no sabeiro', 'roman24@gmail.com', 'Masculino', 'solo faltas', '6929bf6dd92b6-joji good.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cliente` varchar(45) NOT NULL,
  `dni` int(11) NOT NULL,
  `total` float NOT NULL,
  `vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `fecha`, `cliente`, `dni`, `total`, `vendedor`) VALUES
(1, '2025-11-27 22:10:09', 'camilo', 0, 55, 1),
(2, '2025-11-27 22:16:38', 'Consumidor Final', 0, 30, 1),
(3, '2025-11-27 22:38:19', 'Grethel', 1, 84, 1),
(4, '2025-11-27 22:41:14', 'Michael', 1, 8, 1),
(5, '2025-11-27 22:41:45', 'Pepito', 1, 26, 2),
(6, '2025-11-28 00:10:49', 'Henry', 1, 39, 1),
(7, '2025-11-28 00:26:52', 'hh', 181818, 24, 2),
(8, '2025-11-28 01:05:29', 'Consumidor Final', 181818, 24, 2),
(9, '2025-11-28 01:26:41', 'genesis', 181818, 175, 2),
(10, '2025-11-28 13:30:56', 'Consumidor Final', 290403, 24, 1),
(11, '2025-11-28 14:12:22', 'Michelle', 40506, 12, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_mensual`
--

CREATE TABLE `venta_mensual` (
  `mensual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id_ventaproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  `venta_id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`id_ventaproducto`, `cantidad`, `subtotal`, `producto_id_producto`, `venta_id_venta`) VALUES
(1, 3, 45, 2, 1),
(2, 2, 10, 1, 1),
(3, 2, 30, 2, 2),
(4, 2, 24, 6, 3),
(5, 10, 30, 4, 3),
(6, 5, 30, 5, 3),
(7, 1, 5, 1, 4),
(8, 1, 3, 4, 4),
(9, 1, 15, 2, 5),
(10, 1, 5, 1, 5),
(11, 1, 6, 5, 5),
(12, 5, 15, 4, 6),
(13, 2, 24, 6, 6),
(14, 2, 24, 6, 7),
(15, 1, 3, 4, 8),
(16, 1, 6, 5, 8),
(17, 1, 15, 2, 8),
(18, 1, 175, 7, 9),
(19, 1, 12, 62, 10),
(20, 1, 12, 6, 10),
(21, 4, 12, 4, 11);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_det_venta` (`id_det_venta`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id_laboratorio`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `lote_id_prod` (`lote_id_prod`,`lote_id_prov`),
  ADD KEY `lote_id_prod_2` (`lote_id_prod`,`lote_id_prov`),
  ADD KEY `lote_id_prov` (`lote_id_prov`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `prod_lab` (`prod_lab`,`prod_tip`,`prod_pre`),
  ADD KEY `prod_tip` (`prod_tip`),
  ADD KEY `prod_pre` (`prod_pre`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id_tip_prod`);

--
-- Indices de la tabla `tipo_us`
--
ALTER TABLE `tipo_us`
  ADD PRIMARY KEY (`id_tipo_us`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `us_tipo` (`us_tipo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `vendedor` (`vendedor`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`id_ventaproducto`),
  ADD KEY `producto_id_producto` (`producto_id_producto`),
  ADD KEY `venta_id_venta` (`venta_id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id_laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id_tip_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_us`
--
ALTER TABLE `tipo_us`
  MODIFY `id_tipo_us` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id_ventaproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_det_venta`) REFERENCES `venta` (`id_venta`);

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`lote_id_prod`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`lote_id_prov`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`prod_lab`) REFERENCES `laboratorio` (`id_laboratorio`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`prod_tip`) REFERENCES `tipo_producto` (`id_tip_prod`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`prod_pre`) REFERENCES `presentacion` (`id_presentacion`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`us_tipo`) REFERENCES `tipo_us` (`id_tipo_us`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`producto_id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`venta_id_venta`) REFERENCES `venta` (`id_venta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
