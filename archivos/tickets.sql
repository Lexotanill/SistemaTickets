-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2024 a las 01:57:45
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
-- Base de datos: `127_0_0_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`user_id`, `email`, `password`) VALUES
(1, 'admin@itel.edu.ar', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `CategoriaID` int(10) UNSIGNED NOT NULL,
  `NombreCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`CategoriaID`, `NombreCategoria`) VALUES
(1, 'Solicitud de Laptops'),
(2, 'Tickets de Reparaciones'),
(3, 'Tickets de Wifi'),
(4, 'Pedidos al Pañol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantes`
--

CREATE TABLE `pasantes` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pasantes`
--

INSERT INTO `pasantes` (`user_id`, `email`, `password`, `nombre`) VALUES
(1, 'rmanzi@itel.edu.ar', 'admin', 'Rocío Manzi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `TicketID` int(11) NOT NULL,
  `aula` enum('Aula 1','Aula 2','Aula 3','Aula 4','Aula 5','Aula 6','Aula chica','Aula grande','Laboratorio 1','Laboratorio 2','Laboratorio 3','Laboratorio 4','Taller 1','Taller 2','Taller 3') NOT NULL,
  `materia` varchar(77) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Estado` enum('realizado','rechazado','pendiente') NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaCierre` datetime DEFAULT NULL,
  `UsuarioID` int(11) UNSIGNED NOT NULL,
  `categoria` enum('Solicitud de Notebooks','Ticket de Wifi','Ticket de Reparación','Solicitudes al pañol') NOT NULL,
  `CategoriaID` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `curso` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `nombre`, `email`, `password`, `curso`) VALUES
(1, 'Ian Lucero', 'ilucero@itel.edu.ar', 'admin', '6toU'),
(2, 'Maria Palacio', 'mipalacioortiz@itel.edu.ar', 'admin', '6toU');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`CategoriaID`),
  ADD UNIQUE KEY `CategoriaID_3` (`CategoriaID`),
  ADD KEY `CategoriaID` (`CategoriaID`),
  ADD KEY `CategoriaID_2` (`CategoriaID`);

--
-- Indices de la tabla `pasantes`
--
ALTER TABLE `pasantes`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `UsuarioID` (`UsuarioID`),
  ADD KEY `CategoriaID` (`CategoriaID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `CategoriaID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pasantes`
--
ALTER TABLE `pasantes`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`CategoriaID`) REFERENCES `categorias` (`CategoriaID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`user_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`CategoriaID`) REFERENCES `categorias` (`CategoriaID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
