/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bitacora
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(20) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Listado de actividade de la cooporacion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adicional`
--

DROP TABLE IF EXISTS `adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `adicional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` tinyint(2) NOT NULL COMMENT 'Tipo de rubro asignado',
  `monto` decimal(6,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Datos de los diferentes descuentos de la nomina';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `anuncios`
--

DROP TABLE IF EXISTS `anuncios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci DEFAULT NULL,
  `type` enum('noticias','servicios') CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `autor_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `anuncios_ibfk_1` (`autor_id`),
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archivo`
--

DROP TABLE IF EXISTS `archivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `idrespuesta` int(11) NOT NULL,
  `descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Descripcion de las tareas pendientes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(2) NOT NULL DEFAULT 1,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Listado de las areas comunes que se pueden apartar';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `observacion` varchar(120) DEFAULT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `vistas` smallint(4) DEFAULT 0,
  `timestamp` varchar(20) DEFAULT NULL,
  `latitude` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT NULL,
  `rangoerror` varchar(16) DEFAULT NULL,
  `sentido` varchar(16) DEFAULT NULL,
  `velocidad` varchar(16) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(40) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Asistencia Administrativa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idbitacora` int(11) NOT NULL DEFAULT 0,
  `tipo` enum('Bitacora','Ingresos') NOT NULL,
  `valido` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fecha` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(30) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKBItacoraVistas` (`idbitacora`),
  CONSTRAINT `FKBItacoraVistas` FOREIGN KEY (`idbitacora`) REFERENCES `bitacora` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Visualizacion de los registros de Bitacora';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorizacion`
--

DROP TABLE IF EXISTS `autorizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `autorizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `idclient` int(11) NOT NULL DEFAULT 1,
  `idresidente` int(11) NOT NULL,
  `clave` int(6) DEFAULT NULL,
  `idbitacora` int(11) DEFAULT NULL,
  `cedula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` enum('Visita','Taxi','Entrega','Otros') DEFAULT NULL,
  `manzana` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `villa` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono1` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono2` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ini_fec` datetime DEFAULT NULL,
  `entrada` datetime DEFAULT NULL,
  `salida` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKResidente` (`idclient`,`idresidente`),
  CONSTRAINT `FKClientes` FOREIGN KEY (`idclient`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de las autorizaciones de los residentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bancos`
--

DROP TABLE IF EXISTS `bancos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bancos` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de las entidades bancarias';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `idresidente` int(11) DEFAULT NULL,
  `idautoriza` int(6) DEFAULT NULL,
  `grupo` smallint(2) DEFAULT 0,
  `punto` int(11) DEFAULT 0,
  `turno` enum('Diurno','Nocturno') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `proceso` enum('Ingreso','Observacion','Salida','Parte Informativo','Supervicion','Rondas','Alerta') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nota` enum('Observacion','Parte Informativo','Supervision de Puesto','Visita al cliente','Movimiento Operativo','Reporte de Incidencias') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` enum('Visita','Taxi','Entrega','Otros','Alerta S.O.S.','Comercial','Custodia','Supervision','Entrada','Salida','Ronda','Parte','Reporte') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT 'Otros',
  `novedad` varchar(60) DEFAULT NULL,
  `superior` varchar(60) DEFAULT NULL,
  `manzana` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `villa` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `observacion` text NOT NULL,
  `accion` text DEFAULT NULL,
  `observaciono` text DEFAULT NULL,
  `acciones` text DEFAULT NULL,
  `puerta` enum('Entrada','Salida') NOT NULL,
  `foto1` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto2` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto3` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto4` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto5` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto6` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `vistas` smallint(4) DEFAULT 0,
  `timestamp` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `rangoerror` varchar(16) DEFAULT NULL,
  `sentido` varchar(16) DEFAULT NULL,
  `velocidad` varchar(16) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `estado` char(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `idPuestos` (`idpuesto`),
  KEY `idPersonas` (`idperson`),
  CONSTRAINT `FKPersonaBitacora` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`),
  CONSTRAINT `FKPuestos` FOREIGN KEY (`idpuesto`) REFERENCES `puestos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9008 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bitacora de novedades';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `box`
--

DROP TABLE IF EXISTS `box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Venta por cajas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `idtipo` tinyint(2) NOT NULL DEFAULT 1 COMMENT '(1. Administrativo, 2. Operativo, 3. Guardia, 4. Aspirante)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cargo` (`iddepartamento`,`description`) USING BTREE,
  KEY `departamento` (`iddepartamento`) USING BTREE,
  CONSTRAINT `FKDepartamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Cargos de las compañias';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(2) NOT NULL,
  `tipo` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `operationTypeFK` (`tipo`),
  CONSTRAINT `operationTypeFK` FOREIGN KEY (`tipo`) REFERENCES `operation_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Categorias asociadas a los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL DEFAULT 1,
  `tipo_empresa` enum('Publico','Privado') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Privado' COMMENT 'Permite distinguir entre empresas publicas y privadas',
  `ruc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombre` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `contacto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cargo` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono1` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono2` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `factura` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefonofac1` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefonofac2` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechafac` date DEFAULT NULL,
  `fechaini` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `ini_fac` int(2) DEFAULT NULL,
  `fin_fac` int(2) DEFAULT NULL,
  `direccion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT 0,
  `etapas` char(1) NOT NULL DEFAULT '0',
  `hadicional` char(1) DEFAULT '0',
  `hnocturna` char(1) DEFAULT '0',
  `monto` decimal(11,0) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ruc` (`ruc`),
  KEY `CompanyFK` (`idcompany`),
  CONSTRAINT `CompanyFK` FOREIGN KEY (`idcompany`) REFERENCES `company` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tabla de los clientes de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientd`
--

DROP TABLE IF EXISTS `clientd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idclient` int(11) NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `correo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKDetalleCliente` (`idclient`),
  CONSTRAINT `FKDetalleCliente` FOREIGN KEY (`idclient`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de las cotizaciones';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comercial`
--

DROP TABLE IF EXISTS `comercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `comercial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL DEFAULT 1,
  `iduser` int(11) DEFAULT NULL,
  `ruc` varchar(13) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT 1,
  `empresa` varchar(45) DEFAULT NULL,
  `nombre` varchar(40) NOT NULL,
  `contacto` varchar(50) NOT NULL,
  `cargo` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefono1` varchar(14) DEFAULT NULL,
  `telefono2` varchar(14) DEFAULT NULL,
  `telefonofac1` varchar(14) DEFAULT NULL,
  `telefonofac2` varchar(14) DEFAULT NULL,
  `extencion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `observacion` varchar(120) DEFAULT NULL,
  `gestion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `producto` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monto` decimal(8,2) DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla de los posibles clientes de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comerciald`
--

DROP TABLE IF EXISTS `comerciald`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `comerciald` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idclient` int(11) NOT NULL,
  `empresa` varchar(80) DEFAULT NULL,
  `nombre` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(10) NOT NULL DEFAULT '0',
  `correo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de las cotizaciones';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcorporacion` int(11) NOT NULL,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `logo_recibo` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `se_imprime` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ruc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `actividad` tinyint(1) NOT NULL DEFAULT 1,
  `direccion` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `mision` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `internet` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `representante` int(11) DEFAULT NULL,
  `retencion` smallint(2) NOT NULL DEFAULT 1,
  `cierrecontable` date DEFAULT NULL,
  `capitalsocial` int(11) NOT NULL,
  `provincia` int(2) NOT NULL,
  `ciudad` int(2) NOT NULL,
  `parroquia` int(2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_compania` (`name`(30),`ruc`),
  KEY `coorporacion` (`idcorporacion`) USING BTREE,
  KEY `actividad` (`actividad`) USING BTREE COMMENT 'Actividades realizadas',
  CONSTRAINT `id_actividades` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`),
  CONSTRAINT `id_coorporacion` FOREIGN KEY (`idcorporacion`) REFERENCES `coorporacion` (`idcorporacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de las compañias de la cooporacion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `productos` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `val` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `short` (`short`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Variables de configuración del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `consola`
--

DROP TABLE IF EXISTS `consola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `consola` (
  `id` int(11) NOT NULL,
  `idservicio` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `dia` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `mes` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ano` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `turno` tinyint(1) NOT NULL,
  `tipo` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de horario de la consola';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_cedula` (`cedula`),
  KEY `idx_placa` (`placa`)
) ENGINE=InnoDB AUTO_INCREMENT=393 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `control`
--

DROP TABLE IF EXISTS `control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` int(11) NOT NULL DEFAULT 1,
  `idclient` int(11) DEFAULT NULL,
  `tipo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT '0' COMMENT 'Indica tipo de nomina que se genero Mensual, 1er. quinsena o 2da. quincena',
  `mes` smallint(2) NOT NULL,
  `ano` smallint(4) NOT NULL,
  `observacion` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('Generada','Firmada','Pagada','Anulada','Impreso','Modificada') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Control de la nomina';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coorporacion`
--

DROP TABLE IF EXISTS `coorporacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coorporacion` (
  `idcorporacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fax` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `internet` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `representante` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`idcorporacion`),
  UNIQUE KEY `nombre_corporacion` (`nombre`,`ruc`(11))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de las Coorporaciones';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamento` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(4) NOT NULL DEFAULT 1,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `is_caja` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `departamento` (`idcompany`,`name`) USING BTREE,
  KEY `company` (`idcompany`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Lista de departamentos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `descuento`
--

DROP TABLE IF EXISTS `descuento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `descuento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) DEFAULT NULL,
  `idperson` int(11) NOT NULL,
  `depart` varchar(2) DEFAULT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `monto` decimal(6,2) DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lista de los estados de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `despliegue`
--

DROP TABLE IF EXISTS `despliegue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `despliegue` (
  `id` int(11) NOT NULL,
  `idservicio` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `dia` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `mes` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ano` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `turno` tinyint(1) NOT NULL,
  `tipo` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de horario de los agentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documento`
--

DROP TABLE IF EXISTS `documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` int(11) NOT NULL,
  `tipo_documen` tinyint(1) NOT NULL DEFAULT 1,
  `idperson` int(11) NOT NULL,
  `responsable` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `idhorario` int(11) NOT NULL,
  `fecha_doc` date NOT NULL,
  `numero` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` enum('Falta Programada','Falta justificada y avisada','Falta injustificada','Falta en feriado o fiesta') NOT NULL,
  `turno` tinyint(1) NOT NULL DEFAULT 1,
  `motivo` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `comunico` tinyint(1) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL,
  `idpersona` int(11) NOT NULL,
  `respaldo` tinyint(1) NOT NULL DEFAULT 1,
  `documento` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cubierto_por` int(11) NOT NULL,
  `costo` decimal(6,2) NOT NULL DEFAULT 0.00,
  `quien` tinyint(1) NOT NULL DEFAULT 1,
  `pago` tinyint(1) NOT NULL DEFAULT 1,
  `firmo` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de documentos relacionados con el personal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entrada`
--

DROP TABLE IF EXISTS `entrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `monto` decimal(6,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de los servicios asignados';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomercial` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL DEFAULT 1,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `persona_contacto` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `lugar` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  `tipo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_Comercial` FOREIGN KEY (`id`) REFERENCES `comercial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de los eventos para comercial';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpadre` int(11) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gastos`
--

DROP TABLE IF EXISTS `gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT 2,
  `box_id` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `cash` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Registro de las diferentes asignaciones del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `IdGrupo` (`name`,`is_active`),
  KEY `FKCompany_idx` (`idcompany`),
  CONSTRAINT `FKCompany` FOREIGN KEY (`idcompany`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=COMPACT COMMENT='Grupos de Trabajo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `grupoperson`
--

DROP TABLE IF EXISTS `grupoperson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupoperson` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Relacion de las personas y grupo',
  `idgrupo` int(2) NOT NULL,
  `idperson` int(2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKGrupo_idx` (`idgrupo`),
  KEY `FKPerson_idx` (`idperson`),
  KEY `grupoperson` (`idgrupo`,`idperson`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=COMPACT COMMENT='Personas de un grupo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idservicio` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `dia` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `mes` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ano` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `turno` tinyint(1) NOT NULL,
  `tipo` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `LKPuesto` (`idservicio`,`idagente`),
  CONSTRAINT `FKAgente` FOREIGN KEY (`idservicio`) REFERENCES `person` (`id`),
  CONSTRAINT `FKPuesto` FOREIGN KEY (`idservicio`) REFERENCES `puestos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17810 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de horario de los agentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `informe`
--

DROP TABLE IF EXISTS `informe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `informe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `reportado` char(1) NOT NULL DEFAULT '0',
  `oficio` varchar(9) DEFAULT NULL,
  `lugar` varchar(120) DEFAULT NULL,
  `tipo_empresa` enum('Privado','Publico') NOT NULL DEFAULT 'Privado',
  `contacto` varchar(40) DEFAULT NULL,
  `padre` int(11) DEFAULT 0,
  `asunto` varchar(60) DEFAULT NULL,
  `objetivo` varchar(240) DEFAULT NULL,
  `ini_fec` date DEFAULT NULL,
  `conclusion` text DEFAULT NULL,
  `recomienda` text DEFAULT NULL,
  `anexos` text DEFAULT NULL,
  `status` enum('Borrador','Emitido','Impreso','') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKCliente` (`idcliente`),
  CONSTRAINT `FKCliente` FOREIGN KEY (`idcliente`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de los informes a los clientes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `informed`
--

DROP TABLE IF EXISTS `informed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `informed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idinforme` int(11) NOT NULL,
  `descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cantidad` tinyint(2) NOT NULL DEFAULT 0,
  `monto` decimal(6,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKInforme` (`idinforme`),
  CONSTRAINT `FKInforme` FOREIGN KEY (`idinforme`) REFERENCES `informe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de las informes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `localidad` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de localidades del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lote`
--

DROP TABLE IF EXISTS `lote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduct` int(10) NOT NULL,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `numero` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  `explira` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `inProducto` (`idproduct`),
  CONSTRAINT `fkProducto` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lote de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `residente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novedades`
--

DROP TABLE IF EXISTS `novedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `novedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `turno` enum('Diurno','Nocturno') NOT NULL,
  `observacion` varchar(240) DEFAULT NULL,
  `accion` varchar(120) DEFAULT NULL,
  `foto1` varchar(60) DEFAULT NULL,
  `foto2` varchar(60) DEFAULT NULL,
  `foto3` varchar(60) DEFAULT NULL,
  `foto4` varchar(60) DEFAULT NULL,
  `foto5` varchar(60) DEFAULT NULL,
  `foto6` varchar(60) DEFAULT NULL,
  `vistas` char(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de Novedades';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `numeracion`
--

DROP TABLE IF EXISTS `numeracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `numeracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` char(1) DEFAULT 'C' COMMENT 'Indica el tipo de documento de se enumera',
  `numero` smallint(4) NOT NULL,
  `ano` smallint(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Venta por cajas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ocr_resultados`
--

DROP TABLE IF EXISTS `ocr_resultados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ocr_resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `camera_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operation`
--

DROP TABLE IF EXISTS `operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `q` float DEFAULT NULL,
  `idpuesto` int(11) DEFAULT 0,
  `serial` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` enum('Nuevo','Usado','Deteriorado','Dañado') DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT NULL,
  `sell_id` int(11) DEFAULT NULL,
  `tipo` char(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `operation_type_id` (`operation_type_id`),
  KEY `sell_id` (`sell_id`),
  CONSTRAINT `FKEntregas` FOREIGN KEY (`sell_id`) REFERENCES `sell` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKProductos` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Registro de las asignaciones a cada agente';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operation_type`
--

DROP TABLE IF EXISTS `operation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `operation_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL DEFAULT 1,
  `idactividad` tinyint(2) NOT NULL DEFAULT 1,
  `padre` int(11) NOT NULL DEFAULT 0,
  `codigo` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `description` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `modulo` enum('Inventario','Categorias','Liquidaciones','Nomina','Medidas','Cotizaciones','Sanciones','General','Configuracion','Marcas','Armas','Colores','Estados','Comercial') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `actividadFK` (`idactividad`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Definicion de los tipos de operaciones';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(2) DEFAULT NULL,
  `idlocalidad` int(2) DEFAULT NULL COMMENT 'Incica que el agente fue ingresado por el supervisor',
  `idlugar` int(2) DEFAULT 1,
  `idcard` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `password` varchar(4) DEFAULT '1234',
  `estado_civil` tinyint(1) DEFAULT 1,
  `idcargo` int(2) NOT NULL DEFAULT 1,
  `tipo_contrato` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `extranjero` tinyint(1) DEFAULT 0,
  `image` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `phone1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `phone2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `phone3` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `genero` tinyint(1) NOT NULL DEFAULT 1,
  `conyuge` varchar(60) DEFAULT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `lugarnacimiento` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `demanda` tinyint(1) DEFAULT 0,
  `monto` double(10,2) DEFAULT 0.00,
  `hijos` tinyint(2) NOT NULL DEFAULT 0,
  `region` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT '2',
  `inscrito_curso` tinyint(1) NOT NULL DEFAULT 0,
  `termino_curso` tinyint(1) NOT NULL DEFAULT 0,
  `tiene_carnet` tinyint(1) NOT NULL DEFAULT 0,
  `carnet` varchar(60) DEFAULT NULL,
  `reentrenamiento` varchar(60) DEFAULT NULL,
  `copia_ministerio` tinyint(1) NOT NULL DEFAULT 0,
  `tiene_afis` tinyint(1) NOT NULL DEFAULT 0,
  `copia_afis` tinyint(1) NOT NULL DEFAULT 0,
  `premilitar` tinyint(1) NOT NULL DEFAULT 0,
  `militar` tinyint(1) NOT NULL DEFAULT 0,
  `carrera_militar` tinyint(1) NOT NULL DEFAULT 0,
  `copia_militar` tinyint(1) NOT NULL DEFAULT 0,
  `uso_arma` tinyint(1) NOT NULL DEFAULT 0,
  `nombre_curso` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `copia_curso` tinyint(1) NOT NULL DEFAULT 0,
  `licencia` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_licencia` tinyint(2) NOT NULL DEFAULT 0,
  `copia_licencia` int(1) NOT NULL DEFAULT 0,
  `bachiller` tinyint(1) NOT NULL DEFAULT 0,
  `especializacion1` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `esc_tecnico` tinyint(1) NOT NULL DEFAULT 0,
  `especializacion2` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `computadora` tinyint(1) NOT NULL DEFAULT 0,
  `celulartactil` tinyint(1) NOT NULL DEFAULT 0,
  `curso_realizado` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `certificados` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_sangre` tinyint(1) NOT NULL DEFAULT 1,
  `certificadosangre` tinyint(1) NOT NULL DEFAULT 0,
  `startwork` date DEFAULT NULL,
  `endwork` date DEFAULT NULL,
  `sueldo` decimal(8,2) DEFAULT NULL,
  `direccion` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `vivienda` varchar(60) DEFAULT NULL,
  `tipo_vivienda` tinyint(1) NOT NULL DEFAULT 2,
  `especifique` tinyint(1) DEFAULT 0,
  `croquis` tinyint(1) NOT NULL DEFAULT 0,
  `planilla` tinyint(1) NOT NULL DEFAULT 0,
  `contrato` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `kind` int(1) NOT NULL DEFAULT 1 COMMENT '(1. Empleado, 2. Aspirante, 3. Eventual)',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idcard` (`idcard`),
  KEY `FKCargos` (`idcargo`),
  CONSTRAINT `FKCargos` FOREIGN KEY (`idcargo`) REFERENCES `cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado del personal de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personas_contacto`
--

DROP TABLE IF EXISTS `personas_contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas_contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `etiquetas` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_cedula` (`cedula`),
  KEY `idx_placa` (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `persond`
--

DROP TABLE IF EXISTS `persond`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `persond` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idpuesto` int(11) DEFAULT NULL,
  `region` smallint(1) DEFAULT NULL,
  `tipo_despido` int(11) DEFAULT NULL,
  `tipo_contrato` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cargo` tinyint(2) NOT NULL DEFAULT 1,
  `hijos` tinyint(2) NOT NULL DEFAULT 0,
  `sueldo` decimal(6,2) NOT NULL DEFAULT 0.00,
  `hadicional` int(1) NOT NULL,
  `hnocturna` int(1) NOT NULL,
  `bono` decimal(6,2) NOT NULL DEFAULT 0.00,
  `recibo` tinyint(1) NOT NULL DEFAULT 0,
  `startwork` date DEFAULT NULL,
  `endwork` date DEFAULT NULL,
  `dias` smallint(3) NOT NULL DEFAULT 0,
  `tipo_pago` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'T',
  `acumula` tinyint(1) NOT NULL DEFAULT 0,
  `decimo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  `extencion` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT 'I',
  `idbanco` int(2) DEFAULT NULL,
  `tipo` int(1) DEFAULT 0,
  `cuenta` varchar(25) DEFAULT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `detallePerson` (`idperson`),
  KEY `FKBanco` (`idbanco`),
  CONSTRAINT `FKBanco` FOREIGN KEY (`idbanco`) REFERENCES `bancos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `persond_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado del personal de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personfm`
--

DROP TABLE IF EXISTS `personfm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personfm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `tipo_sangre` tinyint(1) NOT NULL DEFAULT 1,
  `certificadosangre` tinyint(1) NOT NULL DEFAULT 0,
  `peso` smallint(3) DEFAULT 0,
  `altura` smallint(3) DEFAULT 0,
  `tallacamisa` tinyint(2) DEFAULT NULL,
  `tallapantalon` tinyint(2) DEFAULT NULL,
  `tallazapato` tinyint(2) DEFAULT NULL,
  `se_ejercita` tinyint(1) NOT NULL DEFAULT 0,
  `cuantos_dias` tinyint(1) NOT NULL DEFAULT 0,
  `especifique_ejercicio` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `embarazada` tinyint(1) NOT NULL DEFAULT 0,
  `lentes` tinyint(1) NOT NULL DEFAULT 0,
  `sobrepeso` tinyint(1) NOT NULL DEFAULT 0,
  `presion_alta` tinyint(1) NOT NULL DEFAULT 0,
  `diabetes` tinyint(1) NOT NULL DEFAULT 0,
  `rinones` tinyint(1) NOT NULL DEFAULT 0,
  `colesterol` tinyint(1) NOT NULL DEFAULT 0,
  `higado` tinyint(1) NOT NULL DEFAULT 0,
  `alergico` tinyint(1) NOT NULL DEFAULT 0,
  `especifique_alergico` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `medicamento` tinyint(1) NOT NULL DEFAULT 0,
  `especifique_medicamento` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cirugia` tinyint(1) NOT NULL DEFAULT 0,
  `especifique_cirugia` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `protesis` tinyint(1) NOT NULL DEFAULT 0,
  `especifique_protesis` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `discapacidad` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_discapacidad` tinyint(1) NOT NULL DEFAULT 0,
  `conadis` tinyint(1) NOT NULL DEFAULT 0,
  `porcentaje` tinyint(2) NOT NULL DEFAULT 0,
  `copia_conadis` tinyint(1) NOT NULL DEFAULT 0,
  `kind` tinyint(2) NOT NULL DEFAULT 1,
  `tipo` tinyint(1) NOT NULL DEFAULT 1,
  `cuenta` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo_pago` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'T',
  `completo` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKFichaMedica` (`idperson`),
  CONSTRAINT `FKFichaMedica` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalles de la ficha medica del personal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personfoto`
--

DROP TABLE IF EXISTS `personfoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personfoto` (
  `id` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `latitude` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT NULL,
  `mensaje` varchar(80) DEFAULT NULL,
  `image` varchar(60) DEFAULT NULL,
  `cedula1` varchar(60) DEFAULT NULL,
  `cedula2` varchar(60) DEFAULT NULL,
  `votacion` varchar(60) DEFAULT NULL,
  `firma` varchar(60) DEFAULT NULL,
  `carpetas` varchar(60) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  KEY `FKFotos` (`idperson`),
  CONSTRAINT `FKFotos` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Fotos de los agentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personpuestos`
--

DROP TABLE IF EXISTS `personpuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personpuestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Relacion de los puestos y las personas',
  `idservicio` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `perdsonFK` (`idperson`),
  KEY `serviciosFK` (`idservicio`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Servicio por personas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plancuentas`
--

DROP TABLE IF EXISTS `plancuentas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `plancuentas` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo de la cuenta contable',
  `cuenta` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechavigencia` timestamp NOT NULL DEFAULT '2029-01-02 15:00:00',
  `nombre` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tabla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'BALANCE',
  `balance` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `orden` smallint(1) DEFAULT NULL,
  `imputable` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT 'N' COMMENT 'La cuenta es el minimo nivel del grupo',
  `saldoinicial` decimal(12,2) DEFAULT 0.00,
  `estado` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'A',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`idcuenta`),
  UNIQUE KEY `cuenta_contable` (`cuenta`,`fechavigencia`),
  KEY `cuenta` (`cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Plan de cuentas del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `grupo` tinyint(1) NOT NULL DEFAULT 1,
  `fase` varchar(30) NOT NULL,
  `pregunta` varchar(180) NOT NULL,
  `correcta` tinyint(1) DEFAULT 0,
  `nombre` varchar(20) DEFAULT NULL,
  `respuestA` varchar(180) DEFAULT NULL,
  `respuestB` varchar(180) DEFAULT NULL,
  `respuestC` varchar(180) DEFAULT NULL,
  `respuestD` varchar(220) DEFAULT NULL,
  `total` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `barcode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `inventary_min` int(11) DEFAULT 10,
  `price_in` float DEFAULT NULL,
  `price_out` float DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `presentation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `model` varchar(60) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  CONSTRAINT `FKCategorias` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL DEFAULT 1,
  `ruc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT 1,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `contacto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cargo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono1` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono2` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefonofac1` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefonofac2` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ruc` (`ruc`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de los clientes de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `puestos`
--

DROP TABLE IF EXISTS `puestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `puestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` smallint(2) DEFAULT 1 COMMENT 'Permite agrupar una serie de puestos de servicio ',
  `idcompany` int(11) NOT NULL DEFAULT 1,
  `idclient` int(11) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Se marcan las oficinas con 1 y los puestos con 2',
  `sucursal` smallint(1) NOT NULL,
  `residencial` tinyint(1) NOT NULL DEFAULT 0,
  `codigo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `activado` date DEFAULT NULL,
  `latitud` varchar(15) DEFAULT NULL,
  `longitud` varchar(15) DEFAULT NULL,
  `idlugar` int(2) NOT NULL DEFAULT 1,
  `horas` int(2) DEFAULT 0,
  `horario` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'HORAS',
  `lunes` tinyint(1) NOT NULL DEFAULT 0,
  `martes` tinyint(1) NOT NULL DEFAULT 0,
  `miercoles` tinyint(1) NOT NULL DEFAULT 0,
  `jueves` tinyint(1) NOT NULL DEFAULT 0,
  `viernes` tinyint(1) NOT NULL DEFAULT 0,
  `sabado` tinyint(1) NOT NULL DEFAULT 0,
  `domingo` tinyint(1) NOT NULL DEFAULT 0,
  `feriado` tinyint(1) NOT NULL DEFAULT 0,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `principal` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `clienteFK` (`idclient`),
  KEY `servicioFK` (`idlugar`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Oficinas de los clientes a la que se le brinda el servicio';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reacciones`
--

DROP TABLE IF EXISTS `reacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emoji` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `reaccion_unica` (`announcement_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reacciones_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reacciones_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `residente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recibo`
--

DROP TABLE IF EXISTS `recibo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `iddescuento` int(11) NOT NULL,
  `cuota` tinyint(2) NOT NULL DEFAULT 1,
  `monto` decimal(6,2) NOT NULL DEFAULT 0.00,
  `entregado` date DEFAULT NULL,
  `observacion` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lista de los descuentos realizados al personal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recibod`
--

DROP TABLE IF EXISTS `recibod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recibod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idrecibo` int(11) NOT NULL,
  `cuota` tinyint(2) NOT NULL,
  `monto` decimal(6,2) NOT NULL,
  `fecha` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKRecibos` (`idrecibo`),
  CONSTRAINT `FKRecibos` FOREIGN KEY (`idrecibo`) REFERENCES `recibo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Detalle de los descuentos generados al personal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `residente`
--

DROP TABLE IF EXISTS `residente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `residente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idclient` int(11) NOT NULL DEFAULT 1,
  `cedula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` enum('Visita','Taxi','Entrega','Otros') DEFAULT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `manzana` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `villa` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono1` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono2` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Cedulas` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de los residentes de la empresa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtimeline` int(11) NOT NULL,
  `iduser` int(11) NOT NULL DEFAULT 0,
  `descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Descripcion de las tareas pendientes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcard` varchar(10) DEFAULT NULL,
  `resp101` tinyint(1) DEFAULT NULL,
  `resp102` tinyint(1) DEFAULT NULL,
  `resp103` tinyint(1) DEFAULT NULL,
  `resp104` tinyint(1) DEFAULT NULL,
  `resp105` tinyint(1) DEFAULT NULL,
  `resp106` tinyint(1) DEFAULT NULL,
  `resp107` tinyint(1) DEFAULT NULL,
  `resp108` tinyint(1) DEFAULT NULL,
  `resp109` tinyint(1) DEFAULT NULL,
  `resp110` tinyint(1) DEFAULT NULL,
  `resp111` tinyint(1) DEFAULT NULL,
  `resp112` tinyint(1) DEFAULT NULL,
  `resp113` tinyint(1) DEFAULT NULL,
  `resp114` tinyint(1) DEFAULT NULL,
  `resp115` tinyint(1) DEFAULT NULL,
  `resp116` tinyint(1) DEFAULT NULL,
  `resp117` tinyint(1) DEFAULT NULL,
  `resp118` tinyint(1) DEFAULT NULL,
  `resp119` tinyint(1) DEFAULT NULL,
  `resp120` tinyint(1) DEFAULT NULL,
  `defi101` tinyint(1) DEFAULT NULL,
  `defi102` tinyint(1) DEFAULT NULL,
  `sisn101` tinyint(1) DEFAULT NULL,
  `sisn102` tinyint(1) DEFAULT NULL,
  `sisn103` tinyint(1) DEFAULT NULL,
  `sisn104` tinyint(1) DEFAULT NULL,
  `sisn105` tinyint(1) DEFAULT NULL,
  `sisn106` tinyint(1) DEFAULT NULL,
  `sisn107` tinyint(1) DEFAULT NULL,
  `sisn108` tinyint(1) DEFAULT NULL,
  `sisn109` tinyint(1) DEFAULT NULL,
  `sisn110` tinyint(1) DEFAULT NULL,
  `sisn111` tinyint(1) DEFAULT NULL,
  `sisn112` tinyint(1) DEFAULT NULL,
  `serie1` tinyint(1) DEFAULT NULL,
  `serie2` tinyint(1) DEFAULT NULL,
  `referencia1` varchar(60) DEFAULT NULL,
  `referencia2` varchar(60) DEFAULT NULL,
  `referencia3` varchar(60) DEFAULT NULL,
  `referencia4` varchar(60) DEFAULT NULL,
  `referencia5` varchar(60) DEFAULT NULL,
  `referencia6` varchar(60) DEFAULT NULL,
  `cono101` int(11) DEFAULT NULL,
  `cono102` int(11) DEFAULT NULL,
  `cono103` int(11) DEFAULT NULL,
  `cono104` int(11) DEFAULT NULL,
  `cono105` int(11) DEFAULT NULL,
  `cono106` int(11) DEFAULT NULL,
  `cono107` int(11) DEFAULT NULL,
  `cono108` int(11) DEFAULT NULL,
  `cono109` int(11) DEFAULT NULL,
  `cono110` int(11) DEFAULT NULL,
  `grupo1` decimal(4,2) NOT NULL,
  `grupo2` decimal(4,2) NOT NULL,
  `grupo3` decimal(4,2) NOT NULL,
  `grupo4` decimal(4,2) NOT NULL,
  `total` decimal(4,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(20) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKRespuestaPerson` (`idcard`),
  CONSTRAINT `FKRespuestaPerson` FOREIGN KEY (`idcard`) REFERENCES `person` (`idcard`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Indice de los roles del sistema',
  `fechavigencia` timestamp NOT NULL DEFAULT '2029-01-02 20:00:00',
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `alias` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idrol` (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Maestro de Rol';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rondas`
--

DROP TABLE IF EXISTS `rondas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rondas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `orden` smallint(2) NOT NULL DEFAULT 0,
  `latitude` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT NULL,
  `rangoerror` int(11) DEFAULT NULL,
  `sentido` int(11) DEFAULT NULL,
  `velocidad` int(11) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `control` char(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `RondaPuesto` (`idpuesto`,`orden`),
  CONSTRAINT `FKRondas` FOREIGN KEY (`idpuesto`) REFERENCES `puestos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de los puntos de Rondas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `salidas`
--

DROP TABLE IF EXISTS `salidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `salidas` (
  `id` int(11) NOT NULL,
  `idcotizacion` int(11) NOT NULL,
  `dato` int(11) NOT NULL DEFAULT 0,
  `idcard` varchar(13) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lista de los estados de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sell`
--

DROP TABLE IF EXISTS `sell`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `operation_type_id` int(11) DEFAULT 2,
  `box_id` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `cash` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `box_id` (`box_id`),
  KEY `operation_type_id` (`operation_type_id`),
  KEY `person_id` (`person_id`),
  KEY `sell_ibfk_3` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Registro de las diferentes asignaciones del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `seriales`
--

DROP TABLE IF EXISTS `seriales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `seriales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduct` int(11) NOT NULL,
  `description` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` enum('Nuevo','Usado','Dañado','Otros') DEFAULT NULL,
  `serial` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `numero` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `monto` float NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial` (`serial`) USING BTREE,
  KEY `id` (`id`),
  KEY `FKSeriales` (`idproduct`),
  CONSTRAINT `FKSeriales` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Listado de los seriales de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sueldos`
--

DROP TABLE IF EXISTS `sueldos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sueldos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ano` int(4) NOT NULL,
  `valor` float(7,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Maestro de Sueldos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timeline`
--

DROP TABLE IF EXISTS `timeline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `timeline` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idcompany` int(2) NOT NULL DEFAULT 1,
  `idclient` int(11) DEFAULT NULL,
  `idperson` int(11) DEFAULT NULL,
  `idejecuta` int(11) DEFAULT NULL,
  `consigna` int(1) DEFAULT 0,
  `quien_asigna` varchar(40) NOT NULL,
  `prioridad` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `resultado` char(1) DEFAULT NULL,
  `seguimiento` char(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `type` enum('image','news','milestone') NOT NULL DEFAULT 'news',
  `celular` varchar(10) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `asunto` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` text NOT NULL DEFAULT '',
  `body` text DEFAULT NULL,
  `date_event` datetime NOT NULL,
  `date_pass` datetime DEFAULT NULL,
  `date_autoriza` datetime DEFAULT NULL,
  `monto` decimal(8,2) DEFAULT NULL,
  `vistas` tinyint(2) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  KEY `FKTareas` (`idperson`),
  CONSTRAINT `FKTareas` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ROW_FORMAT=COMPACT COMMENT='Asignacion de Tareas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timelined`
--

DROP TABLE IF EXISTS `timelined`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `timelined` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtimeline` int(11) NOT NULL,
  `descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `iduser` int(11) NOT NULL DEFAULT 0,
  `fecha` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='SubTareas Pendientes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `toten`
--

DROP TABLE IF EXISTS `toten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `toten` (
  `id` int(11) NOT NULL,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `idresidente` int(11) DEFAULT NULL,
  `fecha` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tipo` enum('Visita','Taxi','Entrega','Otros') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `manzana` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `villa` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `observacion` text NOT NULL,
  `puerta` enum('Entrada','Salida') NOT NULL,
  `vistas` smallint(4) DEFAULT 0,
  `estado` char(1) DEFAULT '0',
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Visitas Residenciales';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trade`
--

DROP TABLE IF EXISTS `trade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `nacionalidad` int(1) DEFAULT 0,
  `cedula` varchar(10) DEFAULT NULL,
  `apellidos` varchar(60) DEFAULT NULL,
  `nombres` varchar(60) DEFAULT NULL,
  `empresa` int(2) DEFAULT 0,
  `oficina` varchar(10) DEFAULT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `acompanante1` varchar(10) DEFAULT NULL,
  `acompanante2` varchar(10) DEFAULT NULL,
  `acompanante3` varchar(10) DEFAULT NULL,
  `acompanante4` varchar(10) DEFAULT NULL,
  `timestamp` varchar(20) DEFAULT NULL,
  `latitude` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT NULL,
  `rangoerror` varchar(16) DEFAULT NULL,
  `sentido` varchar(16) DEFAULT NULL,
  `velocidad` varchar(16) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(40) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Visitas Del Trade Buildend';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` tinyint(2) NOT NULL DEFAULT 1,
  `idlocalidad` int(2) NOT NULL DEFAULT 1,
  `idperson` int(11) DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cambio` datetime DEFAULT NULL,
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `idrol` int(2) NOT NULL DEFAULT 1,
  `iddepartamento` int(2) NOT NULL DEFAULT 1,
  `ultima_session` datetime DEFAULT NULL,
  `ingresos` int(3) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`email`),
  KEY `usuario` (`idcompany`,`username`),
  KEY `FKRol` (`idrol`),
  KEY `FKLocalidad` (`idlocalidad`),
  KEY `FKPerson` (`idperson`),
  KEY `FKDepartamentos` (`iddepartamento`),
  CONSTRAINT `FKDepartamentos` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`id`),
  CONSTRAINT `FKLocalidad` FOREIGN KEY (`idlocalidad`) REFERENCES `localidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKPerson` FOREIGN KEY (`idperson`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKRol` FOREIGN KEY (`idrol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='Maestro de Usuarios del Sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ts` datetime NOT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `ua` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_login_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1562 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompany` int(11) NOT NULL,
  `producto` varchar(30) DEFAULT NULL,
  `margen` decimal(6,2) NOT NULL,
  `total` decimal(6,2) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Registro de las ventas registradas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visitantes`
--

DROP TABLE IF EXISTS `visitantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-TRAMITES, 2-VISITA, 3-ENTREGA, 4-OTROS',
  `nombre` varchar(60) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `observacion` varchar(120) DEFAULT NULL,
  `accion` varchar(120) DEFAULT NULL,
  `foto1` varchar(60) DEFAULT NULL,
  `foto2` varchar(60) DEFAULT NULL,
  `foto3` varchar(60) DEFAULT NULL,
  `foto4` varchar(60) DEFAULT NULL,
  `foto5` varchar(60) DEFAULT NULL,
  `foto6` varchar(60) DEFAULT NULL,
  `vistas` smallint(4) DEFAULT 0,
  `entrada` datetime DEFAULT NULL,
  `salida` datetime DEFAULT NULL,
  `timestamp` varchar(20) DEFAULT NULL,
  `latitude` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT NULL,
  `rangoerror` varchar(16) DEFAULT NULL,
  `sentido` varchar(16) DEFAULT NULL,
  `velocidad` varchar(16) DEFAULT NULL,
  `mensaje` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(40) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(30) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2960 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Control de Visitantes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visitas`
--

DROP TABLE IF EXISTS `visitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `idresidente` int(11) NOT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `proceso` enum('Ingreso','Observacion','Salida','Parte Informativo','Supervicion','Rondas') NOT NULL,
  `tipo` enum('Visita','Taxi','Entrega','Otros') DEFAULT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `puerta` enum('Entrada','Salida') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrada` datetime DEFAULT NULL,
  `salida` datetime DEFAULT NULL,
  `vistas` smallint(4) DEFAULT 0,
  `estado` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `update_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_log` varchar(15) NOT NULL DEFAULT 'ADMIN',
  `ip` varchar(20) NOT NULL DEFAULT 'LOCALHOST',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Control de Visitas';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-03-06 13:26:43
