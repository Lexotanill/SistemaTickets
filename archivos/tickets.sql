-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2024 a las 20:59:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tickets`
--

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
  `CategoriaID` int(10) UNSIGNED DEFAULT NULL,
  `mail` varchar(50) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`TicketID`, `aula`, `materia`, `Descripcion`, `Estado`, `FechaCreacion`, `FechaCierre`, `UsuarioID`, `categoria`, `CategoriaID`, `mail`, `fecha`) VALUES
(29, '', 'asdas', 'asdasd', 'pendiente', '2024-06-12 18:45:31', '2024-06-26 15:45:31', 1, '', NULL, 'ilucero@itel.edu.ar', '2024-06-22'),
(30, '', 'sadsad', 'asdsad', 'pendiente', '2024-06-12 18:48:19', '2024-06-26 15:48:19', 2, '', NULL, 'mipalacioortiz@itel.edu.ar', '2024-06-27'),
(31, '', 'sadsad', 'asdsad', 'pendiente', '2024-06-12 18:56:04', '2024-06-26 15:56:04', 2, '', NULL, 'mipalacioortiz@itel.edu.ar', '2024-06-27'),
(32, '', 'sadsad', 'asdsad', 'pendiente', '2024-06-12 18:56:20', '2024-06-26 15:56:20', 2, '', NULL, 'mipalacioortiz@itel.edu.ar', '2024-06-27'),
(33, '', 'sadsad', 'vfgfdgfdg', 'pendiente', '2024-06-12 18:56:35', '2024-06-26 15:56:35', 2, '', NULL, 'mipalacioortiz@itel.edu.ar', '2024-06-27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `UsuarioID` (`UsuarioID`),
  ADD KEY `CategoriaID` (`CategoriaID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

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
