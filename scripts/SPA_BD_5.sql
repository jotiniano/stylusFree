CREATE TABLE `reserva` (                                            
           `idReserva` int(8) NOT NULL AUTO_INCREMENT,                       
           `idCliente` int(8) NOT NULL,                                      
           `idUsuario` int(8) NOT NULL,                                      
           `fechaInicio` datetime DEFAULT NULL,                              
           `fechaFin` datetime DEFAULT NULL,                                 
           `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,  
           `estado` tinyint(1) NOT NULL,                                     
           `fechaRegistro` datetime NOT NULL,                                
           PRIMARY KEY (`idReserva`)                                         
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci     