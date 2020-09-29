-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-09-2020 a las 06:15:15
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
(1, 'Dirección'),
(2, 'Subdirección de Planeación y Vinculación'),
(3, 'Departamento de Comunicación y Difusión'),
(4, 'Planeación, Programación y Presupuestación'),
(5, 'Departamento de Servicios Escolares'),
(6, 'Departamento de Gestión Tecnológica y Vinculación'),
(7, 'Centro de Información'),
(8, 'Departamento de Actividades Extraescolares'),
(9, 'Subdirección Académica'),
(10, 'Departamento de Desarrollo Académico'),
(11, 'Departamento de Ciencias Básicas'),
(12, 'Departamento de Bioquímica'),
(13, 'Departamento de Arquitectura'),
(14, 'Departamento de Sistemas y Computación'),
(15, 'Departamento de Ciencias Económico-Administrativas'),
(16, 'Departamento de Metalmecánica'),
(17, 'División de Posgrado e Investigación'),
(18, 'División de Estudios Profesionales'),
(19, 'Departamento de Gestión Empresarial'),
(20, 'Subdirección de Servicios Administrativos'),
(21, 'Departamento de Recursos Financieros'),
(22, 'Departamento de Recursos Humanos'),
(23, 'Departamento de Recursos Materiales y Servicios'),
(24, 'Centro de Cómputo'),
(25, 'Departamento de Mantenimiento de Equipo');

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
(1, 1, 1, 3, 5, '2020-09-28', 'p5', 'Autorizado'),
(1, 2, 1, 3, 5, '2020-09-28', 'p5', 'Autorizado'),
(1, 3, 14, 5, 3, '2020-09-28', 'p3', 'Autorizado'),
(1, 4, 14, 5, 3, '2020-09-28', 'p3', 'Autorizado'),
(12, 1, 12, 6, 1, '2020-09-28', 'p1', 'Autorizado'),
(12, 2, 12, 6, 1, '2020-09-28', 'p1', 'Autorizado'),
(14, 1, 12, 6, 2, '2020-09-28', 'p2 dd', 'Autorizado'),
(14, 1, 14, 5, 4, '2020-09-28', 'p4', 'Autorizado'),
(14, 2, 12, 6, 2, '2020-09-28', 'p2 dd', 'Autorizado'),
(14, 2, 14, 5, 4, '2020-09-28', 'p4', 'Autorizado');

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
(12, 1, 12, 2, 'p1', 'Autorizado', 6, '2020-09-28', NULL, NULL, 6, '2020-09-28 23:10:32', NULL, NULL),
(12, 2, 14, 2, 'p2 dd', 'Autorizado', 6, '2020-09-28', NULL, NULL, 5, '2020-09-28 23:11:15', NULL, NULL),
(14, 3, 1, 2, 'p3', 'Autorizado', 5, '2020-09-28', NULL, NULL, 3, '2020-09-28 23:11:43', NULL, NULL),
(14, 4, 14, 2, 'p4', 'Autorizado', 5, '2020-09-28', NULL, NULL, 5, '2020-09-28 23:12:13', NULL, NULL),
(1, 5, 1, 2, 'p5', 'Autorizado', 3, '2020-09-28', NULL, NULL, 3, '2020-09-28 23:14:41', NULL, NULL);

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
(3, 'Salvador ', 'Herrera Soriano', 'Salvador ', 'Director', '1234', 1),
(5, 'Juan Miguel', 'Hernández Bravo', 'JM', 'Jefe de departamento de Ingeniería en Sistemas Computacional', '1234', 14),
(6, 'Zaida', 'Villanueva', 'ZV', 'Jefa IBQ', '1234', 12);

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
  ADD PRIMARY KEY (`id_depto_genera`,`id_folio`,`id_depto_sol`),
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
  MODIFY `id_depto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del usuario', AUTO_INCREMENT=7;

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
