DROP TABLE IF EXISTS sunat_01;
CREATE TABLE sunat_01(
   codigo      VARCHAR(2) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(225) NOT NULL
);
INSERT INTO sunat_01(codigo,descripcion) VALUES
 ('01','Factura')
,('03','Boleta de venta')
,('04','Liquidación de compra')
,('05','Boletos de Transporte Aéreo que emiten las Compañías de Aviación Comercial por el servicio de transporte aéreo regular de pasajeros, emitido de manera manual, mecanizada o por medios electrónicos (BME)')
,('06','Carta de porte aéreo')
,('07','Nota de crédito')
,('08','Nota de débito')
,('09','Guía de remisión remitente')
,('11','Póliza emitida por las Bolsas de Valores')
,('12','Ticket de máquina registradora')
,('13','Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la Superintendencia de Banca y Seguros')
,('14','Recibo servicios públicos')
,('15','Boletos emitidos por el servicio de transporte terrestre regular urbano de pasajeros y el ferroviario público de pasajeros prestado en vía férrea local')
,('16','Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros')
,('18','Documentos emitidos por las AFP')
,('19','Boleto por atracciones y espectáculos públicos')
,('20','Comprobante de retención')
,('21','Conocimiento de embarque por el servicio de transporte de carga marítima')
,('23','Pólizas de Adjudicación por remate o adjudicación de bienes')
,('24','Certificado de pago de regalías emitidas por PERUPETRO S.A.')
,('28','Etiquetas por el pago de la Tarifa Unificada de Uso de Aeropuerto – TUUA')
,('29','Documentos emitidos por la COFOPRI')
,('30','Documentos emitidos por las empresas que desempeñan el rol adquirente en los sistemas de pago mediante tarjetas de crédito y débito, emitidas por bancos e instituciones financieras o crediticias, domiciliados o no en el país.')
,('31','Guía de remisión transportista')
,('32','Documentos emitidos por recaudadoras de la Garantía de Red Principal')
,('34','Documento del Operador')
,('35','Documento del Partícipe')
,('36','Recibo de Distribución de Gas Natural')
,('37','Documentos que emitan los concesionarios del servicio de revisiones técnicas')
,('40','Comprobante de Percepción')
,('41','Comprobante de Percepción – Venta interna ( físico - formato impreso)')
,('42','Documentos emitidos por los adq. en los sistemas de pago por tarj. de crédito emitidas por ellas mismas')
,('43','Boleto de compañías de aviación transporte aéreo no regular')
,('45','Documentos emitidos por centros educativos y culturales, universidades, asociaciones y fundaciones')
,('55','BVME para transporte ferroviario de pasajeros')
,('56','Comprobante de pago SEAE')
,('71','Guía de remisión remitente complementaria')
,('72','Guía de remisión transportista complementaria')
,('87','Nota de crédito especial')
,('88','Nota de débito especial');
