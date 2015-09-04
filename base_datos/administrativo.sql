-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2014 a las 01:48:28
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `administrativo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_bancos_empresa`
--

CREATE TABLE IF NOT EXISTS `ad_bancos_empresa` (
  `id_empresa` int(11) DEFAULT NULL,
  `id_banco` int(11) DEFAULT NULL,
  KEY `id_empresa` (`id_empresa`),
  KEY `id_banco` (`id_banco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ad_bancos_empresa`
--

INSERT INTO `ad_bancos_empresa` (`id_empresa`, `id_banco`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 3),
(5, 4),
(6, 4),
(7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_bitacora`
--

CREATE TABLE IF NOT EXISTS `ad_bitacora` (
  `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `accion` text,
  `lugar` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_log` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bitacora`),
  KEY `id_usuario` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Volcado de datos para la tabla `ad_bitacora`
--

INSERT INTO `ad_bitacora` (`id_bitacora`, `id_user`, `accion`, `lugar`, `usuario`, `fecha_log`) VALUES
(1, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-19 00:26:33'),
(2, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-19 03:21:17'),
(3, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 01:55:41'),
(4, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 02:04:25'),
(5, 2, 'Se creó el usuario PEDRO', 'Admin / crear usuario admin', 'PEDRO', '2014-09-20 04:12:18'),
(6, 3, 'Se creó el usuario DOCTOR', 'Admin / crear usuario admin', 'DOCTOR', '2014-09-20 04:13:11'),
(7, 1, 'Cerró sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 04:20:11'),
(8, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 04:20:23'),
(9, 1, 'Cerró sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 04:20:58'),
(10, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-20 04:27:03'),
(11, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-21 00:04:21'),
(12, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-21 03:04:58'),
(13, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-21 06:14:27'),
(14, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-21 16:39:54'),
(15, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-21 19:02:19'),
(16, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-22 03:10:15'),
(17, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 00:05:33'),
(18, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 03:24:11'),
(19, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 06:08:45'),
(20, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 15:39:11'),
(21, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 17:22:56'),
(22, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 20:16:00'),
(23, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-23 22:47:04'),
(24, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-24 03:04:46'),
(25, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-24 23:17:58'),
(26, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-25 03:42:58'),
(27, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-25 15:04:21'),
(28, 1, 'Cerró sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-25 15:11:14'),
(29, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-26 03:35:19'),
(30, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-27 02:40:06'),
(31, 1, 'Cerró sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-27 03:18:52'),
(32, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-27 03:19:02'),
(33, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-27 17:37:42'),
(34, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-28 00:21:11'),
(35, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-28 00:27:57'),
(36, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-28 16:33:57'),
(37, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-29 21:47:50'),
(38, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-29 22:35:51'),
(39, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-30 03:36:44'),
(40, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-30 03:53:48'),
(41, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-30 16:30:46'),
(42, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-30 17:32:16'),
(43, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-09-30 20:30:25'),
(44, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-10-01 03:21:51'),
(45, 1, 'Inicio sesión el usuario o_kab_admin', 'Login', 'o_kab_admin', '2014-10-02 13:04:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_catalogo_bancos`
--

CREATE TABLE IF NOT EXISTS `ad_catalogo_bancos` (
  `id_banco` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_banco` varchar(80) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_banco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ad_catalogo_bancos`
--

INSERT INTO `ad_catalogo_bancos` (`id_banco`, `nombre_banco`, `fecha_reg`) VALUES
(1, 'BANORTE', '2014-09-30 18:00:52'),
(2, 'SANTANDER', '2014-09-30 18:00:58'),
(3, 'BANREGIO', '2014-09-30 18:00:16'),
(4, 'BANBAJIO ', '2014-09-30 18:00:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_catalogo_cliente`
--

CREATE TABLE IF NOT EXISTS `ad_catalogo_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(250) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `comision` float DEFAULT NULL,
  `tipo_cliente` char(2) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ad_catalogo_cliente`
--

INSERT INTO `ad_catalogo_cliente` (`id_cliente`, `nombre_cliente`, `email`, `comision`, `tipo_cliente`, `fecha_reg`) VALUES
(1, 'Ernesto Jimenez', 'juan@gmail.com', 0.068, 'B', '2014-09-30 04:08:41'),
(2, 'Juan Perez', 'jesme@jotmail.com', 0, 'A', '2014-09-30 04:08:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_catalogo_empresa`
--

CREATE TABLE IF NOT EXISTS `ad_catalogo_empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(150) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `ad_catalogo_empresa`
--

INSERT INTO `ad_catalogo_empresa` (`id_empresa`, `nombre_empresa`, `estatus`) VALUES
(1, 'Taen', 1),
(2, 'Tiak', 1),
(3, 'MAQUILADORA DOMINO  SA DE CV', 1),
(4, 'TEXTILES ALFA BETA, S.A. DE C.V.', 1),
(5, 'CONSTRUCTORA BDM, S.A. DE C.V.', 1),
(6, 'MULTISERVICIOS Y LOGISTICA BRACHO, S.A. DE C.V.', 1),
(7, 'COMERCIALIZADORA Y DISTRIBUIDORA GAFA, S.A. DE C.V.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_catalogo_perfiles`
--

CREATE TABLE IF NOT EXISTS `ad_catalogo_perfiles` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_perfil` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ad_catalogo_perfiles`
--

INSERT INTO `ad_catalogo_perfiles` (`id_perfil`, `nombre_perfil`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_depositos`
--

CREATE TABLE IF NOT EXISTS `ad_depositos` (
  `id_deposito` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_deposito` date DEFAULT NULL,
  `monto_deposito` double DEFAULT NULL,
  `id_cliente` int(11) DEFAULT '0',
  `folio_depto` varchar(50) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_deposito`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ad_depositos`
--

INSERT INTO `ad_depositos` (`id_deposito`, `fecha_deposito`, `monto_deposito`, `id_cliente`, `folio_depto`, `fecha_reg`) VALUES
(1, '2014-09-02', 500000, 1, 'DEP-00001', '2014-10-01 03:32:32'),
(2, '2014-09-12', 300000, 2, 'DEP-00002', '2014-10-01 03:36:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_deposito_pago`
--

CREATE TABLE IF NOT EXISTS `ad_deposito_pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL DEFAULT '0',
  `id_banco` int(11) NOT NULL DEFAULT '0',
  `id_deposito` int(11) NOT NULL DEFAULT '0',
  `monto_pago` int(11) DEFAULT NULL,
  `empresa_retorno` int(11) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `folio_pago` varchar(100) DEFAULT NULL,
  `ruta_comprobante` varchar(200) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pago`),
  KEY `id_empresa` (`id_empresa`),
  KEY `id_banco` (`id_banco`),
  KEY `id_deposito` (`id_deposito`),
  KEY `empresa_retorno` (`empresa_retorno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ad_deposito_pago`
--

INSERT INTO `ad_deposito_pago` (`id_pago`, `id_empresa`, `id_banco`, `id_deposito`, `monto_pago`, `empresa_retorno`, `fecha_pago`, `folio_pago`, `ruta_comprobante`, `fecha_reg`) VALUES
(1, 1, 1, 1, 98541, 2, '2014-09-03', 'PAG-00001', NULL, '2014-10-01 03:33:05'),
(2, 2, 1, 2, 83650, 1, '2014-09-22', 'PAG-00002', NULL, '2014-10-01 03:37:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_detalle_cuenta`
--

CREATE TABLE IF NOT EXISTS `ad_detalle_cuenta` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_banco` int(11) DEFAULT NULL,
  `id_movimiento` int(11) DEFAULT NULL,
  `fecha_movimiento` date DEFAULT NULL,
  `tipo_movimiento` char(30) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detalle`),
  KEY `id_empresa` (`id_empresa`),
  KEY `id_banco` (`id_banco`),
  KEY `id_movimiento` (`id_movimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `ad_detalle_cuenta`
--

INSERT INTO `ad_detalle_cuenta` (`id_detalle`, `id_empresa`, `id_banco`, `id_movimiento`, `fecha_movimiento`, `tipo_movimiento`, `fecha_reg`) VALUES
(1, 1, 1, 1, '2014-09-02', 'deposito', '2014-10-01 03:32:24'),
(2, 2, 1, 1, '2014-09-03', 'salida_pago', '2014-10-01 03:33:06'),
(3, 2, 1, 2, '2014-09-12', 'deposito', '2014-10-01 03:34:22'),
(4, 1, 1, 2, '2014-09-15', 'salida', '2014-10-01 03:34:54'),
(5, 1, 1, 3, '2014-09-17', 'mov_int', '2014-10-01 03:35:43'),
(6, 1, 1, 4, '2014-09-22', 'salida_pago', '2014-10-01 03:37:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_efectivo`
--

CREATE TABLE IF NOT EXISTS `ad_efectivo` (
  `id_efectivo` int(11) NOT NULL AUTO_INCREMENT,
  `efectivo` varchar(45) DEFAULT NULL,
  `ingreso` decimal(10,0) DEFAULT NULL,
  `retiro` decimal(10,0) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_efectivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_fondos`
--

CREATE TABLE IF NOT EXISTS `ad_fondos` (
  `id_fondo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_movimiento` datetime DEFAULT NULL,
  `retiro_aportacion` varchar(150) DEFAULT NULL,
  `importe` decimal(10,0) DEFAULT NULL,
  `retiro` decimal(10,0) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_fondo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_gastos_pagados`
--

CREATE TABLE IF NOT EXISTS `ad_gastos_pagados` (
  `id_gasto` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_gasto` datetime DEFAULT NULL,
  `concepto` text,
  `importe` decimal(10,0) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_gastos_provisionados`
--

CREATE TABLE IF NOT EXISTS `ad_gastos_provisionados` (
  `id_gasto_prov` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_gasto_prov` datetime DEFAULT NULL,
  `concepto` text,
  `importe` decimal(10,0) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_gasto_prov`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_movimientos_internos`
--

CREATE TABLE IF NOT EXISTS `ad_movimientos_internos` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_banco` int(11) NOT NULL,
  `empresa_destino` int(11) DEFAULT NULL,
  `banco_destino` int(11) DEFAULT NULL,
  `monto` double DEFAULT NULL,
  `fecha_mov` date DEFAULT NULL,
  `folio_entrada` varchar(50) DEFAULT NULL,
  `folio_salida` varchar(50) DEFAULT NULL,
  `folio_movimiento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `id_empresa` (`id_empresa`),
  KEY `id_banco` (`id_banco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `ad_movimientos_internos`
--

INSERT INTO `ad_movimientos_internos` (`id_movimiento`, `id_empresa`, `id_banco`, `empresa_destino`, `banco_destino`, `monto`, `fecha_mov`, `folio_entrada`, `folio_salida`, `folio_movimiento`) VALUES
(1, 1, 1, 2, 1, 15000, '2014-09-17', 'MOVE-0001', 'MOVS-0001', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_salidas`
--

CREATE TABLE IF NOT EXISTS `ad_salidas` (
  `id_salida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_salida` date DEFAULT NULL,
  `monto_salida` double DEFAULT NULL,
  `folio_salida` varchar(50) DEFAULT NULL,
  `fecha_reg` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_salida`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `ad_salidas`
--

INSERT INTO `ad_salidas` (`id_salida`, `fecha_salida`, `monto_salida`, `folio_salida`, `fecha_reg`) VALUES
(1, '2014-09-03', 98541, 'PAG-00001', '2014-10-01 03:33:06'),
(2, '2014-09-15', 85640, 'SAL-00001', '2014-10-01 03:34:54'),
(3, '2014-09-17', 15000, 'MOVS-0001', '2014-10-01 03:35:43'),
(4, '2014-09-22', 83650, 'PAG-00002', '2014-10-01 03:37:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ad_usuarios`
--

CREATE TABLE IF NOT EXISTS `ad_usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT '0',
  `privilegios` tinyint(4) DEFAULT '0',
  `ultimo_acceso` datetime DEFAULT NULL,
  `fechas_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  KEY `id_perfil` (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `ad_usuarios`
--

INSERT INTO `ad_usuarios` (`id_user`, `id_perfil`, `username`, `password`, `estatus`, `privilegios`, `ultimo_acceso`, `fechas_reg`) VALUES
(1, 1, 'o_kab_admin', '82266eb2f210a93224ce8ff0f59592da5b9e6a6f', 1, 1, '2014-10-02 08:04:17', '2014-10-02 13:04:17'),
(2, 1, 'PEDRO', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, '2014-09-19 23:12:17', '2014-09-23 17:27:48'),
(3, 1, 'DOCTOR', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, '2014-09-19 23:13:11', '2014-09-23 17:27:48');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ad_usuarios`
--
ALTER TABLE `ad_usuarios`
  ADD CONSTRAINT `FK_ad_usuarios_ad_catalogo_perfiles` FOREIGN KEY (`id_perfil`) REFERENCES `ad_catalogo_perfiles` (`id_perfil`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
