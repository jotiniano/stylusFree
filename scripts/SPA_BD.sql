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
  `IdCliente` int(11) DEFAULT NULL,
  `atendido` int(1) DEFAULT NULL COMMENT '0 no atendido 1 atendido',
  PRIMARY KEY (`idAlerta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `alerta` */

LOCK TABLES `alerta` WRITE;

UNLOCK TABLES;

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCliente` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellidoCliente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaNacimiento` datetime DEFAULT NULL,
  `correo` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` int(12) DEFAULT NULL,
  `celular` int(12) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cliente` */

LOCK TABLES `cliente` WRITE;

UNLOCK TABLES;

/*Table structure for table `detalleticket` */

DROP TABLE IF EXISTS `detalleticket`;

CREATE TABLE `detalleticket` (
  `idDetalleTicket` int(11) NOT NULL AUTO_INCREMENT,
  `idTicket` int(11) DEFAULT NULL,
  `idServicio` int(11) DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`idDetalleTicket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `detalleticket` */

LOCK TABLES `detalleticket` WRITE;

UNLOCK TABLES;

/*Table structure for table `permiso` */

DROP TABLE IF EXISTS `permiso`;

CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permiso` */

LOCK TABLES `permiso` WRITE;

UNLOCK TABLES;

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `foto` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuarioRegistro` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `producto` */

LOCK TABLES `producto` WRITE;

UNLOCK TABLES;

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionServicio` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `idTipoMoneda` int(1) DEFAULT NULL COMMENT '1 soles 2 dolares',
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `servicio` */

LOCK TABLES `servicio` WRITE;

UNLOCK TABLES;

/*Table structure for table `ticket` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket` (
  `idTicket` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTicket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ticket` */

LOCK TABLES `ticket` WRITE;

UNLOCK TABLES;

/*Table structure for table `tipousuario` */

DROP TABLE IF EXISTS `tipousuario`;

CREATE TABLE `tipousuario` (
  `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tipousuario` */

LOCK TABLES `tipousuario` WRITE;

insert  into `tipousuario`(`idTipoUsuario`,`descripcion`) values (1,'Admin'),(2,'Counter'),(3,'Estilista');

UNLOCK TABLES;

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
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */

LOCK TABLES `usuario` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
