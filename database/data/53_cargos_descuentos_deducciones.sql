DROP TABLE IF EXISTS sunat_53;
CREATE TABLE sunat_53(
   codigo      VARCHAR(2) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(86) NOT NULL
  ,nivel       VARCHAR(6) NOT NULL
);
INSERT INTO sunat_53(codigo,descripcion,nivel) VALUES
 ('00','Descuentos que afectan la base imponible del IGV/IVAP','Item')
,('01','Descuentos que no afectan la base imponible del IGV/IVAP','Item')
,('02','Descuentos globales que afectan la base imponible del IGV/IVAP','Global')
,('03','Descuentos globales que no afectan la base imponible del IGV/IVAP','Global')
,('04','Descuentos globales por anticipos gravados que afectan la base imponible del IGV/IVAP','Global')
,('05','Descuentos globales por anticipos exonerados','Global')
,('06','Descuentos globales por anticipos inafectos','Global')
,('07','Factor de compensación - Decreto de urgencia N. 010-2004','Item')
,('45','FISE','Global')
,('46','Recargo al consumo y/o propinas','Global')
,('47','Cargos que afectan la base imponible del IGV/IVAP','Item')
,('48','Cargos que no afectan la base imponible del IGV/IVAP','Item')
,('49','Cargos globales que afectan la base imponible del IGV/IVAP','Global')
,('50','Cargos globales que no afectan la base imponible del IGV/IVAP','Global')
,('51','Percepción venta interna','Global')
,('52','Percepción a la adquisición de combustible','Global')
,('53','Percepción realizada al agente de percepción con tasa especial','Global')
,('54','Factor de aportación - Decreto de urgencia N. 010-2004','Item')
,('60','Deducción de ISC por anticipos','Global')
,('61','Retención de renta por anticipos','Global')
,('62','Retención del IGV','Global');
