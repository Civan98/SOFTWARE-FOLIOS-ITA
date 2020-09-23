-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2020 a las 04:10:49
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdgeneradorfolios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_depto` int(11) NOT NULL,
  `nombre_departamentos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_depto`, `nombre_departamentos`) VALUES
(1, 'Ingeniería en Sistemas Computacionales'),
(2, 'Dirección'),
(3, 'Subdirección');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `id_depto_genera` int(11) NOT NULL,
  `id_folio` int(11) NOT NULL,
  `id_depto_sol` int(11) NOT NULL COMMENT 'Departamento que solicita\r\n',
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que pidió el folio',
  `id_solicitud` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL COMMENT 'aprobado, rechazado, solicitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `folios`
--

INSERT INTO `folios` (`id_depto_genera`, `id_folio`, `id_depto_sol`, `id_usuario`, `id_solicitud`, `fecha`, `asunto`, `estado`) VALUES
(1, 1, 1, 3, 1, '2020-09-22', 'Alumnos de nuevo ingreso\r\n', 'Autorizado'),
(2, 2, 1, 3, 2, '2020-09-22', 'Alumnos de residencias', 'Autorizado'),
(2, 3, 2, 4, 3, '2020-09-22', 'Mantenimiento', 'Autorizado'),
(1, 4, 2, 4, 4, '2020-09-22', 'Alumnos para pintar', 'Autorizado'),
(2, 5, 2, 4, 5, '2020-09-22', 'pruebas', 'Cancelado'),
(1, 6, 2, 4, 6, '2020-09-22', 'alumnos para limpiar', 'Autorizado'),
(1, 7, 2, 4, 6, '2020-09-22', 'alumnos para limpiar', 'Autorizado'),
(1, 8, 2, 4, 7, '2020-09-22', 'Limpiar PC', 'Cancelado'),
(1, 9, 2, 4, 7, '2020-09-22', 'Limpiar PC', 'Cancelado'),
(1, 10, 2, 4, 7, '2020-09-22', 'Limpiar PC', 'Cancelado'),
(3, 11, 3, 5, 8, '2020-09-22', 'prueba3', 'Autorizado'),
(3, 12, 3, 5, 9, '2020-09-22', 'prueba de ciclo', 'Autorizado'),
(3, 13, 3, 5, 9, '2020-09-22', 'prueba de ciclo', 'Autorizado'),
(3, 14, 3, 5, 10, '2020-09-22', 'prueba ciclo 22', 'Cancelado'),
(3, 15, 3, 5, 10, '2020-09-22', 'prueba ciclo 22', 'Cancelado'),
(2, 16, 3, 5, 12, '2020-09-22', 'prueba para dirección', 'Autorizado'),
(2, 17, 3, 5, 12, '2020-09-22', 'prueba para dirección', 'Autorizado'),
(1, 18, 3, 5, 11, '2020-09-22', 'prueba para sistemas', 'Cancelado'),
(1, 19, 3, 5, 11, '2020-09-22', 'prueba para sistemas', 'Cancelado'),
(2, 20, 2, 4, 13, '2020-09-22', 'prueba de nuevos campos edición de por usuario editó iván', 'Cancelado'),
(2, 21, 2, 4, 13, '2020-09-22', 'prueba de nuevos campos edición de por usuario editó iván', 'Cancelado'),
(2, 22, 2, 6, 14, '2020-09-22', 'Prueba con iván', 'Autorizado'),
(2, 23, 1, 7, 15, '2020-09-22', '2 servicio social\r\n', 'Cancelado'),
(2, 24, 1, 7, 15, '2020-09-22', '2 servicio social\r\n', 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_depto_sol` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_depto_genera` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date DEFAULT NULL COMMENT 'Fecha en que se creó la solicitud',
  `id_usuario_edit` int(11) DEFAULT NULL COMMENT 'Usuario que edita la solicitud',
  `fecha_edit` datetime DEFAULT NULL COMMENT 'Fecha en que el usuario editó la solicitud',
  `id_usuario_auto` int(11) DEFAULT NULL COMMENT 'id del usuario que editó',
  `fecha_auto` datetime DEFAULT NULL COMMENT 'Fecha cuando el usuario autorizó',
  `id_usuario_cancel` int(11) DEFAULT NULL COMMENT 'id usuario que canceló solicitud',
  `fecha_cancel` datetime DEFAULT NULL COMMENT 'fecha cuando se canceló la solicitud'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_depto_sol`, `id_solicitud`, `id_depto_genera`, `cantidad`, `asunto`, `estado`, `id_usuario`, `fecha`, `id_usuario_edit`, `fecha_edit`, `id_usuario_auto`, `fecha_auto`, `id_usuario_cancel`, `fecha_cancel`) VALUES
(1, 1, 1, 1, 'Alumnos de nuevo ingreso\r\n', 'Autorizado', 3, '2020-09-22', NULL, NULL, 3, '2020-09-22 19:28:37', NULL, NULL),
(1, 2, 2, 1, 'Alumnos de residencias', 'Autorizado', 3, '2020-09-22', NULL, NULL, 4, '2020-09-22 19:32:05', NULL, NULL),
(2, 3, 2, 1, 'Mantenimiento', 'Autorizado', 4, '2020-09-22', NULL, NULL, 4, '2020-09-22 19:33:28', NULL, NULL),
(2, 4, 1, 1, 'Alumnos para pintar', 'Autorizado', 4, '2020-09-22', NULL, NULL, 3, '2020-09-22 19:49:03', NULL, NULL),
(2, 5, 2, 1, 'pruebas', 'Cancelado', 4, '2020-09-22', NULL, NULL, NULL, NULL, 4, '2020-09-22 19:50:26'),
(2, 6, 1, 2, 'alumnos para limpiar', 'Autorizado', 4, '2020-09-22', NULL, NULL, 3, '2020-09-22 19:56:34', NULL, NULL),
(2, 7, 1, 3, 'Limpiar PC', 'Cancelado', 4, '2020-09-22', NULL, NULL, NULL, NULL, 3, '2020-09-22 20:00:11'),
(3, 8, 3, 1, 'prueba3', 'Autorizado', 5, '2020-09-22', 5, '2020-09-22 20:03:51', 5, '2020-09-22 20:04:02', NULL, NULL),
(3, 9, 3, 2, 'prueba de ciclo', 'Autorizado', 5, '2020-09-22', NULL, NULL, 5, '2020-09-22 20:05:11', NULL, NULL),
(3, 10, 3, 2, 'prueba ciclo 22', 'Cancelado', 5, '2020-09-22', NULL, NULL, NULL, NULL, 5, '2020-09-22 20:06:33'),
(3, 11, 1, 2, 'prueba para sistemas', 'Cancelado', 5, '2020-09-22', NULL, NULL, NULL, NULL, 3, '2020-09-22 20:08:50'),
(3, 12, 2, 2, 'prueba para dirección', 'Autorizado', 5, '2020-09-22', NULL, NULL, 4, '2020-09-22 20:07:55', NULL, NULL),
(2, 13, 2, 2, 'prueba de nuevos campos edición de por usuario editó iván', 'Cancelado', 4, '2020-09-22', 6, '2020-09-22 20:49:00', NULL, NULL, 6, '2020-09-22 21:03:56'),
(2, 14, 2, 1, 'Prueba con iván', 'Autorizado', 6, '2020-09-22', NULL, NULL, 6, '2020-09-22 21:05:05', NULL, NULL),
(1, 15, 2, 2, '2 servicio social\r\n', 'Cancelado', 7, '2020-09-22', 3, '2020-09-22 21:07:52', NULL, NULL, 6, '2020-09-22 21:08:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL COMMENT 'identificador del usuario',
  `nombre` varchar(30) NOT NULL COMMENT 'Nombre del usuario',
  `apellidos` varchar(40) NOT NULL COMMENT 'Apellidos del usuario',
  `nombreUsuario` varchar(20) NOT NULL COMMENT 'Usuario',
  `cargo` varchar(60) NOT NULL COMMENT 'Cargo que desempeña el trabajador (jefe, director)',
  `contrasena` varchar(50) NOT NULL,
  `id_depto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `nombreUsuario`, `cargo`, `contrasena`, `id_depto`) VALUES
(3, 'Juan Miguel', 'Hernández Bravo', 'JM', 'Jefe de departamento de Ingeniería en Sistemas Computacional', '1234', 1),
(4, 'Aldo', 'Valdez Solís', 'AVS', 'Director del ITA', '1234', 2),
(5, 'Pedro', 'Sánchez', 'PAS', 'Subdirector del ITA', '1234', 3),
(6, 'Iván', 'Contreras', 'ICC', 'secretaria', '1234', 2),
(7, 'Andres', 'Mayo', 'AMV', 'secretaria', '1234', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_depto`);

--
-- Indices de la tabla `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id_folio`,`id_depto_genera`),
  ADD KEY `fk_usuario_folio` (`id_usuario`),
  ADD KEY `fk_solicitud_folio` (`id_solicitud`),
  ADD KEY `fk_depto_sol_folio` (`id_depto_sol`),
  ADD KEY `fk_depto_genera_folio` (`id_depto_genera`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`,`id_depto_sol`),
  ADD KEY `fk_usuario` (`id_usuario`),
  ADD KEY `fk_id_depto_genera` (`id_depto_genera`),
  ADD KEY `fk_id_depto_sol` (`id_depto_sol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_depto` (`id_depto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_depto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `id_folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del usuario', AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `folios`
--
ALTER TABLE `folios`
  ADD CONSTRAINT `fk_depto_genera_folio` FOREIGN KEY (`id_depto_genera`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_depto_sol_folio` FOREIGN KEY (`id_depto_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_folio` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_folio` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_id_depto_genera` FOREIGN KEY (`id_depto_genera`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_depto_sol` FOREIGN KEY (`id_depto_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_depto` FOREIGN KEY (`id_depto`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
