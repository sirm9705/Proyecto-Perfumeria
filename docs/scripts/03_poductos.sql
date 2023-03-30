CREATE TABLE `productos` (
  `idproducto` int NOT NULL AUTO_INCREMENT,
  `nom_prod` varchar(50) NOT NULL,
  `desc_prod` varchar(255) NOT NULL,
  `precio` varchar(50) NOT NULL,
  `idmarca` int NOT NULL,
  `fecha_vencimiento` varchar(50) NOT NULL,
  `img` longblob NOT NULL,
  PRIMARY KEY (`idproducto`),
  KEY `FK_productos_marca` (`idmarca`),
  CONSTRAINT `FK_productos_marca` FOREIGN KEY (`idmarca`) REFERENCES `marca` (`idmarca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
