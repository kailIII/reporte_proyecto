-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-07-2016 a las 11:59:59
-- Versión del servidor: 5.7.12-0ubuntu1.1
-- Versión de PHP: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `codigo` int(11) NOT NULL,
  `codigo_accion` varchar(11) NOT NULL,
  `accion` text NOT NULL,
  `codigo_proyecto` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_ue`
--

CREATE TABLE `accion_ue` (
  `codigo` int(11) NOT NULL,
  `codigo_accion` int(11) NOT NULL,
  `codigo_ue` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `codigo` int(11) NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`codigo`, `estatus`) VALUES
(3, 'ACTIVO'),
(4, 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_accion`
--

CREATE TABLE `historico_accion` (
  `codigo` int(11) NOT NULL,
  `codigo_accion` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_aue`
--

CREATE TABLE `historico_aue` (
  `codigo` int(11) NOT NULL,
  `accion_ue` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_materiales_servicios`
--

CREATE TABLE `historico_materiales_servicios` (
  `codigo` int(11) NOT NULL,
  `codigo_material_servicio` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_presentacion`
--

CREATE TABLE `historico_presentacion` (
  `codigo` int(11) NOT NULL,
  `codigo_presentacion` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_proyecto`
--

CREATE TABLE `historico_proyecto` (
  `codigo` int(11) NOT NULL,
  `codigo_proyecto` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_reporte`
--

CREATE TABLE `historico_reporte` (
  `codigo` int(11) NOT NULL,
  `codigo_reporte` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_unidad_ejecutora`
--

CREATE TABLE `historico_unidad_ejecutora` (
  `codigo` int(11) NOT NULL,
  `codigo_unidad_ejecutora` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_unidad_medida`
--

CREATE TABLE `historico_unidad_medida` (
  `codigo` int(11) NOT NULL,
  `codigo_unidad_medida` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_usuario`
--

CREATE TABLE `historico_usuario` (
  `codigo` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `codigo` int(11) NOT NULL,
  `iva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales_servicios`
--

CREATE TABLE `materiales_servicios` (
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `precio1` decimal(20,2) NOT NULL DEFAULT '0.00',
  `precio2` decimal(8,2) NOT NULL DEFAULT '0.00',
  `precio3` decimal(8,2) NOT NULL DEFAULT '0.00',
  `precio4` decimal(8,2) NOT NULL DEFAULT '0.00',
  `subpartida` int(11) NOT NULL,
  `unidad_medida` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `codigo` int(11) NOT NULL,
  `nivel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`codigo`, `nivel`) VALUES
(1, 'Adminstrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE `operacion` (
  `codigo` int(11) NOT NULL,
  `operacion` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `codigo` int(11) NOT NULL,
  `partida` varchar(3) NOT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `codigo` int(11) NOT NULL,
  `presentacion` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `codigo` int(11) NOT NULL,
  `codigo_sne` varchar(11) NOT NULL,
  `nombre` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `codigo` int(11) NOT NULL,
  `accion_ue` int(11) NOT NULL,
  `imputacion_presupuestaria` varchar(9) NOT NULL,
  `material_servicio` int(11) NOT NULL,
  `unidad_medida` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL,
  `unidad_presentacion` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `iva` int(11) NOT NULL DEFAULT '0',
  `trim_i` int(11) NOT NULL DEFAULT '0',
  `trim_ii` int(11) NOT NULL DEFAULT '0',
  `trim_iii` int(11) NOT NULL DEFAULT '0',
  `trim_iv` int(11) NOT NULL DEFAULT '0',
  `sub_total` decimal(20,2) NOT NULL,
  `total_iva` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total` decimal(20,2) NOT NULL,
  `presupuesto_utilizado` float(10,2) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subpartida`
--

CREATE TABLE `subpartida` (
  `codigo` int(11) NOT NULL,
  `partida` varchar(3) NOT NULL,
  `ge` varchar(2) NOT NULL,
  `es` varchar(2) NOT NULL,
  `se` varchar(2) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_unidad_medida`
--

CREATE TABLE `tipo_unidad_medida` (
  `codigo` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uel_presupuesto_partida`
--

CREATE TABLE `uel_presupuesto_partida` (
  `codigo` int(11) NOT NULL,
  `accion_ue` int(11) NOT NULL,
  `partida` varchar(3) NOT NULL,
  `presupuesto` float(10,2) NOT NULL,
  `utilizado` float(10,2) NOT NULL DEFAULT '0.00',
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_ejecutora`
--

CREATE TABLE `unidad_ejecutora` (
  `codigo` int(11) NOT NULL,
  `codigo_uel` int(11) NOT NULL,
  `denominacion` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `codigo` int(11) NOT NULL,
  `unidad_medida` varchar(30) NOT NULL,
  `id` varchar(10) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `nivel` int(11) NOT NULL,
  `uel` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`codigo`, `usuario`, `clave`, `nivel`, `uel`, `fecha_creacion`, `estatus`) VALUES
(155, 'admin', 'a01726b559eeeb5fc287bf0098a22f6c', 1, NULL, '2016-07-18 00:00:00', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_proyecto` (`codigo_proyecto`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `accion_ue`
--
ALTER TABLE `accion_ue`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo_accion_2` (`codigo_accion`,`codigo_ue`),
  ADD KEY `codigo_accion` (`codigo_accion`),
  ADD KEY `codigo_ue` (`codigo_ue`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `historico_accion`
--
ALTER TABLE `historico_accion`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_accion` (`codigo_accion`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_aue`
--
ALTER TABLE `historico_aue`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `accion_ue` (`accion_ue`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_materiales_servicios`
--
ALTER TABLE `historico_materiales_servicios`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_material_servicio` (`codigo_material_servicio`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_presentacion`
--
ALTER TABLE `historico_presentacion`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_presentacion` (`codigo_presentacion`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_proyecto`
--
ALTER TABLE `historico_proyecto`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_proyecto` (`codigo_proyecto`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_reporte`
--
ALTER TABLE `historico_reporte`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_reporte` (`codigo_reporte`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_unidad_ejecutora`
--
ALTER TABLE `historico_unidad_ejecutora`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_unidad_ejecutora` (`codigo_unidad_ejecutora`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_unidad_medida`
--
ALTER TABLE `historico_unidad_medida`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_unidad_medida` (`codigo_unidad_medida`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `historico_usuario`
--
ALTER TABLE `historico_usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codigo_usuario` (`codigo_usuario`),
  ADD KEY `operacion` (`operacion`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `materiales_servicios`
--
ALTER TABLE `materiales_servicios`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `subpartida` (`subpartida`),
  ADD KEY `unidad_medida` (`unidad_medida`),
  ADD KEY `presentacion` (`presentacion`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `operacion`
--
ALTER TABLE `operacion`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `partida` (`partida`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo_sne` (`codigo_sne`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo_accion` (`accion_ue`),
  ADD KEY `material_servicio` (`material_servicio`),
  ADD KEY `unidad_medida` (`unidad_medida`),
  ADD KEY `presentacion` (`presentacion`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `subpartida`
--
ALTER TABLE `subpartida`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `partida` (`partida`);

--
-- Indices de la tabla `tipo_unidad_medida`
--
ALTER TABLE `tipo_unidad_medida`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `uel_presupuesto_partida`
--
ALTER TABLE `uel_presupuesto_partida`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `accion_ue` (`accion_ue`),
  ADD KEY `partida` (`partida`);

--
-- Indices de la tabla `unidad_ejecutora`
--
ALTER TABLE `unidad_ejecutora`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo_uel` (`codigo_uel`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `tipo` (`tipo`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `nivel` (`nivel`),
  ADD KEY `uel` (`uel`),
  ADD KEY `estatus` (`estatus`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT de la tabla `accion_ue`
--
ALTER TABLE `accion_ue`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `historico_accion`
--
ALTER TABLE `historico_accion`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `historico_aue`
--
ALTER TABLE `historico_aue`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `historico_materiales_servicios`
--
ALTER TABLE `historico_materiales_servicios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT de la tabla `historico_presentacion`
--
ALTER TABLE `historico_presentacion`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `historico_proyecto`
--
ALTER TABLE `historico_proyecto`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;
--
-- AUTO_INCREMENT de la tabla `historico_reporte`
--
ALTER TABLE `historico_reporte`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15770;
--
-- AUTO_INCREMENT de la tabla `historico_unidad_ejecutora`
--
ALTER TABLE `historico_unidad_ejecutora`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `historico_unidad_medida`
--
ALTER TABLE `historico_unidad_medida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `historico_usuario`
--
ALTER TABLE `historico_usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT de la tabla `iva`
--
ALTER TABLE `iva`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `materiales_servicios`
--
ALTER TABLE `materiales_servicios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28319;
--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `operacion`
--
ALTER TABLE `operacion`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13463;
--
-- AUTO_INCREMENT de la tabla `subpartida`
--
ALTER TABLE `subpartida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;
--
-- AUTO_INCREMENT de la tabla `tipo_unidad_medida`
--
ALTER TABLE `tipo_unidad_medida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `uel_presupuesto_partida`
--
ALTER TABLE `uel_presupuesto_partida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3235;
--
-- AUTO_INCREMENT de la tabla `unidad_ejecutora`
--
ALTER TABLE `unidad_ejecutora`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;
--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD CONSTRAINT `acciones_ibfk_1` FOREIGN KEY (`codigo_proyecto`) REFERENCES `proyecto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acciones_ibfk_2` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `accion_ue`
--
ALTER TABLE `accion_ue`
  ADD CONSTRAINT `accion_ue_ibfk_1` FOREIGN KEY (`codigo_accion`) REFERENCES `acciones` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accion_ue_ibfk_2` FOREIGN KEY (`codigo_ue`) REFERENCES `unidad_ejecutora` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accion_ue_ibfk_3` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_accion`
--
ALTER TABLE `historico_accion`
  ADD CONSTRAINT `historico_accion_ibfk_1` FOREIGN KEY (`codigo_accion`) REFERENCES `acciones` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_accion_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_accion_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_aue`
--
ALTER TABLE `historico_aue`
  ADD CONSTRAINT `historico_aue_ibfk_1` FOREIGN KEY (`accion_ue`) REFERENCES `accion_ue` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_aue_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_aue_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_materiales_servicios`
--
ALTER TABLE `historico_materiales_servicios`
  ADD CONSTRAINT `historico_materiales_servicios_ibfk_1` FOREIGN KEY (`codigo_material_servicio`) REFERENCES `materiales_servicios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_materiales_servicios_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_materiales_servicios_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_presentacion`
--
ALTER TABLE `historico_presentacion`
  ADD CONSTRAINT `historico_presentacion_ibfk_1` FOREIGN KEY (`codigo_presentacion`) REFERENCES `presentacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_presentacion_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_presentacion_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_proyecto`
--
ALTER TABLE `historico_proyecto`
  ADD CONSTRAINT `historico_proyecto_ibfk_1` FOREIGN KEY (`codigo_proyecto`) REFERENCES `proyecto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_proyecto_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_proyecto_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_reporte`
--
ALTER TABLE `historico_reporte`
  ADD CONSTRAINT `historico_reporte_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_reporte_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_reporte_ibfk_4` FOREIGN KEY (`codigo_reporte`) REFERENCES `reporte` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_unidad_ejecutora`
--
ALTER TABLE `historico_unidad_ejecutora`
  ADD CONSTRAINT `historico_unidad_ejecutora_ibfk_1` FOREIGN KEY (`codigo_unidad_ejecutora`) REFERENCES `unidad_ejecutora` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_unidad_ejecutora_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_unidad_ejecutora_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_unidad_medida`
--
ALTER TABLE `historico_unidad_medida`
  ADD CONSTRAINT `historico_unidad_medida_ibfk_1` FOREIGN KEY (`codigo_unidad_medida`) REFERENCES `unidad_medida` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_unidad_medida_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_unidad_medida_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico_usuario`
--
ALTER TABLE `historico_usuario`
  ADD CONSTRAINT `historico_usuario_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_usuario_ibfk_2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_usuario_ibfk_3` FOREIGN KEY (`operacion`) REFERENCES `operacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materiales_servicios`
--
ALTER TABLE `materiales_servicios`
  ADD CONSTRAINT `materiales_servicios_ibfk_1` FOREIGN KEY (`subpartida`) REFERENCES `subpartida` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materiales_servicios_ibfk_4` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD CONSTRAINT `presentacion_ibfk_1` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_2` FOREIGN KEY (`material_servicio`) REFERENCES `materiales_servicios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_3` FOREIGN KEY (`unidad_medida`) REFERENCES `unidad_medida` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_4` FOREIGN KEY (`presentacion`) REFERENCES `presentacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_6` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_7` FOREIGN KEY (`accion_ue`) REFERENCES `accion_ue` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subpartida`
--
ALTER TABLE `subpartida`
  ADD CONSTRAINT `subpartida_ibfk_1` FOREIGN KEY (`partida`) REFERENCES `partida` (`partida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `uel_presupuesto_partida`
--
ALTER TABLE `uel_presupuesto_partida`
  ADD CONSTRAINT `uel_presupuesto_partida_ibfk_2` FOREIGN KEY (`partida`) REFERENCES `partida` (`partida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidad_ejecutora`
--
ALTER TABLE `unidad_ejecutora`
  ADD CONSTRAINT `unidad_ejecutora_ibfk_1` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD CONSTRAINT `unidad_medida_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo_unidad_medida` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unidad_medida_ibfk_2` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`nivel`) REFERENCES `nivel` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`uel`) REFERENCES `unidad_ejecutora` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`estatus`) REFERENCES `estatus` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
