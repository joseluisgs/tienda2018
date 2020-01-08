-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-01-2019 a las 12:22:46
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `ID` int(3) NOT NULL,
  `PREGUNTA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `RESPUESTA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `captcha`
--

INSERT INTO `captcha` (`ID`, `PREGUNTA`, `RESPUESTA`) VALUES
(10, '¿Cuantos lados tiene un triangulo?', '3'),
(11, '¿Que fruta es el logo de Apple?', 'MANZANA'),
(12, '¿Dale a tu cuerpo alegria...?', 'MACARENA'),
(13, '(Darkvader) Yo soy tu...', 'PADRE'),
(14, 'El patio de mi casa es...', 'PARTICULAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `ID` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `USUARIO` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CODPRODUCTO` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CANTIDAD` int(5) DEFAULT NULL,
  `FECHA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID`, `USUARIO`, `CODPRODUCTO`, `CANTIDAD`, `FECHA`) VALUES
('MARIA475956', 'MARIA', 'DI261172', 1, '23/10/2015');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'OTROS',
  `MARCA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `MODELO` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DESCRIPCION` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `PRECIO` float NOT NULL,
  `STOCK` int(5) NOT NULL,
  `OFERTA` tinyint(1) NOT NULL,
  `FOTO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_pro_tipo` (`TIPO`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `TIPO`, `MARCA`, `MODELO`, `DESCRIPCION`, `PRECIO`, `STOCK`, `OFERTA`, `FOTO`) VALUES
(1, 'DISCODURO', 'Seagate', 'BarraCuda', 'Capacidad de disco duro: 3000 GB|Interfaz del disco duro: Serial ATA III| Velocidad de rotación de disco duro: 7200 RPM| Tamañoo de disco duro: 3.5|', 80.2, 3, 0, '8f0dde4b587babdcf255396e4392e0e3.png'),
(2, 'DISCODURO', 'Seagate', 'BarraCuda', 'Capacidad de disco duro: 2000 GB| Interfaz del disco duro: Serial ATA III| Velocidad de rotación de disco duro: 7200 RPM| Tamaño de disco duro: 3.5|', 69.59, 5, 1, '59d776f0685c719b3e58a24f1e91f5e8.png'),
(3, 'DISCODURO', 'Wenster Digital', 'Blue', 'Capacidad de disco duro: 2000 GB| Interfaz del disco duro: Serial ATA III| Velocidad de rotación de disco duro: 7200 RPM| Tamaño de disco duro: 3.5|', 60, 3, 0, 'ebfe560e85e2d92ede1399b89dfef0cf.png'),
(4, 'DISCODURO', 'Samsung', '860 EVO', 'Capacidad de disco duro: 256 GB|Tecnología: SSD|Interfaz del disco duro: Serial ATA III|Velocidad de rotación de disco duro: 7200 RPM|Tamañoo de disco duro: 2.5|', 84.99, 4, 0, 'b0b3aa649cad3a1e3f8a488426d8b3c3.png'),
(5, 'MONITORES', 'Lacie', 'E2470SWH', 'General|Línea monitor Value-line|Tamaño monitor 23.6 Inch|Tamaño visible de pantalla 521.28x293.32|Formato de pantalla 16:9|Resolución Resolución máxima 1920x1080@60Hz|Resolución recomendada 1920x1080@60Hz|Colores 16.7 Million', 125, 5, 0, '60039c903096049e9a6d318051251207.png'),
(6, 'MONITORES', 'Quatto', 'Q2765AV', 'General|Línea monitor Value-line|Tamaño monitor 27.2 Inch|Formato de pantalla 16:9|Resolución Resolución máxima  2560 x 1440@60Hz|Resolución recomendada  2560 x 1440@60Hz|Colores 13Million', 451, 5, 1, 'c0316d3a124eca393507adb9ee31f9c4.png'),
(7, 'MONITORES', 'Barco', 'B123DERHD', 'General|Línea monitor Value-line|Tamaño monitor 23.6 Inch|Tamaño visible de pantalla 521.28x293.32|Formato de pantalla 16:9|Resolución Resolución máxima 1920x1080@60Hz|Resolución recomendada 1920x1080@60Hz|Colores 16.7 Million', 154.99, 5, 1, 'fe6c6b3ca76d81a3b3ff3f7b24a86764.png'),
(8, 'MONITORES', 'Dell', 'U2715', 'General|Línea monitor Value-line|Tamaño monitor 27.2 Inch|Formato de pantalla 16:9|Resolución Resolución máxima  2560 x 1440@60Hz|Resolución recomendada  2560 x 1440@60Hz|Colores 13Million', 450, 5, 1, 'a2e8681f10a32932c476b79e2ba56931.png'),
(9, 'PORTATILES', 'ASUS', 'D540NA-GQ059T', 'Con Windows 10|Pantalla HD de 15,6\" - 39,62 cm|Procesador Intel Celeron N3350|4 GB de memoria RAM LPDDR3|Almacenamiento 500 GB HDD', 339, 10, 0, '9852134efc456262206bdaf1d72f3b01.png'),
(10, 'PORTATILES', 'Acer', 'Predator Helios 300', 'Procesador Intel Core i7-8750H (6 núcleos, 2.2GHz - 4.1GHz, 9MB)|Memoria 16 GB DDR4 Memory|Almacenamiento 1000 GB HDD + 256GB SSD|Display 17.3\" FHD Acer ComfyView IPS LCD 16:9 FHD IPS (1920 x 1080)|Controlador gráfico NVIDIA GeForce GTX 1050Ti|Conectividad 802.11ac Bluetooth 5.0', 1079.01, 2, 0, 'bb064b4f61f6e66b8776894c8a3ec2c1.png'),
(11, 'PORTATILES', 'HP', 'Notebook 250 G6', 'Procesador Intel Core i5-7200U (2 Núcleos, 3M Cache, 2.5GHz hasta 3.1GHz)|Memoria RAM SDRAM DDR4-2133 de 8 GB|Disco duro 256 GB SSD|Almacenamiento Óptico Grabadora de DVD SuperMulti|Display Pantalla fina FHD SVA eDP de 39,6 cm (15,6 pulg.) en diagonal, antirreflejo, WLED (1920 x 1080)|Controlador gráfico Intel HD 620 Conectividad 10/100/1000 Gigabit Combo de Intel Dual Band Wireless-AC 3168 802.11 a/b/g/n/ac (1x1) Wi-Fi y Bluetooth 4.2 (no vPro)', 559, 5, 1, '0624f58af16cce5616ee3c7291bd7859.png'),
(12, 'PORTATILES', 'DELL', 'Vostro 5568', 'Procesador Intel Core i5-7200U (2.5 GHz, 3 MB)|Memoria RAM 8GB DDR4 SODIMM|Disco duro 256 GB SSD|Display 15.6\" LED FullHD (1920 x 1080) 16:9 Mate|Controlador gráfico Intel HD Graphics620|Conectividad LAN 10/100/1000 WiFi 802.11 ac Bluetooth V4.2 High Speed', 769.69, 3, 1, '0693a3b823f9005071fc8603dc75a6bf.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_tipo`
--

DROP TABLE IF EXISTS `product_tipo`;
CREATE TABLE IF NOT EXISTS `product_tipo` (
  `TIPO` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`TIPO`),
  UNIQUE KEY `TIPO` (`TIPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `product_tipo`
--

INSERT INTO `product_tipo` (`TIPO`) VALUES
('DISCODURO'),
('MONITORES'),
('PORTATILES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `PASS` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EMAIL` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECCION` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FOTO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ADMIN` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `PASS`, `EMAIL`, `DIRECCION`, `FOTO`, `ADMIN`) VALUES
(1, 'maria', '263bce650e68ab4e23f28263760b9fa5', 'maria@maria.com', 'marialandia', 'af4be49d1f8c19c716a1753a8ef2d5fa.png', 0),
(2, 'pepe', '926e27eecdbc7a18858b3798ba99bddd', 'pepe@pepe.com', 'pepilandia2', 'fd728cc47bd157190a7783acefc3fb87.png', 1),
(3, 'perico', 'dfe483413e24a5b1506389d36ebfd05c', 'perico@perico.com', 'pericolandia', '0678bbbfd54441766dc8763d304d2d59.png', 0),
(4, 'ana', '276b6c4692e78d4799c12ada515bc3e4', 'ana@ana.com', 'analandia', 'f87023390ecd2e5b818657105a76cacb.png', 0),
(6, 'pedro', 'c6cc8094c2dc07b700ffcc36d64e2138', 'pedro@pedro.com', 'pedrolandia', '9134b86bd9d2ee8288104190320667f6.png', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`TIPO`) REFERENCES `product_tipo` (`TIPO`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
