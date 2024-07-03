-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2024 a las 03:09:50
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
-- Base de datos: `tickets`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `objeto` varchar(30) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `especificaciones` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `objeto`, `cantidad`, `especificaciones`) VALUES
(1, 'Alargues', 10, ''),
(2, 'Alicates grandes', 10, 'Grandes'),
(3, 'Alicates pequeños', 6, 'Pequeños'),
(4, 'Cintas métricas', 3, ''),
(5, 'Crimpeadoras', 2, ''),
(6, 'Destornilladores philips', 6, 'Grandes'),
(7, 'Destornilladores philips', 4, 'Medianos'),
(8, 'Destornilladores philips', 15, 'Pequeños'),
(9, 'Destornilladores planos ', 14, 'Grandes'),
(10, 'Destornilladores planos ', 16, 'Pequeños'),
(11, 'Laptops', 29, ''),
(12, 'Limas', 2, 'Triangulares'),
(13, 'Limas', 4, ''),
(14, 'Limas ', 3, 'Redondas'),
(15, 'Martillos', 2, ''),
(16, 'Mouses puerto redondo', 16, ''),
(17, 'Mouses USB', 3, ''),
(18, 'Pínceles', 5, ''),
(19, 'Pinzas', 9, ''),
(20, 'Rodillos', 5, ''),
(21, 'Serruchos', 5, ''),
(22, 'Sierras', 6, ''),
(23, 'Taladros de impacto', 3, ''),
(24, 'Teclados PS2', 2, ''),
(25, 'Teclados USB', 2, ''),
(26, 'Tester LAN', 1, ''),
(27, 'ian y ro', 1, 'we were here'),
(28, 'firma promo', 2024, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `TicketID` int(11) NOT NULL,
  `.` varchar(100) DEFAULT NULL,
  `aula` enum('Aula 1','Aula 2','Aula 3','Aula 4','Aula 5','Aula 6','Aula chica','Aula grande','Laboratorio 1','Laboratorio 2','Laboratorio 3','Laboratorio 4','Taller 1','Taller 2','Taller 3') NOT NULL,
  `materia` varchar(77) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Estado` enum('Realizado','Rechazado','Pendiente') NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaCierre` datetime DEFAULT NULL,
  `UsuarioID` int(11) UNSIGNED NOT NULL,
  `categoria` varchar(99) NOT NULL,
  `CategoriaID` int(10) UNSIGNED DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `fechaSolicitud` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`TicketID`, `.`, `aula`, `materia`, `Descripcion`, `Estado`, `FechaCreacion`, `FechaCierre`, `UsuarioID`, `categoria`, `CategoriaID`, `mail`, `fechaSolicitud`) VALUES
(30, NULL, 'Aula 2', 'Seguridad Informatica', 'Wifi porfa', 'Realizado', '2023-11-17 00:44:47', '2023-11-30 21:44:47', 1, 'Tickets de Wifi', NULL, NULL, NULL),
(31, NULL, 'Aula chica', 'Hardware', 'se rompió', 'Realizado', '2023-11-17 00:56:15', '2023-11-30 21:56:15', 1, 'Tickets de Reparaciones', NULL, NULL, NULL),
(32, NULL, 'Aula 4', 'Piziii', 'Aprobanos porfa me siento cansado jefe', 'Realizado', '2023-11-17 01:04:48', '2023-11-30 22:04:48', 1, 'Pedidos al Pañol', NULL, NULL, NULL),
(33, NULL, 'Aula 4', 'Piziii', 'basta', 'Realizado', '2023-11-17 01:08:42', '2023-11-30 22:08:42', 1, 'Pedidos al Pañol', NULL, NULL, NULL),
(34, NULL, 'Aula 4', 'a', 'basta', 'Realizado', '2023-11-17 01:10:37', '2023-11-30 22:10:37', 1, 'Pedidos al Pañol', NULL, NULL, NULL),
(35, NULL, 'Aula chica', 'Hardwe', 'se aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaarompió', 'Rechazado', '2023-11-17 01:34:47', '2023-11-30 22:34:47', 1, 'Tickets de Reparaciones', NULL, NULL, NULL),
(37, NULL, 'Aula 1', 'Seguridad Informatica', 'si', 'Realizado', '2024-04-10 13:49:32', '2024-04-24 10:49:32', 1, 'Solicitud de Laptops', NULL, 'ilucero@itel.edu.ar', NULL),
(38, NULL, 'Aula 3', 'Seguridad Informatica', 'porfavor en serio', 'Realizado', '2024-04-10 14:00:16', '2024-04-24 11:00:16', 1, 'Solicitud de Laptops', NULL, 'ilucero@itel.edu.ar', NULL),
(39, NULL, 'Aula 3', 'Seguridad Informatica', 'porfavor en serio', 'Realizado', '2024-04-10 14:02:53', '2024-04-24 11:02:53', 1, 'Solicitud de Laptops', NULL, 'ilucero@itel.edu.ar', NULL),
(40, NULL, 'Aula 3', 'prueba', 'preuba', 'Realizado', '2024-04-10 14:04:33', '2024-04-24 11:04:33', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', NULL),
(41, NULL, 'Aula 3', 'pruebas', 'preubas', 'Rechazado', '2024-04-10 14:07:27', '2024-04-24 11:07:27', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', NULL),
(42, NULL, 'Aula 3', 'pruebas', 'ola', 'Realizado', '2024-04-10 14:10:26', '2024-04-24 11:10:26', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', NULL),
(43, NULL, 'Aula 2', 'assad', 'ghjhjgg', 'Realizado', '2024-04-10 15:38:42', '2024-04-24 12:38:42', 1, 'Tickets de Wifi', NULL, NULL, NULL),
(44, NULL, 'Aula 2', '1203123', '34534123', 'Realizado', '2024-04-10 15:39:57', '2024-04-24 12:39:57', 1, 'Tickets de Wifi', NULL, NULL, NULL),
(45, NULL, 'Aula 2', 'dxfg324', 'dq421q3', 'Realizado', '2024-04-10 15:40:33', '2024-04-24 12:40:33', 1, 'Tickets de Wifi', NULL, NULL, NULL),
(46, NULL, 'Aula 2', 'dxfg324', 'dq421q3', 'Realizado', '2024-04-10 15:42:17', '2024-04-24 12:42:17', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', NULL),
(47, NULL, 'Aula 2', 'dxfg324', 'dq421q3', 'Realizado', '2024-04-10 15:57:26', '2024-04-24 12:57:26', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', NULL),
(48, NULL, 'Aula 2', '24wer', 'dq421q3sdfsd', 'Realizado', '2024-04-10 15:59:08', '2024-04-24 12:59:08', 1, 'Tickets de Reparaciones', NULL, 'ilucero@itel.edu.ar', NULL),
(49, NULL, 'Aula 2', '24wer', 'dq421q3sdfsd', 'Realizado', '2024-04-10 16:03:03', '2024-04-24 13:03:03', 1, 'Tickets de Reparaciones', NULL, 'ilucero@itel.edu.ar', NULL),
(50, NULL, '', 'Seguridad Informatica', 'HOLA A TODOS YT', 'Realizado', '2024-06-30 15:53:50', '2024-07-14 12:53:50', 2, 'categoria2', NULL, 'mipalacioortiz@itel.edu.ar', '2024-07-27'),
(52, NULL, '', 'asdas', 'asdasd', 'Realizado', '2024-06-30 21:08:46', '2024-07-14 18:08:46', 2, 'categoria1', NULL, 'xxlick064xx@gmail.com', '2024-07-19'),
(53, NULL, '', 'Seguridad Informatica', 'quiero compus', 'Realizado', '2024-06-30 21:24:46', '2024-07-14 18:24:46', 2, 'categoria1', NULL, 'xxlick064xx@gmail.com', '2024-07-12'),
(54, NULL, '', 'Seguridad Informatica', 'asdasd', 'Realizado', '2024-06-30 21:38:46', '2024-07-14 18:38:46', 2, 'categoria1', NULL, 'xxlick064xx@gmail.com', '2024-08-24'),
(55, NULL, '', 'asdasd', 'asdasd', 'Pendiente', '2024-06-30 21:43:51', '2024-07-14 18:43:51', 2, 'categoria1', NULL, 'xxlick064xx@gmail.com', '2024-08-16'),
(56, NULL, '', 'asdasd', 'asdasd', 'Pendiente', '2024-06-30 22:05:49', '2024-07-14 19:05:49', 2, 'categoria1', NULL, 'xxlick064xx@gmail.com', '2024-08-16'),
(57, NULL, '', 'asdasd', 'asdasd', 'Realizado', '2024-06-30 22:08:07', '2024-07-14 19:08:07', 2, 'categoria2', NULL, 'xxlick064xx@gmail.com', '2024-08-16'),
(58, NULL, '', 'asdasd', 'asdasd', 'Realizado', '2024-06-30 22:11:30', '2024-07-14 19:11:30', 2, 'categoria2', NULL, 'xxlick064xx@gmail.com', '2024-08-16'),
(59, NULL, '', 'asdasd', 'asdasd', 'Realizado', '2024-06-30 22:14:02', '2024-07-14 19:14:02', 2, 'categoria2', NULL, 'xxlick064xx@gmail.com', '2024-08-16'),
(60, NULL, 'Aula 1', 'prueba 1', 'ARREGLEN ESO YA', 'Realizado', '2024-07-02 22:37:43', '2024-07-16 19:37:43', 2, 'Tickets de Wifi', NULL, 'xxlick064xx@gmail.com', '2024-07-04'),
(61, NULL, 'Aula 1', 'prueba 2', 'ARREGLEN ESO YA PORFA', 'Realizado', '2024-07-02 22:46:24', '2024-07-16 19:46:24', 1, 'Tickets de Wifi', NULL, 'ilucero@itel.edu.ar', '2024-07-04'),
(62, NULL, 'Aula 1', 'PRUEBA 3', 'ASDASD', 'Rechazado', '2024-07-02 22:48:52', '2024-07-16 19:48:52', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(63, NULL, 'Aula 1', 'PRUEBA 4', 'ASDASD', 'Realizado', '2024-07-02 22:50:41', '2024-07-16 19:50:41', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(64, NULL, 'Aula 1', 'PRUEBA 5', 'ASDASD', 'Rechazado', '2024-07-02 22:53:49', '2024-07-16 19:53:49', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(65, NULL, 'Aula 1', 'asdasd', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Pendiente', '2024-07-02 23:01:59', '2024-07-16 20:01:59', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(66, NULL, 'Aula 1', 'asdasd', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Pendiente', '2024-07-02 23:05:40', '2024-07-16 20:05:40', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(67, NULL, 'Aula 1', 'asdasd', 'asdasd', 'Pendiente', '2024-07-02 23:06:00', '2024-07-16 20:06:00', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '0000-00-00'),
(68, NULL, 'Aula 1', 'asdasd', 'asdasdas', 'Pendiente', '2024-07-02 23:12:43', '2024-07-16 20:12:43', 2, 'Solicitud de Laptops', NULL, 'xxlick064xx2@gmail.com', '2024-07-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `rol` varchar(25) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `materia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `mail`, `nombre`, `email`, `pass`, `rol`, `curso`, `materia`) VALUES
(1, NULL, 'Ian Lucero', 'ilucero@itel.edu.ar', '$2y$10$azbi6cq26Hy06PYJArcF0eC4CuC2rvZzO83z3GLL/pAOjk9FfxmGu', 'admin', '6toU', 'TODAS'),
(2, NULL, 'Maria Palacio', 'xxlick064xx2@gmail.com', '$2y$10$X6tlLCgysMMQnaXbMEBzweyEmLSoz1aKvoc34T642kwwnHwdLsyEC', 'user', '6toU', 'TODAS'),
(3, NULL, 'admin', 'admin@itel.edu.ar', '$2y$10$r3jxO/qiRTlRrFJkcsyLbuV3cGRVzx6UuMo0mKSppHnG.O8owFqK.', 'pasante', 'todo', 'todas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`CategoriaID`),
  ADD UNIQUE KEY `CategoriaID_3` (`CategoriaID`),
  ADD KEY `CategoriaID` (`CategoriaID`),
  ADD KEY `CategoriaID_2` (`CategoriaID`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD UNIQUE KEY `mail` (`.`),
  ADD KEY `UsuarioID` (`UsuarioID`),
  ADD KEY `CategoriaID` (`CategoriaID`),
  ADD KEY `idx_email` (`mail`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `CategoriaID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`CategoriaID`) REFERENCES `categorias` (`CategoriaID`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`.`) REFERENCES `usuarios` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_mail` FOREIGN KEY (`mail`) REFERENCES `tickets` (`mail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
