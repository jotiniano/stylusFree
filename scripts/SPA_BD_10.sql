alter table `spa`.`detalleticket` change `idServicio` `idProducto` int(11) NULL ;

ALTER TABLE `spa`.`reserva` ADD COLUMN `idEstilista` INT(11) NULL AFTER `fechaRegistro`;

ALTER TABLE `spa`.`ticket` 
   ADD COLUMN `visa` DECIMAL(10,2) DEFAULT '0' NULL AFTER `total`, 
   ADD COLUMN `mastercard` DECIMAL(10,2) DEFAULT '0' NULL AFTER `visa`, 
   ADD COLUMN `efectivo` DECIMAL(10,2) DEFAULT '0' NULL AFTER `mastercard`;
   

alter table `spa`.`detalleticket` add column `comision` decimal(4,2) NULL after `idUsuario`;