/* script con los nuevos campos  */

alter table `spa`.`cliente` add column `fechaUltimaVisita` datetime NULL after `fechaNacimiento`, add column `direccion` varchar(100) NULL after `estado`, add column `totalVisitas` int(5) NULL after `direccion`;