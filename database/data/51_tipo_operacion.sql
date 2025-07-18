DROP TABLE IF EXISTS sunat_51;
CREATE TABLE sunat_51
(
    codigo                       VARCHAR(4)   NOT NULL PRIMARY KEY,
    descripcion                  VARCHAR(143) NOT NULL,
    tipo_de_comprobante_asociado VARCHAR(21)  NOT NULL
);
INSERT INTO sunat_51(codigo, descripcion, tipo_de_comprobante_asociado)
VALUES ('0101', 'Venta interna', 'Factura, Boletas')
     , ('0112', 'Venta Interna - Sustenta Gastos Deducibles Persona Natural', 'Factura')
     , ('0113', 'Venta Interna-NRUS', 'Boleta')
     , ('0200', 'Exportación de Bienes', 'Factura, Boletas')
     , ('0201', 'Exportación de Servicios – Prestación servicios realizados íntegramente en el país', 'Factura, Boletas')
     , ('0202', 'Exportación de Servicios – Prestación de servicios de hospedaje No Domiciliado', 'Factura')
     , ('0203', 'Exportación de Servicios – Transporte de navieras', 'Factura, Boletas')
     , ('0204', 'Exportación de Servicios – Servicios  a naves y aeronaves de bandera extranjera', 'Factura, Boletas')
     , ('0205', 'Exportación de Servicios  - Servicios que conformen un Paquete Turístico', 'Factura')
     , ('0206', 'Exportación de Servicios – Servicios complementarios al transporte de carga', 'Factura, Boletas')
     , ('0207', 'Exportación de Servicios – Suministro de energía eléctrica a favor de sujetos domiciliados en ZED', 'Factura, Boletas')
     , ('0208', 'Exportación de Servicios – Prestación servicios realizados parcialmente en el extranjero', 'Factura, Boletas')
     , ('0301', 'Operaciones con Carta de porte aéreo (emitidas en el ámbito nacional)', 'Factura, Boletas')
     , ('0302', 'Operaciones de Transporte ferroviario de pasajeros', 'Factura, Boletas')
     , ('0401', 'Ventas no domiciliados que no califican como exportación', 'Factura, Boletas')
     , ('0501', 'Compra interna', 'Liquidación de compra')
     , ('0502', 'Anticipos', 'Liquidación de compra')
     , ('0503', 'Compra de oro', 'Liquidación de compra')
     , ('1001', 'Operación Sujeta a Detracción', 'Factura, Boletas')
     , ('1002', 'Operación Sujeta a Detracción- Recursos Hidrobiológicos', 'Factura, Boletas')
     , ('1003', 'Operación Sujeta a Detracción- Servicios de Transporte Pasajeros', 'Factura, Boletas')
     , ('1004', 'Operación Sujeta a Detracción- Servicios de Transporte Carga', 'Factura, Boletas')
     , ('2001', 'Operación Sujeta a Percepción', 'Factura, Boletas')
     , ('2100', 'Créditos a empresas', 'Factura, Boletas')
     , ('2101', 'Créditos de consumo revolvente', 'Factura, Boletas')
     , ('2102', 'Créditos de consumo no revolvente', 'Factura, Boletas')
     , ('2103', 'Otras operaciones no gravadas - Empresas del sistema financiero y cooperativas de ahorro y crédito no autorizadas a captar recursos del público', 'Factura, Boletas')
     , ('2104', 'Otras operaciones no  gravadas - Empresas del sistema de seguros', 'Factura, Boletas');
