-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2020 a las 04:34:57
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
(1, 'Ingeniería en sistemas computacionales'),
(2, 'Dirección'),
(3, 'Subdirección');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `id_folio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_depto_sol` int(11) NOT NULL COMMENT 'Departamento que solicita\r\n',
  `id_depto_a_sol` int(11) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL COMMENT 'aprobado, rechazado, solicitado',
  `id_usuario` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_depto_sol` int(11) NOT NULL,
  `id_depto_a_sol` int(11) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `cantidad`, `id_depto_sol`, `id_depto_a_sol`, `asunto`, `estado`, `fecha`, `id_usuario`) VALUES
(1, 1, 1, 1, 'viaje a Francia ', 'Autorizado', '2020-09-24', 1),
(2, 3, 1, 2, 'viaje a Veracruz', 'Cancelado', '2020-09-28', 1),
(3, 5, 1, 2, 'Viaje a Tampico', 'Cancelado', '2020-09-24', 1),
(4, 2, 1, 2, 'Concurso', 'Cancelado', '2020-10-01', 1),
(5, 3, 1, 2, 'necesito folios', 'Cancelado', '2020-10-01', 1),
(6, 1, 1, 2, 'Viaje a Tamaulipas', 'Cancelado', '2020-09-24', 1),
(7, 1, 1, 3, 'dsfdsf', 'Cancelado', '2020-09-28', 1),
(8, 3, 1, 2, '1', 'Cancelado', '2020-09-28', 1),
(10, 2, 1, 1, 'Viaje escolar', 'Cancelado', '2020-09-24', 1);

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
(1, 'JUAN MIGUEL', 'HERNÁNDEZ BRAVO', 'JM', 'JEFE DEL DEPARTAMENTO DE SISTEMAS Y COMPUTACIÓN', '1234', 1);

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
  ADD PRIMARY KEY (`id_folio`),
  ADD KEY `fk_usuario_folio` (`id_usuario`),
  ADD KEY `fk_solicitud_folio` (`id_solicitud`),
  ADD KEY `fk_depto_a_sol_folio` (`id_depto_a_sol`),
  ADD KEY `fk_depto_sol_folio` (`id_depto_sol`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fk_usuario` (`id_usuario`),
  ADD KEY `fk_depto_sol` (`id_depto_sol`),
  ADD KEY `fk_depto_a_sol` (`id_depto_a_sol`);

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
  MODIFY `id_depto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `id_folio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del usuario', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `folios`
--
ALTER TABLE `folios`
  ADD CONSTRAINT `fk_depto_a_sol_folio` FOREIGN KEY (`id_depto_a_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_depto_sol_folio` FOREIGN KEY (`id_depto_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_folio` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_folio` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_depto_a_sol` FOREIGN KEY (`id_depto_a_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_depto_sol` FOREIGN KEY (`id_depto_sol`) REFERENCES `departamentos` (`id_depto`) ON DELETE CASCADE ON UPDATE CASCADE,
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
