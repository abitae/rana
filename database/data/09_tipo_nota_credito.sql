DROP TABLE IF EXISTS sunat_09;
CREATE TABLE sunat_09
(
    codigo      VARCHAR(2)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL
);
INSERT INTO sunat_09(codigo, descripcion)
VALUES ('01', 'Anulación de la operación'),
       ('02', 'Anulación por error en el RUC'),
       ('03', 'Corrección por error en la descripción'),
       ('04', 'Descuento global'),
       ('05', 'Descuento por ítem'),
       ('06', 'Devolución total'),
       ('07', 'Devolución por ítem'),
       ('08', 'Bonificación'),
       ('09', 'Disminución en el valor'),
       ('10', 'Otros Conceptos'),
       ('11', 'Ajustes de operaciones de exportación'),
       ('12', 'Ajustes afectos al IVAP'),
       ('13', 'Corrección del monto neto pendiente de pago y/o la(s) fechas(s) de vencimiento del pago único o de las cuotas y/o los montos correspondientes a cada cuota, de ser el caso.');
