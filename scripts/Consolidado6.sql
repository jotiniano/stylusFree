/*
SQLyog Enterprise - MySQL GUI v8.02 RC
MySQL - 5.5.27 : Database - spa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`spa` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `spa`;

/*Table structure for table `alerta` */

DROP TABLE IF EXISTS `alerta`;

CREATE TABLE `alerta` (
  `idAlerta` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoAlerta` int(11) DEFAULT NULL COMMENT '1 cumpleaños 2 mantenimiento de servicio',
  `atendido` int(1) DEFAULT NULL COMMENT '0 no atendido 1 atendido',
  PRIMARY KEY (`idAlerta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `alerta` */

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCliente` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellidoCliente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `fechaUltimaVisita` datetime DEFAULT NULL,
  `correo` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` char(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` char(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalVisitas` int(5) DEFAULT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL,
  `dni` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente` */

insert  into `cliente`(`idCliente`,`nombreCliente`,`apellidoCliente`,`fechaNacimiento`,`fechaUltimaVisita`,`correo`,`telefono`,`celular`,`estado`,`direccion`,`totalVisitas`,`idTipoUsuario`,`dni`) values (1,'cliente 1','apellidos 1','2013-02-20','2013-02-18 00:16:08','wwww@d.com','1234567876','123456787642',1,'los angeles mira 6576',1,4,'12345678'),(2,'cliente 2','apellidos 2','1995-07-12','2013-02-19 23:43:50','wwww@d.com','1234567876','123456787642',1,'los angeles mira 6576',1,4,'12345676'),(3,'cliente 3','apellido 3','2013-02-19','2013-02-19 23:51:39','wwww@d.com','3456789098','345678978643',1,'los angeles mira 6576',1,4,'67898765');

/*Table structure for table `detalleticket` */

DROP TABLE IF EXISTS `detalleticket`;

CREATE TABLE `detalleticket` (
  `idDetalleTicket` int(11) NOT NULL AUTO_INCREMENT,
  `idTicket` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `comision` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`idDetalleTicket`),
  KEY `FK_detalleticket` (`idTicket`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `detalleticket` */

insert  into `detalleticket`(`idDetalleTicket`,`idTicket`,`idProducto`,`precio`,`idUsuario`,`comision`) values (1,1,2,'60.00',9,NULL),(2,1,1,'35.00',9,NULL),(3,2,10,'160.00',13,NULL),(4,2,1,'35.00',11,NULL),(5,3,NULL,'17.96',0,'1.08'),(6,3,NULL,'35.00',9,'99.99'),(7,3,NULL,'18.82',0,'1.13'),(8,5,NULL,'17.96',0,'1.08'),(9,6,3,'25.04',0,'1.50');

/*Table structure for table `permiso` */

DROP TABLE IF EXISTS `permiso`;

CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPermiso`),
  KEY `FK_permiso` (`idUsuario`),
  CONSTRAINT `FK_permiso` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permiso` */

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenido` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `foto` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuarioRegistro` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `tipo` int(1) DEFAULT NULL,
  `apuntes` text COLLATE utf8_unicode_ci,
  `idTipoMoneda` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `producto` */

insert  into `producto`(`idProducto`,`nombreProducto`,`contenido`,`precio`,`fechaRegistro`,`foto`,`usuarioRegistro`,`estado`,`tipo`,`apuntes`,`idTipoMoneda`) values (1,'INOA','60 GR\r\n','17.96','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(2,'INOA OXIDANTE 20 VOL \r\n','1000ML\r\n','25.04','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(3,'INOA OXIDANTE 30 VOL \r\n','1000ML\r\n','25.04','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(4,'INOA SHAMPOOING\r\n','1500 ML\r\n','48.85','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(5,'MAJIREL ABSOLU\r\n','50 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(6,'MAJIBLOND ULTRA\r\n','51 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(7,'MAJIROUGE ABSOLU\r\n','50 GRS','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(8,'MAJIROUGE MIX + ABSOLU\r\n','25 GRS','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(9,'MAJICONTRAST ABSOLU\r\n','25 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(10,'MAJILIFT ABSOLU\r\n','50 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(11,'COLOR SUPREME \r\n','50 GRS\r\n','19.41','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(12,'RICHESSE\r\n','50 GRS\r\n','18.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(13,'HI RICHESSE\r\n','50 GRS\r\n','18.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(14,'DIA RICHESSE\r\n','50 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(15,'DIA LIGHT\r\n','50 GRS\r\n','18.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(16,'DIA ACTIVATEUR 6 VOL 1L\r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(17,'DIA ACTIVATEUR 9 VOL 1L \r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(18,'DIA ACTIVATEUR 15 VOL 1L\r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(19,'OXIDANTE LP 20VOL 75ML BR\r\n','75 ML\r\n','3.54','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(20,'REVELADOR DE 20 VOLUMENES\r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(21,'REVELADOR DE 30 VOLUMENES\r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(22,'REVELADOR DE 40 VOLUMENES\r\n','1000 ML\r\n','20.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(23,'REVELADOR HI.RICHESE 15 VOL MX 1000 ml\r\n','1000 ML\r\n','20.13','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(24,'REVELADOR RICHESSE 1000 ML\r\n','1000 ML\r\n','20.13','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(25,'OXIDANTE PLATINUM  20 VOLUMENES  1 LT\r\n','1000 ML\r\n','33.22','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(26,'OXIDANTE PLATINUM  30 VOLUMENES  1 LT\r\n','1000 ML\r\n','33.22','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(27,'OXIDANTE PLATINUM  40 VOLUMENES  1 LT\r\n','1000 ML\r\n','33.22','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(28,'MAJIMECHES DOUBLE CREME\r\n','3 tub + 6 sach\r\n','51.84','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(29,'PLATIFIZ PRECISION\r\n','500 GRS\r\n','100.64','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(30,'PLATINIUM PLUS\r\n','500 GRS\r\n','154.99','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(31,'FIJADOR DULCIA TONICA 1000\r\n','1000 ML\r\n','36.11','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(32,'DULCIA AHA 0 FR\r\n','250 ML\r\n','28.89','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(33,'DULCIA AHA 1 FR\r\n','250 ML\r\n','28.89','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(34,'DULCIA AHA 2 FR\r\n','250 ML\r\n','28.89','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(35,'DULCIA AHA 3 FR\r\n','250 ML\r\n','28.89','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(36,'XTENSO MOISTURE CAB. COLORIDOS 200ML\r\n','200 ML\r\n','52.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(37,'XTENSO MOISTURE CAB. NATURAIS 200ML\r\n','200 ML\r\n','52.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(38,'XTENSO MOISTURE CAB. NAT. RES. 200ML\r\n','200 ML\r\n','52.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(39,'XTENSO MOISTURE CAB.SENS.MECHAS 200ML\r\n','200 ML\r\n','52.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(40,'XTENSO MOISTURE NEUTRALIZADOR 950ML\r\n','950 ML\r\n','58.78','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(41,'XTENSO OPTIMAL SHAMPOO 300ML\r\n','300 ML\r\n','39.62','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(42,'XTENSO OPTIMAL SHAMPOO 1500ML\r\n','1500 ML\r\n','114.93','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(43,'XTENSO CREMA C/ENJ DAILY CARE 250ML     \r\n','250 ML\r\n','39.62','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(44,'CONDITIONER DAILY CARE 1500 ML          \r\n','1500 ML\r\n','103.50','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(45,'XTENSO CREMA PARA PEINAR 250ML\r\n','250 ML\r\n','39.62','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(46,'SÉRUM X-TENSO CARE\r\n','50 ML \r\n','48.83','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(47,'XTENSO INTENSE MASQUE 500ML\r\n','500 ML\r\n','100.81','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(48,'SH VIT COLOR 250 RENOVACION\r\n','250ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(49,'SH VIT COLOR 500 RENOVACION\r\n','500 ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(50,'SH VIT COLOR 1500 RENOVACION\r\n','1,500 ML\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(51,'SE VITA COLOR CAPTIVE S/ENJ 150 ML','150ML\r\n','34.28','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(52,'SE VITA COLOR CUIDADO 150 ML\r\n','150\r\n','34.28','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(53,'SE VITA COLOR CUIDADO 750 ML\r\n','750\r\n','97.90','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(54,'SE VITA COLOR MASQUE 200 ML\r\n','200\r\n','43.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(55,'SE VITA COLOR MASQUE 500 ML\r\n','500\r\n','90.33','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(56,'SE VITA COLOR SH SIN SULFATO 250\r\n','250\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(57,'SE VITA COLOR SH SIN SULFATO 500\r\n','500\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(58,'SE VITA COLOR SH SIN SULFATO 1500\r\n','1500\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(59,'SHAMPOO LUMINO CONTRAST\r\n','250ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(60,'SHAMPOO LUMINO CONTRAST\r\n','500ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(61,'SHAMPOO LUMINO CONTRAST\r\n','1500ML\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(62,'MÁSCARA LUMINO CONTRAST\r\n','200ML\r\n','43.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(63,'MÁSCARA LUMINO CONTRAST\r\n','500ML\r\n','90.33','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(64,'SERUM LUMINO CONTRAST\r\n','50ML\r\n','42.07','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(65,'SE ABS CELLULAR SH 250ML\r\n','250ML\r\n','33.10','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(66,'SE ABS CELLULAR SH 500ML\r\n','500ML\r\n','59.37','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(67,'SE ABS CELLULAR SH 1500ML               \r\n','1500ML\r\n','116.54','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(68,'SE ABS CELLULAR CLEANSING BALM\r\n','250 ML\r\n','42.59','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(69,'SE ABS CELLULAR CREMA C/ENJ 150ML       \r\n','150ML\r\n','34.80','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(70,'SE ABS CELLULAR CREMA C/ENJ 750ML       \r\n','750 ML\r\n','99.84','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(71,'SE ABS CELLULAR MASK 200ML\r\n','200ML\r\n','43.86','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(72,'SE ABS CELLULAR MASK 500ML              \r\n','500ML\r\n','92.13','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(73,'SE ABS CELLULAR NO RINSE 150ML          \r\n','150ML\r\n','34.80','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(74,'SE ABS CELLUL RENEW C 15*12ML\r\n','15*12\r\n','179.50','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(75,'SE ABS CEL THERMO REPAIR 150ML\r\n','150ML\r\n','43.80','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(76,'SE ABS CELLULAR SERUM 50ML\r\n','50\r\n','42.07','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(77,'SE SH FORCE VECTOR  250ML\r\n','250ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(78,'SE FORCE VECTOR SH 500ML V1\r\n','500ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(79,'SE SH FORCE VECTOR 1500 ML\r\n','1500ML\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(80,'SE MASC FORCE VECTOR 200 ML\r\n','200ML\r\n','43.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(81,'SE MASC FORCE VECTOR 500 ML\r\n','500ML\r\n','90.33','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(82,'SE CR SE FORCE VECTOR 150 ML\r\n','150ML\r\n','34.28','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(83,'SE CR CE FORCE VECTOR 150 ML\r\n','150ML\r\n','34.28','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(84,'SE FORCE VECTOR AMP 15X15\r\n','15x15 ML\r\n','163.12','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(85,'LISS ULTIME SHAMPOO 250 ML\r\n','250 ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(86,'LISS ULTIME SHAMPOO 500ML\r\n','500 ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(87,'LISS ULTIME SHAMPOO 1500ML\r\n','1500 ML\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(88,'LISS ULTIME CREMA S/ENJ. 150ML\r\n','150 ML\r\n','32.62','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(89,'LISS ULTIME MASCARA 200 ML\r\n','200 ML\r\n','43.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(90,'LISS ULTIME MASCARA 500 ML\r\n','500 ML\r\n','90.33','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(91,'LISS ULTIME HUILE 50 ML\r\n','50 ML\r\n','42.07','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(92,'LISS ULTIME SERUM FLUIDO 125 ML\r\n','125 ML\r\n','43.54','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(93,'LISS ULTIME SOIN DE NUIT 125 ML\r\n','125 ML\r\n','43.19','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(94,'LISS ULTIME POWERDEFINE 15X15 ML\r\n','15ML\r\n','135.94','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(95,'SHAMPOO SILVER SE 250 ML\r\n','250ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(96,'PURE RESSOURCE SH. PET 500 ML\r\n','500 ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(97,'INSTANT CLEAR SH. PET 500 ML\r\n','500 ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(98,'SENSI BALANCE SH. PET500 ML\r\n','500 ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(99,'POWER DOSE CONTRAST (cabellos con mechas) x 30\r\n','30*10\r\n','346.77','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(100,'SE ABSOLUT POWERCELL 30*10ML\r\n','30*10\r\n','346.77','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(101,'SE VITA COLOR POWERDOSE 30*10\r\n','30*10\r\n','346.77','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(102,'SE AGE SUPREME SH 250ML V315            \r\n','250ML\r\n','32.45','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(103,'SE AGE SUPREME SH 500ML V511            \r\n','500ML\r\n','58.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(104,'SE AGE SUPREME SH 1500ML V034           \r\n','1500ML\r\n','114.25','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(105,'SE AGE SUPREME MASQUE 200ML V315        \r\n','200ML\r\n','43.21','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(106,'SE AGE SUPREME MASQUE 500ML V034        \r\n','500ML\r\n','90.33','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(107,'TNA IRON LISS 150 ML\r\n','150 ML\r\n','38.11','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(108,'TNA IRON FINISH 150ML \r\n','150 ML\r\n','38.11','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(109,'TNA LISS CONTROL + 50 ML NEW\r\n','50 ML\r\n','37.94','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(110,'TNA LISS CONTROL 150 ML. NEW\r\n','150 ML\r\n','31.86','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(111,'TNA FIX MAX NEW 200ML V1\r\n','200 ML\r\n','39.73','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(112,'TNA FIX MOVE 100 ML V1\r\n','100 ML\r\n','35.55','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(113,'TNA AIR FIX ANTIFRIZZ NEW\r\n','250 ML\r\n','39.78','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(114,'TNA FULL VOLUME EXTRA 250ML NEW\r\n','250 ML\r\n','31.54','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(115,'A HEAD WEB 150ML NEW\r\n','150 ML\r\n','32.79','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(116,'TNIART A-HEAD V1GLUE 150 ML\r\n','150 ML\r\n','32.79','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(117,'TNA HAIR MIX FANTASTIC FIX\r\n','400 ML\r\n','32.79','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(118,'TNA HAIRMIX SPIRAL SPLEND 150 ML\r\n','150 ML\r\n','35.57','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(119,'TNA HAIRMIX SUPREME SMOOTH 200 ml\r\n','200 ML\r\n','35.57','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(120,'TNA HAIRMIX FAB\'FINISH 250ML VM\r\n','250 ML\r\n','39.78','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(121,'TNA HAIRMIX SUBLIME SHINE 125 ML \r\n','125 ML\r\n','35.57','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(122,'SNATURE RENAITRE SOURCE 250 ML V41\r\n','250ML\r\n','31.20','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(123,'SNATURE RENAITRE SOURCE 1500 ML VM\r\n','1500ML\r\n','110.39','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(124,'SNATURE RENAITRE MASQUE 200ML V41\r\n','200ML\r\n','41.75','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(125,'SNATURE RENAITRE MASQUE 500ML U2\r\n','500ML\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(126,'SNATURE OILISS SOURCE 250ML  V41\r\n','250ML\r\n','31.20','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(127,'SNATURE OILISS SOURCE 1500ML  VM\r\n','1500ML\r\n','110.39','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(128,'SNATURE OILISS MASQUE 200ML V41\r\n','200ML\r\n','41.75','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(129,'SNATURE OILISS MASQUE 500ML U2\r\n','500ML\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(130,'SNATURE OILISS SPRAY 125 ML V41\r\n','125 ML\r\n','42.07','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(131,'SNATURE RICHESSE SOURCE 250ML V41\r\n','250ML\r\n','31.20','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(132,'SNATURE RICHESSE SOURCE 500ML V41\r\n','500ML\r\n','56.24','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(133,'SNATURE RICHESSE MASK 200ML V41\r\n','200ML\r\n','41.75','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(134,'SNATURE RICHESSE MASK 500ML U2\r\n','500ML\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(135,'SNATURE DOUCEUR SH 250 ML\r\n','250 ML\r\n','31.20','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(136,'SNATURE DOUCEUR 1500ML VM\r\n','1500\r\n','110.39','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(137,'SNATURE DOUCEUR MASQUE 200 ML\r\n','200\r\n','41.75','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(138,'SNATURE DOUCEUR MASQUE 500ML U2\r\n','500\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(139,'SN TENDRESSE SOURCE 250 ML\r\n','250\r\n','23.86','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(140,'SNATURE TENDRESSE CREMA 150 ML\r\n','150\r\n','27.08','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(141,'MYTHIC OIL 125ML V272                   \r\n','125 ML\r\n','57.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(142,'MYTHIC OIL STRENGHT MILK 125ML          ','125 ML\r\n','41.30','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(143,'MYTHIC OIL RICH OIL 125ML V272          \r\n','125 ML\r\n','57.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(144,'MYTHIC OIL COLOR GLOW OIL 125ML         \r\n','125 ML\r\n','57.82','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(145,'SE FIBERCEUTIC MASQUE 500ML\r\n','500 ML\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(146,'SE FIBER SOIN A RINCER 500ML\r\n','500 ML\r\n','87.27','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(147,'SE FIBER POWERDOSE 15*15ML              \r\n','15 ML\r\n','173.44','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(148,'INOA CARE SHAMP 250ML V511\r\n','250ML\r\n','34.22','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(149,'INOA CARE COND 150ML V511\r\n','150ML\r\n','37.17','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(150,'INOA CARE MASQUE 200ML V511             \r\n','200ML\r\n','45.18','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(151,'INOA CARE SHAMP 1500ML\r\n','1500ML\r\n','120.03','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(152,'INOA CARE COND 500ML\r\n','500ML\r\n','66.55','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(153,'INOA CARE MASQUE 500ML\r\n','500ML\r\n','94.90','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(154,'POTIONIZER DRY/COLOURED 250ML V272      \r\n','250ML\r\n','59.00','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(155,'POTIONIZER FINE HAIR 250ML              \r\n','250ML\r\n','59.00','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(156,'POTIONIZER FINE HAIR 400ML V034         \r\n','400ML\r\n','66.67','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(157,'POTIONIZER DRY/COLOURED 400ML V034      \r\n','400ML\r\n','66.67','2013-02-17 13:48:52',NULL,1,1,1,NULL,1),(158,'Manicure Opi',NULL,'35.00','2013-02-17 13:48:52',NULL,1,1,2,'dddd',1),(159,'Manicure Spa\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(160,'Manicure gel color\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(161,'Cambio de esmalte\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(162,'Parafina\r\n',NULL,'10.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(163,'Manos niñas\r\n',NULL,'10.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(164,'Diseño de uñas niñas\r\n',NULL,'5.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(165,'Diseño de uñas adulto\r\n',NULL,'10.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(166,'Baño de color shade\r\n',NULL,'160.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(167,'Tinte completo Redken\r\n',NULL,'160.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(168,'Tinte completo loreal\r\n',NULL,'140.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(169,'Retoque de raices Redken\r\n',NULL,'90.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(170,'Retoque de raices Loreal\r\n',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(171,'Retoque de mechas\r\n',NULL,'190.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(172,'Iluminación\r\n',NULL,'150.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(173,'Aplicación de tinte\r\n',NULL,'190.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(174,'Pedicure Opi\r\n',NULL,'50.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(175,'Pedicure Spa\r\n',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(176,'Pedicure gel color\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(177,'Cambio de esmalte pies\r\n',NULL,'12.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(178,'Parafina pies\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(179,'Pies niñas\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(180,'Maquillaje Novia Trucco\r\n',NULL,'150.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(181,'Maquillaje de ojos Trucco\r\n',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(182,'Maquillaje completo Trucco\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(183,'Maquillaje de quinceañera Trucco\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(184,'Maquillaje de promocion\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(185,'Acrilico natural esculpida\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(186,'Acrilico francesa esculpida\r\n',NULL,'110.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(187,'retiro de uñas\r\n',NULL,'70.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(188,'Retoque acrilico natural\r\n',NULL,'70.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(189,'Retoque acrilico francesa\r\n',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(190,'Una uña acrilica\r\n',NULL,'10.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(191,'Corte de caballero\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(192,'Corte dama\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(193,'Corte niño\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(194,'Corte de cerquillo\r\n',NULL,'15.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(195,'Cepillado desde\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(196,'Planchado\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(197,'Peinado\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(198,'Trenzas\r\n',NULL,'45.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(199,'Moños\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(200,'Lavado de cabello\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(201,'Laciado con Keratina\r\n',NULL,'700.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(202,'Facial española\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(203,'Tatuaje de cejas\r\n',NULL,'210.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(204,'Tatuaje de labios\r\n',NULL,'200.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(205,'Tatuaje parpados superior\r\n',NULL,'200.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(206,'Tatuaje parpado inferior\r\n',NULL,'200.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(207,'Decoloración pierna\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(208,'Decoloración media pierna\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(209,'Decoloración brazo\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(210,'Decoloración medio brazo\r\n',NULL,'20.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(211,'Depilación cejas\r\n',NULL,'25.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(212,'Depilación Axilas\r\n',NULL,'25.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(213,'Depilación brazilera completa\r\n',NULL,'50.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(214,'Depilación Bikini\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(215,'Depilación media pierna\r\n',NULL,'40.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(216,'Depilación pierna completa\r\n',NULL,'70.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(217,'Depilación patilla\r\n',NULL,'25.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(218,'Depilación barriga\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(219,'Depilación espalda\r\n',NULL,'30.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(220,'Depilación de frente\r\n',NULL,'25.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(221,'Depilación ombligo\r\n',NULL,'10.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(222,'Depilación de rostro\r\n',NULL,'70.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(223,'Depilación de menton\r\n',NULL,'25.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(224,'Depilación de brazo completo\r\n',NULL,'50.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(225,'Depilación de medio brazo\r\n',NULL,'40.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(226,'Tratamiento Mascarilla Loreal\r\n',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(227,'Tratamiento Loreal Liss Ultime\r\n',NULL,'90.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(228,'Tratamiento Renw C Loreal\r\n',NULL,'140.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(229,'Tratamiento Redken 5.05\r\n',NULL,'160.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(230,'Tratamiento Redken Kemestry\r\n',NULL,'240.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(231,'Ampolla Loreal\r\n',NULL,'35.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(232,'Ampolla Redken\r\n',NULL,'35.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(233,'Pestaás 1x1\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(234,'Extensiones de pestañas\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(235,'Rizado de pestañas\r\n',NULL,'60.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(236,'Sauna\r\n',NULL,'50.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(237,'Circuito spa\r\n',NULL,'100.00','2013-02-17 13:48:52',NULL,1,1,2,NULL,1),(238,'Masajes Relajante',NULL,'80.00','2013-02-17 13:48:52',NULL,1,1,2,'ddd',1),(244,'dos',NULL,'30.00','2013-03-04 01:19:12',NULL,1,0,2,'sss',1),(245,'dos',NULL,'30.00','2013-03-04 01:23:23',NULL,1,0,2,'ddd',1),(246,'uno',NULL,'30.00','2013-03-04 01:23:42',NULL,1,0,1,NULL,NULL);

/*Table structure for table `prueba` */

DROP TABLE IF EXISTS `prueba`;

CREATE TABLE `prueba` (
  `idprueba` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idprueba`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `prueba` */

/*Table structure for table `reserva` */

DROP TABLE IF EXISTS `reserva`;

CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `idEstilista` int(11) DEFAULT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `FK_reserva` (`idCliente`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `reserva` */

insert  into `reserva`(`idReserva`,`idCliente`,`idUsuario`,`fechaInicio`,`fechaFin`,`descripcion`,`estado`,`fechaRegistro`,`idEstilista`) values (1,1,1,'2013-03-09 10:00:00','2013-03-09 11:00:00','ktktftkfkyugylyliububibuibuibui',1,'2013-02-18 00:22:19',NULL),(2,1,1,'2013-02-20 11:00:00','2013-02-20 12:00:00','kihkhj',1,'2013-02-20 00:54:21',NULL),(3,1,1,'2013-02-21 10:00:00','2013-02-21 11:00:00','khuhjn',1,'2013-02-20 00:54:56',NULL),(4,3,1,'2013-03-07 00:00:00','2013-03-07 02:00:00','lala',1,'2013-03-06 21:44:19',9);

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionServicio` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `idTipoMoneda` int(1) DEFAULT NULL COMMENT '1 soles 2 dolares',
  `estado` int(1) DEFAULT NULL,
  `apuntes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `servicio` */

insert  into `servicio`(`idServicio`,`descripcionServicio`,`precio`,`fechaRegistro`,`idTipoMoneda`,`estado`,`apuntes`) values (1,'Manicure Opi\r\n','35.00','2013-02-17 14:03:41',1,1,NULL),(2,'Manicure Spa\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(3,'Manicure gel color\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(4,'Cambio de esmalte\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(5,'Parafina\r\n','10.00','2013-02-17 14:03:41',1,1,NULL),(6,'Manos niñas\r\n','10.00','2013-02-17 14:03:41',1,1,NULL),(7,'Diseño de uñas niñas\r\n','5.00','2013-02-17 14:03:41',1,1,NULL),(8,'Diseño de uñas adulto\r\n','10.00','2013-02-17 14:03:41',1,1,NULL),(9,'Baño de color shade\r\n','160.00','2013-02-17 14:03:41',1,1,NULL),(10,'Tinte completo Redken\r\n','160.00','2013-02-17 14:03:41',1,1,NULL),(11,'Tinte completo loreal\r\n','140.00','2013-02-17 14:03:41',1,1,NULL),(12,'Retoque de raices Redken\r\n','90.00','2013-02-17 14:03:41',1,1,NULL),(13,'Retoque de raices Loreal\r\n','80.00','2013-02-17 14:03:41',1,1,NULL),(14,'Retoque de mechas\r\n','190.00','2013-02-17 14:03:41',1,1,NULL),(15,'Iluminación\r\n','150.00','2013-02-17 14:03:41',1,1,NULL),(16,'Aplicación de tinte\r\n','190.00','2013-02-17 14:03:41',1,1,NULL),(17,'Pedicure Opi\r\n','50.00','2013-02-17 14:03:41',1,1,NULL),(18,'Pedicure Spa\r\n','80.00','2013-02-17 14:03:41',1,1,NULL),(19,'Pedicure gel color\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(20,'Cambio de esmalte pies\r\n','12.00','2013-02-17 14:03:41',1,1,NULL),(21,'Parafina pies\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(22,'Pies niñas\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(23,'Maquillaje Novia Trucco\r\n','150.00','2013-02-17 14:03:41',1,1,NULL),(24,'Maquillaje de ojos Trucco\r\n','80.00','2013-02-17 14:03:41',1,1,NULL),(25,'Maquillaje completo Trucco\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(26,'Maquillaje de quinceañera Trucco\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(27,'Maquillaje de promocion\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(28,'Acrilico natural esculpida\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(29,'Acrilico francesa esculpida\r\n','110.00','2013-02-17 14:03:41',1,1,NULL),(30,'retiro de uñas\r\n','70.00','2013-02-17 14:03:41',1,1,NULL),(31,'Retoque acrilico natural\r\n','70.00','2013-02-17 14:03:41',1,1,NULL),(32,'Retoque acrilico francesa\r\n','80.00','2013-02-17 14:03:41',1,1,NULL),(33,'Una uña acrilica\r\n','10.00','2013-02-17 14:03:41',1,1,NULL),(34,'Corte de caballero\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(35,'Corte dama\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(36,'Corte niño\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(37,'Corte de cerquillo\r\n','15.00','2013-02-17 14:03:41',1,1,NULL),(38,'Cepillado desde\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(39,'Planchado\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(40,'Peinado\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(41,'Trenzas\r\n','45.00','2013-02-17 14:03:41',1,1,NULL),(42,'Moños\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(43,'Lavado de cabello\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(44,'Laciado con Keratina\r\n','700.00','2013-02-17 14:03:41',1,1,NULL),(45,'Facial española\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(46,'Tatuaje de cejas\r\n','210.00','2013-02-17 14:03:41',1,1,NULL),(47,'Tatuaje de labios\r\n','200.00','2013-02-17 14:03:41',1,1,NULL),(48,'Tatuaje parpados superior\r\n','200.00','2013-02-17 14:03:41',1,1,NULL),(49,'Tatuaje parpado inferior\r\n','200.00','2013-02-17 14:03:41',1,1,NULL),(50,'Decoloración pierna\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(51,'Decoloración media pierna\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(52,'Decoloración brazo\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(53,'Decoloración medio brazo\r\n','20.00','2013-02-17 14:03:41',1,1,NULL),(54,'Depilación cejas\r\n','25.00','2013-02-17 14:03:41',1,1,NULL),(55,'Depilación Axilas\r\n','25.00','2013-02-17 14:03:41',1,1,NULL),(56,'Depilación brazilera completa\r\n','50.00','2013-02-17 14:03:41',1,1,NULL),(57,'Depilación Bikini\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(58,'Depilación media pierna\r\n','40.00','2013-02-17 14:03:41',1,1,NULL),(59,'Depilación pierna completa\r\n','70.00','2013-02-17 14:03:41',1,1,NULL),(60,'Depilación patilla\r\n','25.00','2013-02-17 14:03:41',1,1,NULL),(61,'Depilación barriga\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(62,'Depilación espalda\r\n','30.00','2013-02-17 14:03:41',1,1,NULL),(63,'Depilación de frente\r\n','25.00','2013-02-17 14:03:41',1,1,NULL),(64,'Depilación ombligo\r\n','10.00','2013-02-17 14:03:41',1,1,NULL),(65,'Depilación de rostro\r\n','70.00','2013-02-17 14:03:41',1,1,NULL),(66,'Depilación de menton\r\n','25.00','2013-02-17 14:03:41',1,1,NULL),(67,'Depilación de brazo completo\r\n','50.00','2013-02-17 14:03:41',1,1,NULL),(68,'Depilación de medio brazo\r\n','40.00','2013-02-17 14:03:41',1,1,NULL),(69,'Tratamiento Mascarilla Loreal\r\n','80.00','2013-02-17 14:03:41',1,1,NULL),(70,'Tratamiento Loreal Liss Ultime\r\n','90.00','2013-02-17 14:03:41',1,1,NULL),(71,'Tratamiento Renw C Loreal\r\n','140.00','2013-02-17 14:03:41',1,1,NULL),(72,'Tratamiento Redken 5.05\r\n','160.00','2013-02-17 14:03:41',1,1,NULL),(73,'Tratamiento Redken Kemestry\r\n','240.00','2013-02-17 14:03:41',1,1,NULL),(74,'Ampolla Loreal\r\n','35.00','2013-02-17 14:03:41',1,1,NULL),(75,'Ampolla Redken\r\n','35.00','2013-02-17 14:03:41',1,1,NULL),(76,'Pestaás 1x1\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(77,'Extensiones de pestañas\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(78,'Rizado de pestañas\r\n','60.00','2013-02-17 14:03:41',1,1,NULL),(79,'Sauna\r\n','50.00','2013-02-17 14:03:41',1,1,NULL),(80,'Circuito spa\r\n','100.00','2013-02-17 14:03:41',1,1,NULL),(81,'Masajes Relajante\r\n','80.00','2013-02-17 14:03:41',1,1,NULL);

/*Table structure for table `ticket` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket` (
  `idTicket` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `visa` decimal(10,2) DEFAULT '0.00',
  `mastercard` decimal(10,2) DEFAULT '0.00',
  `efectivo` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`idTicket`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ticket` */

insert  into `ticket`(`idTicket`,`idUsuario`,`fechaCreacion`,`idCliente`,`total`,`visa`,`mastercard`,`efectivo`) values (1,1,'2013-02-25 10:36:34',1,'95.00','0.00','0.00','0.00'),(2,14,'2013-02-25 10:41:27',2,'195.00','0.00','0.00','0.00'),(3,1,'2013-03-06 23:10:35',0,'71.78','50.00','21.78','0.00'),(5,1,'2013-03-06 23:13:29',3,'17.96','10.00','7.00','0.96'),(6,1,'2013-03-06 23:15:04',3,'25.04','20.00','5.00','0.04');

/*Table structure for table `tipousuario` */

DROP TABLE IF EXISTS `tipousuario`;

CREATE TABLE `tipousuario` (
  `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tipousuario` */

insert  into `tipousuario`(`idTipoUsuario`,`descripcion`) values (1,'Admin'),(2,'Counter'),(3,'Estilista'),(4,'Cliente');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(40) DEFAULT NULL,
  `apellidoUsuario` varchar(70) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(15) DEFAULT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `FK_usuario` (`idTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */

insert  into `usuario`(`idUsuario`,`nombreUsuario`,`apellidoUsuario`,`fechaRegistro`,`usuario`,`clave`,`idTipoUsuario`,`estado`) values (1,'Steve','Villano Esteban','2013-02-11 23:44:50','jsteve','123456',1,1),(9,'Stefany','robles rosales','2013-02-18 01:46:57','stefy','123456',3,1),(10,'karina','peña roldan','2013-02-18 12:13:00','karina',NULL,3,1),(11,'carmen','segura rivas','2013-02-19 19:15:51','carmen',NULL,3,1),(12,'Liliana','Robles Martinz','2013-02-19 21:54:19','liliana',NULL,3,1),(13,'Andrea','lico sent','2013-02-19 22:07:42','andrea',NULL,3,1),(14,'Counter 1','apellido counter 1','2013-02-25 10:39:06','counter1','123456',2,1);

/*Table structure for table `usuarioservicio` */

DROP TABLE IF EXISTS `usuarioservicio`;

CREATE TABLE `usuarioservicio` (
  `idUsuarioServicio` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `idServicio` int(11) DEFAULT NULL,
  `comision` float(10,2) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsuarioServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuarioservicio` */

insert  into `usuarioservicio`(`idUsuarioServicio`,`idUsuario`,`idServicio`,`comision`,`fechaRegistro`) values (1,9,158,10.00,'2013-03-04 02:19:57'),(2,10,238,5.00,'2013-03-04 02:40:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
