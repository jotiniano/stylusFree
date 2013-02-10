 alter table `spa`.`ticket` add column `total` decimal(10,2) NULL after `idCliente`;
 alter table `spa`.`cliente` add column `dni` varchar(8) NULL after `idTipoUsuario`;
