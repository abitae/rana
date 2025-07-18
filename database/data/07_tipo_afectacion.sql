DROP TABLE IF EXISTS sunat_07;
CREATE TABLE sunat_07(
   codigo            VARCHAR(2) NOT NULL PRIMARY KEY
  ,descripcion       VARCHAR(43) NOT NULL
  ,codigo_de_tributo VARCHAR(11) NOT NULL
);
INSERT INTO sunat_07(codigo,descripcion,codigo_de_tributo) VALUES
 ('10','Gravado - Operación Onerosa','1000')
,('11','Gravado – Retiro por premio','9996')
,('12','Gravado – Retiro por donación','9996')
,('13','Gravado – Retiro','9996')
,('14','Gravado – Retiro por publicidad','9996')
,('15','Gravado – Bonificaciones','9996')
,('16','Gravado – Retiro por entrega a trabajadores','9996')
,('17','Gravado - IVAP','1016 o 9996')
,('20','Exonerado - Operación Onerosa','9997')
,('21','Exonerado - Transferencia gratuita','9996')
,('30','Inafecto - Operación Onerosa','9998')
,('31','Inafecto – Retiro por Bonificación','9996')
,('32','Inafecto – Retiro','9996')
,('33','Inafecto – Retiro por Muestras Médicas','9996')
,('34','Inafecto - Retiro por Convenio Colectivo','9996')
,('35','Inafecto – Retiro por premio','9996')
,('36','Inafecto - Retiro por publicidad','9996')
,('37','Inafecto - Transferencia gratuita','9996')
,('40','Exportación de Bienes o Servicios','9995 o 9996');
