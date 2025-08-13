CREATE TABLE FIDE_DETALLE_PEDIDO_TB (
    PEDIDOS_ID_PEDIDO_FK NUMBER NOT NULL,
    PRODUCTOS_ID_PRODUCTO_FK NUMBER NOT NULL,
    ESTADOS_ID_ESTADO_FK NUMBER NOT NULL,
    CANTIDAD NUMBER,
    PRECIO_UNITARIO NUMBER(10,2),
    CONSTRAINT PK_FIDE_DETALLE_PEDIDO PRIMARY KEY (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK),
    CONSTRAINT FK_FIDE_DETALLE_PEDIDO_PEDIDO FOREIGN KEY (PEDIDOS_ID_PEDIDO_FK) REFERENCES FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK),
    CONSTRAINT FK_FIDE_DETALLE_PEDIDO_PRODUCTO FOREIGN KEY (PRODUCTOS_ID_PRODUCTO_FK) REFERENCES FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK),
    CONSTRAINT FK_FIDE_DETALLE_PEDIDO_ESTADO FOREIGN KEY (ESTADOS_ID_ESTADO_FK) REFERENCES FIDE_ESTADOS_TB (ESTADOS_ID_ESTADO_PK)
);

CREATE OR REPLACE VIEW VW_LISTAR_PRODUCTOS AS
SELECT
    p.PRODUCTO_ID_PRODUCTO_PK      AS ID_PRODUCTO,
    p.NOMBRE AS NOMBRE_PRODUCTO,
    p.DESCRIPCION AS DESCRIPCION_PRODUCTO,
    p.PRECIO_UNITARIO,
    p.Imagen,
    c.NOMBRE_CATEGORIA,
    pr.TIPO_PRESENTACION,
    pr.DESCRIPCION AS DESCRIPCION_PRESENTACION
FROM
    FIDE_PRODUCTOS_TB p
INNER JOIN fide_categoria_tb c
    ON p.CATEGORIA_ID_CATEGORIA_FK = c.CATEGORIA_ID_CATEGORIA_PK
INNER JOIN FIDE_PRESENTACIONES_TB pr
    ON p.PRESENTACIONES_ID_PRESENTACION_FK = pr.PRESENTACIONES_ID_PRESENTACION_PK
WHERE
    p.ESTADOS_ID_ESTADO_FK = 1;

SELECT * FROM VW_LISTAR_PRODUCTOS
-- HACER ALTER 
ALTER TABLE FIDE_PRODUCTOS_TB
ADD IMAGEN VARCHAR2(255);
-- ========================
-- INSERTS PARA FIDE_ESTADOS_TB
-- ========================
INSERT INTO FIDE_ESTADOS_TB VALUES (1, 'Activo', 'Estado habilitado para uso');
INSERT INTO FIDE_ESTADOS_TB VALUES (2, 'Inactivo', 'Estado deshabilitado temporalmente');
INSERT INTO FIDE_ESTADOS_TB VALUES (3, 'Pendiente', 'En espera de aprobación');
INSERT INTO FIDE_ESTADOS_TB VALUES (4, 'Suspendido', 'Suspendido por incumplimiento');
INSERT INTO FIDE_ESTADOS_TB VALUES (5, 'En Proceso', 'En proceso de validación');
INSERT INTO FIDE_ESTADOS_TB VALUES (6, 'Aprobado', 'Aprobado para uso');
INSERT INTO FIDE_ESTADOS_TB VALUES (7, 'Rechazado', 'Solicitud denegada');
INSERT INTO FIDE_ESTADOS_TB VALUES (8, 'Bloqueado', 'Acceso bloqueado');
INSERT INTO FIDE_ESTADOS_TB VALUES (9, 'Archivado', 'Registro no activo pero conservado');
INSERT INTO FIDE_ESTADOS_TB VALUES (10, 'Eliminado', 'Registro borrado del sistema');

-- ========================
-- INSERTS PARA FIDE_PAISES_TB
-- ========================
INSERT INTO FIDE_PAISES_TB VALUES (1, 'Costa Rica');
INSERT INTO FIDE_PAISES_TB VALUES (2, 'Panamá');
INSERT INTO FIDE_PAISES_TB VALUES (3, 'Nicaragua');
INSERT INTO FIDE_PAISES_TB VALUES (4, 'Honduras');
INSERT INTO FIDE_PAISES_TB VALUES (5, 'El Salvador');
INSERT INTO FIDE_PAISES_TB VALUES (6, 'Guatemala');
INSERT INTO FIDE_PAISES_TB VALUES (7, 'México');
INSERT INTO FIDE_PAISES_TB VALUES (8, 'Colombia');
INSERT INTO FIDE_PAISES_TB VALUES (9, 'Chile');
INSERT INTO FIDE_PAISES_TB VALUES (10, 'Argentina');

-- ========================
-- INSERTS PARA FIDE_PROVINCIAS_TB
-- ========================
INSERT INTO FIDE_PROVINCIAS_TB VALUES (1, 1, 'San José');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (2, 1, 'Alajuela');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (3, 1, 'Cartago');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (4, 1, 'Heredia');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (5, 1, 'Guanacaste');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (6, 1, 'Puntarenas');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (7, 1, 'Limón');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (8, 2, 'Provincia Panamá');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (9, 2, 'Provincia Colón');
INSERT INTO FIDE_PROVINCIAS_TB VALUES (10, 2, 'Provincia Chiriquí');

-- ========================
-- INSERTS PARA FIDE_CANTONES_TB
-- ========================
INSERT INTO FIDE_CANTONES_TB VALUES (1, 1, 'Central');
INSERT INTO FIDE_CANTONES_TB VALUES (2, 1, 'Escazú');
INSERT INTO FIDE_CANTONES_TB VALUES (3, 1, 'Desamparados');
INSERT INTO FIDE_CANTONES_TB VALUES (4, 1, 'Puriscal');
INSERT INTO FIDE_CANTONES_TB VALUES (5, 1, 'Tarrazú');
INSERT INTO FIDE_CANTONES_TB VALUES (6, 1, 'Aserrí');
INSERT INTO FIDE_CANTONES_TB VALUES (7, 1, 'Mora');
INSERT INTO FIDE_CANTONES_TB VALUES (8, 2, 'Central Alajuela');
INSERT INTO FIDE_CANTONES_TB VALUES (9, 2, 'San Ramón');
INSERT INTO FIDE_CANTONES_TB VALUES (10, 2, 'Grecia');

-- ========================
-- INSERTS PARA FIDE_DISTRITOS_TB
-- ========================
INSERT INTO FIDE_DISTRITOS_TB VALUES (1, 1, 'Carmen');
INSERT INTO FIDE_DISTRITOS_TB VALUES (2, 1, 'Merced');
INSERT INTO FIDE_DISTRITOS_TB VALUES (3, 1, 'Hospital');
INSERT INTO FIDE_DISTRITOS_TB VALUES (4, 1, 'Catedral');
INSERT INTO FIDE_DISTRITOS_TB VALUES (5, 1, 'Zapote');
INSERT INTO FIDE_DISTRITOS_TB VALUES (6, 1, 'San Francisco de Dos Ríos');
INSERT INTO FIDE_DISTRITOS_TB VALUES (7, 1, 'Uruca');
INSERT INTO FIDE_DISTRITOS_TB VALUES (8, 1, 'Mata Redonda');
INSERT INTO FIDE_DISTRITOS_TB VALUES (9, 1, 'Pavas');
INSERT INTO FIDE_DISTRITOS_TB VALUES (10, 1, 'Hatillo');

-- ========================
-- INSERTS PARA FIDE_CARGOS_TB
-- ========================
INSERT INTO FIDE_CARGOS_TB VALUES (1, 1, 'Gerente General', 'Encargado de la administración global de la farmacia');
INSERT INTO FIDE_CARGOS_TB VALUES (2, 1, 'Farmacéutico', 'Dispensa medicamentos y asesora a los clientes');
INSERT INTO FIDE_CARGOS_TB VALUES (3, 1, 'Asistente de Farmacia', 'Ayuda en la atención al cliente y organización');
INSERT INTO FIDE_CARGOS_TB VALUES (4, 1, 'Cajero', 'Procesa pagos y facturación');
INSERT INTO FIDE_CARGOS_TB VALUES (5, 1, 'Encargado de Inventario', 'Controla el stock de medicamentos');
INSERT INTO FIDE_CARGOS_TB VALUES (6, 1, 'Repartidor', 'Entrega pedidos a domicilio');
INSERT INTO FIDE_CARGOS_TB VALUES (7, 1, 'Supervisor de Turno', 'Gestiona operaciones diarias en su turno');
INSERT INTO FIDE_CARGOS_TB VALUES (8, 1, 'Administrador de Sistemas', 'Mantiene el sistema informático de la farmacia');
INSERT INTO FIDE_CARGOS_TB VALUES (9, 1, 'Limpieza', 'Mantiene la higiene del local');
INSERT INTO FIDE_CARGOS_TB VALUES (10, 1, 'Marketing y Ventas', 'Promueve productos y gestiona campañas');

-- ========================
-- INSERTS PARA FIDE_TIPO_USUARIO_TB
-- ========================
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (1, 1, 1, 'Administrador General', 'Tiene acceso total al sistema');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (2, 1, 2, 'Farmacéutico Titular', 'Encargado principal de la farmacia');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (3, 1, 3, 'Asistente de Ventas', 'Atiende clientes y organiza productos');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (4, 1, 4, 'Cajero Principal', 'Atiende en caja y procesa pagos');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (5, 1, 5, 'Gestor de Inventario', 'Controla entradas y salidas de productos');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (6, 1, 6, 'Repartidor Express', 'Realiza entregas rápidas a clientes');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (7, 1, 7, 'Supervisor de Operaciones', 'Coordina el trabajo del personal');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (8, 1, 8, 'Administrador de Base de Datos', 'Administra y respalda datos del sistema');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (9, 1, 9, 'Personal de Limpieza', 'Mantiene la farmacia limpia y ordenada');
INSERT INTO FIDE_TIPO_USUARIO_TB VALUES (10, 1, 10, 'Ejecutivo de Marketing', 'Promociona productos y ofertas');

-- ========================
-- INSERTS PARA FIDE_USUARIOS_TB
-- ========================
INSERT INTO FIDE_USUARIOS_TB VALUES (1, 1, 1, 'Carlos Gómez', 'carlos.gomez@farmacia.com', '8888-1111', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (2, 2, 1, 'María López', 'maria.lopez@farmacia.com', '8888-2222', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (3, 3, 1, 'Luis Rodríguez', 'luis.rodriguez@farmacia.com', '8888-3333', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (4, 4, 1, 'Ana Fernández', 'ana.fernandez@farmacia.com', '8888-4444', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (5, 5, 1, 'Jorge Castro', 'jorge.castro@farmacia.com', '8888-5555', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (6, 6, 1, 'Sofía Martínez', 'sofia.martinez@farmacia.com', '8888-6666', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (7, 7, 1, 'Ricardo Vega', 'ricardo.vega@farmacia.com', '8888-7777', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (8, 8, 1, 'Daniela Morales', 'daniela.morales@farmacia.com', '8888-8888', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (9, 9, 1, 'Esteban Quesada', 'esteban.quesada@farmacia.com', '8888-9999', 'clave123');
INSERT INTO FIDE_USUARIOS_TB VALUES (10, 10, 1, 'Patricia Ramírez', 'patricia.ramirez@farmacia.com', '8888-0000', 'clave123');

-- ========================
-- INSERTS PARA FIDE_DIRECCIONES_TB
-- ========================
INSERT INTO FIDE_DIRECCIONES_TB VALUES (1, 1, 1, 1, 1, 1, 'Calle 1, Avenida Central, frente a la farmacia',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (2, 2, 1, 2, 2, 2, 'Barrio Escazú, 200m norte del parque central',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (3, 3, 1, 3, 3, 3, 'Cartago centro, diagonal a la Basílica',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (4, 4, 1, 4, 4, 4, 'Heredia centro, costado oeste del mercado',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (5, 5, 1, 5, 5, 5, 'Liberia, 100m sur de la terminal de buses',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (6, 6, 1, 6, 6, 6, 'Puntarenas centro, frente al muelle',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (7, 7, 1, 7, 7, 7, 'Limón, 300m este del hospital Tony Facio',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (8, 8, 1, 8, 8, 8, 'Panamá ciudad, Vía España, edificio Torre Azul',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (9, 9, 1, 9, 9, 9, 'Colón, avenida Bolívar, cerca del puerto',1);
INSERT INTO FIDE_DIRECCIONES_TB VALUES (10, 10, 1, 10, 10, 10, 'Chiriquí, calle central, frente a la plaza',1);
-- ========================
-- INSERTS PARA FIDE_CONTACTO_TB
-- ========================
INSERT INTO FIDE_CONTACTO_TB VALUES (1, 1, 1, 'Consulta sobre medicamento', 'Hola, quisiera saber si tienen disponible Ibuprofeno 600mg.', TO_DATE('2025-01-15','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (2, 2, 1, 'Pedido a domicilio', 'Solicito un pedido de acetaminofén y vitamina C para entrega hoy.', TO_DATE('2025-01-18','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (3, 3, 1, 'Horario de atención', 'Quisiera confirmar si abren los domingos por la mañana.', TO_DATE('2025-01-20','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (4, 4, 1, 'Problema con facturación', 'En mi última compra, la factura no incluyó un medicamento.', TO_DATE('2025-01-22','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (5, 5, 1, 'Solicitud de cotización', 'Necesito precio por caja de 100 guantes de látex.', TO_DATE('2025-01-25','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (6, 6, 1, 'Recomendación de producto', '¿Qué suplemento recomiendan para aumentar defensas?', TO_DATE('2025-01-28','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (7, 7, 1, 'Queja por retraso', 'El pedido que solicité ayer llegó con 3 horas de retraso.', TO_DATE('2025-01-30','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (8, 8, 1, 'Solicitud de cita', 'Quisiera agendar una cita con el farmacéutico para asesoría.', TO_DATE('2025-02-01','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (9, 9, 1, 'Producto agotado', '¿Cuándo tendrán nuevamente disponible la insulina Lantus?', TO_DATE('2025-02-03','YYYY-MM-DD'));
INSERT INTO FIDE_CONTACTO_TB VALUES (10, 10, 1, 'Felicitación', 'Quiero felicitarlos por la excelente atención recibida ayer.', TO_DATE('2025-02-05','YYYY-MM-DD'));

-- ========================
-- CATEGORÍAS
-- ========================
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (1, 1, 'RESPIRATORIA', 'Medicamentos y tratamientos enfocados en el sistema respiratorio, incluyendo padecimientos como asma, bronquitis, y otras afecciones de los pulmones y vías aéreas.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (2, 1, 'DESINFECCIÓN DE ALTO NIVEL', 'Productos y procedimientos utilizados para eliminar microorganismos de alto riesgo en equipos y superficies, garantizando un ambiente estéril.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (3, 1, 'ANTIPARASITARIO', 'Fármacos diseñados para combatir y eliminar parásitos que pueden infectar a humanos y animales, como gusanos, piojos o ácaros.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (4, 1, 'CARDIOMETABOLICO', 'Tratamientos dirigidos a enfermedades del corazón y del metabolismo, como la hipertensión arterial, la diabetes y el colesterol alto.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (5, 1, 'DERMATOLÓGICO', 'Productos y medicamentos para el cuidado y tratamiento de la piel, cabello y uñas, incluyendo afecciones como acné, dermatitis o infecciones fúngicas.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (6, 1, 'DOLOR', 'Analgésicos y terapias para el manejo de diferentes tipos de dolor, ya sea agudo o crónico, muscular, de cabeza o inflamatorio.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (7, 1, 'GASTRICO', 'Medicamentos para tratar problemas del sistema digestivo, como acidez, úlceras, reflujo y otros trastornos del estómago e intestinos.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (8, 1, 'OTC', 'Productos de venta libre que no requieren prescripción médica, como analgésicos suaves, vitaminas o jarabes para la tos.');
INSERT INTO FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK, ESTADOS_ID_ESTADO_FK, NOMBRE_CATEGORIA, DESCRIPCION) VALUES (9, 1, 'UROLÓGICO', 'Tratamientos y medicamentos para las enfermedades del sistema urinario en hombres y mujeres, y del sistema reproductor masculino.');

CREATE TABLE FIDE_PRESENTACIONES_TB (
    PRESENTACIONES_ID_PRESENTACION_PK NUMBER CONSTRAINT FIDE_PRESENTACIONES_ID_PRESENTACION_PK PRIMARY KEY,
    ESTADOS_ID_ESTADO_FK NUMBER CONSTRAINT FIDE_PRESENTACIONES_ID_ESTADO_NOT_NULL NOT NULL,
    TIPO_PRESENTACION VARCHAR2(100),
    DESCRIPCION VARCHAR2(255),
    CONSTRAINT FIDE_PRESENTACIONES_ID_ESTADO_FK FOREIGN KEY (ESTADOS_ID_ESTADO_FK) REFERENCES FIDE_ESTADOS_TB (ESTADOS_ID_ESTADO_PK)
);

CREATE TABLE FIDE_PRODUCTOS_TB (
    PRODUCTO_ID_PRODUCTO_PK NUMBER CONSTRAINT FIDE_PRODUCTOS_ID_PRODUCTO_PK PRIMARY KEY,
    CATEGORIA_ID_CATEGORIA_FK NUMBER CONSTRAINT FIDE_PRODUCTOS_ID_CATEGORIA_NOT_NULL NOT NULL,
    PRESENTACIONES_ID_PRESENTACION_FK NUMBER CONSTRAINT FIDE_PRODUCTOS_ID_PRESENTACION_NOT_NULL NOT NULL,
    ESTADOS_ID_ESTADO_FK NUMBER CONSTRAINT FIDE_PRODUCTOS_ID_ESTADO_NOT_NULL NOT NULL,
    NOMBRE VARCHAR2(100) CONSTRAINT FIDE_PRODUCTOS_NOMBRE_NOT_NULL NOT NULL,
    DESCRIPCION VARCHAR2(255),
    PRECIO_UNITARIO NUMBER(10,2),
    CONSTRAINT FIDE_PRODUCTOS_ID_CATEGORIA_FK FOREIGN KEY (CATEGORIA_ID_CATEGORIA_FK) REFERENCES FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK),
    CONSTRAINT FIDE_PRODUCTOS_ID_PRESENTACION_FK FOREIGN KEY (PRESENTACIONES_ID_PRESENTACION_FK) REFERENCES FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK),
    CONSTRAINT FIDE_PRODUCTOS_ID_ESTADO_FK FOREIGN KEY (ESTADOS_ID_ESTADO_FK) REFERENCES FIDE_ESTADOS_TB (ESTADOS_ID_ESTADO_PK)
);
-- ========================
-- PRESENTACIONES
-- ========================
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (1, 1, 'Aerosol', 'Un producto envasado que se libera como una fina niebla o rocío, generalmente usado para inhalación o aplicación tópica.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (2, 1, 'Solución', 'Una mezcla líquida homogénea de uno o más componentes, a menudo utilizada para beber, inyectar o aplicar sobre la piel.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (3, 1, 'Crema', 'Una preparación semisólida y suave, generalmente para uso externo en la piel.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (4, 1, 'Spray', 'Similar al aerosol, pero libera el líquido en partículas más grandes, a menudo para uso tópico en la nariz o garganta.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (5, 1, 'Tabletas', 'Medicamentos sólidos en forma de pastilla, destinados a ser tragados enteros.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (6, 1, 'Jarabe', 'Una solución dulce y espesa, principalmente para el consumo oral, común en medicamentos para la tos.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (7, 1, 'Gel', 'Una preparación semisólida con una consistencia gelatinosa, aplicada sobre la piel o mucosas.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (8, 1, 'Sachet', 'Un pequeño sobre sellado que contiene una dosis única de polvo o líquido, listo para ser disuelto o consumido.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (9, 1, 'Champú', 'Un producto líquido o cremoso utilizado para lavar el cabello y el cuero cabelludo, a veces con fines medicinales.');
INSERT INTO FIDE_PRESENTACIONES_TB (PRESENTACIONES_ID_PRESENTACION_PK, ESTADOS_ID_ESTADO_FK, TIPO_PRESENTACION, DESCRIPCION) VALUES (10,1, 'Otros', 'Esta categoría se usa para presentaciones que no encajan en las opciones anteriores, como supositorios, parches transdérmicos, o inyecciones.');

-- ========================
-- Categorias
-- ========================
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('1','1','RESPIRATORIA','Medicamentos y tratamientos enfocados en el sistema respiratorio, incluyendo padecimientos como asma, bronquitis, y otras afecciones de los pulmones y vías aéreas.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('2','1','DESINFECCIÓN DE ALTO NIVEL','Productos y procedimientos utilizados para eliminar microorganismos de alto riesgo en equipos y superficies, garantizando un ambiente estéril.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('3','1','ANTIPARASITARIO','Fármacos diseñados para combatir y eliminar parásitos que pueden infectar a humanos y animales, como gusanos, piojos o ácaros.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('4','1','CARDIOMETABOLICO','Tratamientos dirigidos a enfermedades del corazón y del metabolismo, como la hipertensión arterial, la diabetes y el colesterol alto.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('5','1','DERMATOLÓGICO','Productos y medicamentos para el cuidado y tratamiento de la piel, cabello y uñas, incluyendo afecciones como acné, dermatitis o infecciones fúngicas.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('6','1','DOLOR','Analgésicos y terapias para el manejo de diferentes tipos de dolor, ya sea agudo o crónico, muscular, de cabeza o inflamatorio.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('7','1','GASTRICO','Medicamentos para tratar problemas del sistema digestivo, como acidez, úlceras, reflujo y otros trastornos del estómago e intestinos.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('8','1','OTC','Productos de venta libre que no requieren prescripción médica, como analgésicos suaves, vitaminas o jarabes para la tos.');
Insert into FIDE_CATEGORIA_TB (CATEGORIA_ID_CATEGORIA_PK,ESTADOS_ID_ESTADO_FK,NOMBRE_CATEGORIA,DESCRIPCION) values ('9','1','UROLÓGICO','Tratamientos y medicamentos para las enfermedades del sistema urinario en hombres y mujeres, y del sistema reproductor masculino.');

-- ========================
-- PRODUCTOS
-- ========================
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (1, 1, 1, 1, 'SALBUTÍN', 'Suspensión en aerosol para inhalación oral. Herramienta terapéutica para asma y EPOC. 200 dosis.', 9500.00, 'images/Productos/RESPIRATORIA/Salbutin.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (2, 1, 2, 1, 'AFTOTEX', 'Solución y spray para infecciones menores de la cavidad bucal (estomatitis, faringitis, aftas). Triple acción.', 5800.00, 'images/Productos/RESPIRATORIA/AFTOTEX.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (3, 1, 2, 1, 'OTOCERUM', 'Solución ótica en gotas para suavizar y remover el cerumen del oído.', 4250.00, 'images/Productos/RESPIRATORIA/otocerum650.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (4, 1, 6, 1, 'HERBATOS', 'Expectorante, mucolítico y antitusígeno (Hedera Helix). Coadyuvante en procesos respiratorios.', 6100.00, 'images/Productos/RESPIRATORIA/Herbatos Jarabe.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (6, 1, 6, 1, 'HERBATOS JENGIBRE', 'Expectorante, mucolítico y antitusígeno con jengibre. Antiinflamatorio natural, evita congestión.', 6500.00, 'images/Productos/RESPIRATORIA/herbatos_jengibre.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (7, 1, 4, 1, 'AQUA NASAL', 'Solución en spray de Cloruro de Sodio al 0.9% para descongestión y limpieza de fosas nasales.', 5300.00, 'images/Productos/RESPIRATORIA/aqua_nasal_producto.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (8, 1, 4, 1, 'AQUA NASAL PEDIÁTRICO', 'Solución en spray de Cloruro de Sodio al 0.9% para descongestión y limpieza de fosas nasales en niños.', 5100.00, 'images/Productos/RESPIRATORIA/AQUA_NASAL PEDIATRICO.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (9, 2, 2, 1, 'ORTOFTALDEHÍDO SOLUCIÓN', 'Solución desinfectante al 0.55% para aparatos médicos sensibles al calor. Inmersión de 5 minutos.', 25000.00, 'images/Productos/opa2.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (10, 2, 10, 1, 'TIRAS REACTIVAS AL ORTOFTALDEHÍDO', 'Indicadores químicos para determinar si la concentración de ortoftaldehído está por encima de la MEC de 0.30%.', 15000.00, 'images/Productos/DESINFECCIÓN DE ALTO NIVEL/Tiras_650.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (11, 3, 8, 1, 'DELIX', 'Antiparasitario de amplio espectro con sabor a vainilla. Para lombrices y Giardia Lamblia. Sachet caja x12.', 9800.00, 'images/Productos/ANTIPARASITARIO/delix.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (12, 3, 9, 1, 'PIOFÍN CHAMPÚ', 'Altamente eficaz contra piojos y liendres, inofensivo para el ser humano. Uso externo. Frasco 100 ml.', 8500.00, 'images/Productos/ANTIPARASITARIO/piofin.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (13, 3, 2, 1, 'PIOFÍN PLUS SOLUCIÓN', 'Elimina en minutos piojos del cabello, cuerpo y pubis, y sus liendres. Incluye peine. Frasco 60 ml.', 10500.00, 'images/Productos/ANTIPARASITARIO/Piofin solucion.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (14, 3, 5, 1, 'IVERPIOFÍN', 'Altamente eficaz contra piojos y liendres. Ivermectina 6mg tabletas, antihelmíntico y ectoparasiticida oral.', 12000.00, 'images/Productos/ANTIPARASITARIO/iverpiofin.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (15, 4, 5, 1, 'DIABECONTROL', 'Dapagliflozina 10 mg. Tabletas para diabetes mellitus tipo 2 e insuficiencia cardíaca crónica.', 18000.00, 'images/Productos/CARDIOMETABOLICO/Diabecontrol.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (16, 5, 4, 1, 'TROFODERMAX SPRAY', 'Spray antiinfeccioso cicatrizante para úlceras cutáneas, infecciones, quemaduras y heridas.', 7800.00, 'images/Productos/DERMATOLÓGICO/TROFODERMAX SPRAY.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (17, 5, 3, 1, 'FUSIBIOTIC', 'Crema antibiótica para infecciones de la piel como heridas infectadas, granos y acné. Uso externo.', 6500.00, 'images/Productos/DERMATOLÓGICO/fusibiotic.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (18, 5, 7, 1, 'ALERGEL', 'Gel para alergias, picaduras, quemaduras solares e irritaciones. Transparente, sin olor, no grasoso.', 4500.00, 'images/Productos/DERMATOLÓGICO/ALERGEL_nueva.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (19, 5, 3, 1, 'TERMINAFÍN CREMA', 'Alivia picazón, ardor y descamación por hongos. Antimicótico para pie de atleta, tiña, candidiasis.', 7200.00, 'images/Productos/DERMATOLÓGICO/Terminafin crema.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (20, 5, 4, 1, 'SECARIDE SPRAY', 'Formulación para curación de heridas y lesiones exudativas con riesgo de infección. Con Zeolita de plata.', 9100.00, 'images/Productos/DERMATOLÓGICO/Secaride Spray.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (21, 5, 3, 1, 'DERMETIQUE DESODORANTE EN CREMA', 'Desodorante y antitranspirante en crema. Disminuye transpiración y olor por 24 horas. No irritante.', 5800.00, 'images/Productos/DERMATOLÓGICO/Dermetique50ml_desodorante_crema.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (22, 5, 4, 1, 'TERMINAFÍN SPRAY 30ml.', 'Alivia picazón y síntomas de hongos. Terbinafina, antimicótico de amplio espectro.', 6500.00, 'images/Productos/DERMATOLÓGICO/Terminafin 30 ml.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (23, 5, 4, 1, 'TERMINAFIN SPRAY 125 ML', 'Alivia picazón y síntomas de hongos. Terbinafina, antimicótico. Presentación grande.', 12500.00, 'images/Productos/DERMATOLÓGICO/Terminafin 125 ml.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (24, 5, 10, 1, 'SECARIDE JABON NEUTRO', 'Jabón en espuma efectivo para limpieza de heridas y lesiones sin irritación. Con Lauril Sulfato de Sodio.', 8900.00, 'images/Productos/DERMATOLÓGICO/Secaride Jabon.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (25, 5, 3, 1, 'TROFODERMAX CREMA', 'Crema Clostebol-Neomicina para úlceras cutáneas, infecciones, quemaduras y heridas. Cicatrizante.', 7500.00, 'images/Productos/DERMATOLÓGICO/Trofodermax Crema.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (26, 5, 3, 1, 'MEDIGLOSS', 'Ungüento para humectar la piel del bebé en la zona del pañal. Enriquecido con D-Pantenol.', 6800.00, 'images/Productos/DERMATOLÓGICO/medigloss_producto.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (28, 5, 3, 1, 'BIOPANTENOL UNGÜENTO', 'Ungüento hipoalergénico enriquecido con D-Pantenol para el cuidado de la piel.', 7200.00, 'images/Productos/DERMATOLÓGICO/BioPantenol_unguento_productoycaja.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (50, 5, 3, 1, 'BIOPANTENOL CREMA', 'Crema hipoalergénica enriquecida con D-Pantenol para humectar la piel del bebé en la zona del pañal. Presentación: tubo de 50g. Uso tópico.', 6900.00, 'images/Productos/DERMATOLÓGICO/BioPantenol_crema_productoycaja.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (29, 6, 2, 1, 'AZ MINOFÉN', 'Analgésico y antipirético con sabor a fresa-cereza. Tratamiento de fiebre y dolores leves. Solución.', 5500.00, 'images/Productos/DOLOR/az.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (30, 6, 4, 1, 'LIDOCAÍNA SPRAY PRESURIZADA', 'Anestésico local tópico al 10% para piel, cirugía menor, y alivio de quemaduras o picaduras.', 8500.00, 'images/Productos/DOLOR/Lidocana_650.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (31, 6, 4, 1, 'SPORT ICE', 'Spray para alivio inmediato del dolor por enfriamiento (terapia en frío). Efecto analgésico y antiinflamatorio.', 6000.00, 'images/Productos/DOLOR/sportice.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (32, 6, 10, 1, 'GOLPARÉN', 'Diclofenaco dietilamina 1.16%. Reduce inflamación y alivia dolor en golpes, torceduras, dolores musculares.', 7800.00, 'images/Productos/DOLOR/golparen.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (33, 6, 5, 1, 'FLEXITAB', 'Ciclobenzaprina Clorhidrato 10 mg. Tabletas para alivio del espasmo muscular y dolor agudo.', 9500.00, 'images/Productos/DOLOR/Flexitab.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (34, 6, 7, 1, 'ROLOMED', 'Ibuprofeno 50 mg/g gel. Analgésico y antiinflamatorio local para dolor leve a moderado en tejidos blandos.', 6500.00, 'images/Productos/DOLOR/rolomed.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (35, 6, 2, 1, 'MEGALIVIA', 'Dexketoprofeno 25 mg. Solución oral en sachet para tratamiento sintomático del dolor agudo leve o moderado.', 11000.00, 'images/Productos/DOLOR/Megalivia.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (51, 6, 5, 1, 'MEGALIVIA TABLETAS', 'Dexketoprofeno 25 mg. Tabletas recubiertas para tratamiento sintomático del dolor leve a moderado..', 10500.00, 'images/Productos/DOLOR/megalivia_01.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (36, 7, 2, 1, 'FRUTADEX ADULTO Y NIÑOS', 'Suero de rehidratación oral, "el suero que sí sabe bien". Para recuperar electrolitos en diarrea, vómito, calor.', 4500.00, 'images/Productos/GASTRICO/Frutadex Familia.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (37, 7, 2, 1, 'DIABEDEX', 'Bebida hidratante hipotónica sin calorías con electrolitos para evitar síntomas de deshidratación.', 5100.00, 'images/Productos/GASTRICO/Diabedex.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (38, 7, 8, 1, 'BUCO VAC', 'Sobres dispersables con probióticos para mejorar el balance de la flora intestinal.', 15000.00, 'images/Productos/GASTRICO/Buco Vac.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (39, 7, 2, 1, 'YDRAT', 'YDRAT® Zn 60. Bebida hidratante con Zinc y electrolitos. Sabores: Arándano, Frutos Rojos, Kiwi, Maracuyá.', 5000.00, 'images/Productos/GASTRICO/ydrat familia.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (40, 7, 2, 1, 'LIVIOSAN', 'Tratamiento integral para Síndrome de Intestino Irritable. Bromuro de Pinaverio y Simeticona.', 8500.00, 'images/Productos/GASTRICO/liviosanlateral.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (41, 8, 3, 1, 'LUBRISEX', 'Lubricante íntimo a base de agua. Seguro, discreto, no grasoso, transparente. Tubo 50g y Sachet 10g.', 6000.00, 'images/Productos/OTC/LubriSex Gel.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (42, 8, 3, 1, 'SPIN DESODORANTE', 'Antitranspirante roll-on sin perfume, con bactericida. Ideal para sudoración fuerte y pieles sensibles. 90ml.', 5500.00, 'images/Productos/OTC/Spin_MyH.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (43, 8, 4, 1, 'DURASEX', 'Spray con Lidocaína al 10% para controlar la sensibilidad del pene y retardar la eyaculación. Spray 9ml.', 8500.00, 'images/Productos/OTC/Dura Sex Spray.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (45, 8, 2, 1, 'CICLOPIROX', 'Solución tópica al 8% para el tratamiento de infecciones de las uñas causadas por hongos. Frasco 5g.', 9200.00, 'images/Productos/OTC/Ciclo-P.jpg');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (48, 9, 8, 1, 'MEDIGRAY UROBLU', 'Extracto de arándano rojo (cranberry) para profilaxis y coadyuvante en tratamiento de infecciones del tracto urinario inferior.', 14000.00, 'images/Productos/UROLÓGICO/Uroblu650.png');
INSERT INTO FIDE_PRODUCTOS_TB (PRODUCTO_ID_PRODUCTO_PK, CATEGORIA_ID_CATEGORIA_FK, PRESENTACIONES_ID_PRESENTACION_FK, ESTADOS_ID_ESTADO_FK, NOMBRE, DESCRIPCION, PRECIO_UNITARIO, IMAGEN) VALUES (49, 9, 8, 1, 'Medigray Vigor', 'Suplemento nutricional en sachets bebibles con Aspartato de Arginina 5g/10 mL.', 18000.00, 'images/Productos/UROLÓGICO/Vigor 650.png');

-- ========================
-- ALMACENADO
-- ========================
INSERT INTO FIDE_ALMACENADO_TB VALUES (1, 1, 'Estantería A - Nivel 1');
INSERT INTO FIDE_ALMACENADO_TB VALUES (2, 1, 'Estantería A - Nivel 2');
INSERT INTO FIDE_ALMACENADO_TB VALUES (3, 1, 'Estantería B - Nivel 1');
INSERT INTO FIDE_ALMACENADO_TB VALUES (4, 1, 'Estantería B - Nivel 2');
INSERT INTO FIDE_ALMACENADO_TB VALUES (5, 1, 'Estantería C - Refrigerado');
INSERT INTO FIDE_ALMACENADO_TB VALUES (6, 1, 'Estantería D - Zona Alta');
INSERT INTO FIDE_ALMACENADO_TB VALUES (7, 1, 'Estantería D - Zona Baja');
INSERT INTO FIDE_ALMACENADO_TB VALUES (8, 1, 'Almacén de Control Especial');
INSERT INTO FIDE_ALMACENADO_TB VALUES (9, 1, 'Cuarto de Refrigeración 2°C-8°C');
INSERT INTO FIDE_ALMACENADO_TB VALUES (10, 1, 'Zona de Cuarentena');

-- ========================
-- INVENTARIO
-- ========================
INSERT INTO FIDE_INVENTARIO_TB VALUES (1, 1, 1, 1, 150, TO_DATE('2025-08-01','YYYY-MM-DD'), 'Lote reciente');
INSERT INTO FIDE_INVENTARIO_TB VALUES (2, 2, 1, 1, 200, TO_DATE('2025-08-01','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (3, 3, 1, 5, 80, TO_DATE('2025-07-28','YYYY-MM-DD'), 'Refrigerado');
INSERT INTO FIDE_INVENTARIO_TB VALUES (4, 4, 1, 5, 60, TO_DATE('2025-07-20','YYYY-MM-DD'), 'Requiere cadena de frío');
INSERT INTO FIDE_INVENTARIO_TB VALUES (5, 5, 1, 2, 100, TO_DATE('2025-08-03','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (6, 6, 1, 3, 120, TO_DATE('2025-08-04','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (7, 7, 1, 4, 90, TO_DATE('2025-08-02','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (8, 8, 1, 3, 75, TO_DATE('2025-08-06','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (9, 9, 1, 3, 85, TO_DATE('2025-08-06','YYYY-MM-DD'), NULL);
INSERT INTO FIDE_INVENTARIO_TB VALUES (10, 10, 1, 2, 110, TO_DATE('2025-08-05','YYYY-MM-DD'), 'Nuevo ingreso');

-- ========================
-- PEDIDOS
-- ========================

INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (1, 5, 3, TO_DATE('2025-08-15','YYYY-MM-DD'), 25450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (2, 8, 3, TO_DATE('2025-08-22','YYYY-MM-DD'), 12340);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (3, 2, 3, TO_DATE('2025-08-05','YYYY-MM-DD'), 56789);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (4, 9, 3, TO_DATE('2025-08-28','YYYY-MM-DD'), 30125);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (5, 1, 3, TO_DATE('2025-08-01','YYYY-MM-DD'), 15750);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (6, 7, 3, TO_DATE('2025-08-19','YYYY-MM-DD'), 48900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (7, 4, 3, TO_DATE('2025-08-11','YYYY-MM-DD'), 21050);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (8, 6, 3, TO_DATE('2025-08-08','YYYY-MM-DD'), 37600);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (9, 3, 3, TO_DATE('2025-08-25','YYYY-MM-DD'), 9850);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (10, 10, 3, TO_DATE('2025-08-30','YYYY-MM-DD'), 41220);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (11, 2, 3, TO_DATE('2025-08-14','YYYY-MM-DD'), 18500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (12, 5, 3, TO_DATE('2025-08-07','YYYY-MM-DD'), 6012);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (13, 8, 3, TO_DATE('2025-08-21','YYYY-MM-DD'), 34567);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (14, 1, 3, TO_DATE('2025-08-10','YYYY-MM-DD'), 7890);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (15, 7, 3, TO_DATE('2025-08-29','YYYY-MM-DD'), 42100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (16, 4, 3, TO_DATE('2025-08-17','YYYY-MM-DD'), 29876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (17, 9, 3, TO_DATE('2025-08-03','YYYY-MM-DD'), 11223);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (18, 6, 3, TO_DATE('2025-08-26','YYYY-MM-DD'), 36540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (19, 3, 3, TO_DATE('2025-08-09','YYYY-MM-DD'), 23456);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (20, 10, 3, TO_DATE('2025-08-16','YYYY-MM-DD'), 49870);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (21, 1, 3, TO_DATE('2025-08-24','YYYY-MM-DD'), 14500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (22, 5, 3, TO_DATE('2025-08-02','YYYY-MM-DD'), 8900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (23, 8, 3, TO_DATE('2025-08-20','YYYY-MM-DD'), 32100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (24, 2, 3, TO_DATE('2025-08-13','YYYY-MM-DD'), 19876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (25, 9, 3, TO_DATE('2025-08-27','YYYY-MM-DD'), 45678);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (26, 7, 3, TO_DATE('2025-08-06','YYYY-MM-DD'), 28900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (27, 4, 3, TO_DATE('2025-08-18','YYYY-MM-DD'), 13450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (28, 6, 3, TO_DATE('2025-08-12','YYYY-MM-DD'), 39000);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (29, 3, 3, TO_DATE('2025-08-04','YYYY-MM-DD'), 7540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (30, 10, 3, TO_DATE('2025-08-31','YYYY-MM-DD'), 52300);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (31, 5, 3, TO_DATE('2025-08-15','YYYY-MM-DD'), 25450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (32, 8, 3, TO_DATE('2025-08-22','YYYY-MM-DD'), 12340);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (33, 2, 3, TO_DATE('2025-08-05','YYYY-MM-DD'), 56789);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (34, 9, 3, TO_DATE('2025-08-28','YYYY-MM-DD'), 30125);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (35, 1, 3, TO_DATE('2025-08-01','YYYY-MM-DD'), 15750);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (36, 7, 3, TO_DATE('2025-08-19','YYYY-MM-DD'), 48900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (37, 4, 3, TO_DATE('2025-08-11','YYYY-MM-DD'), 21050);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (38, 6, 3, TO_DATE('2025-08-08','YYYY-MM-DD'), 37600);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (39, 3, 3, TO_DATE('2025-08-25','YYYY-MM-DD'), 9850);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (40, 10, 3, TO_DATE('2025-08-30','YYYY-MM-DD'), 41220);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (41, 2, 3, TO_DATE('2025-08-14','YYYY-MM-DD'), 18500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (42, 5, 3, TO_DATE('2025-08-07','YYYY-MM-DD'), 6012);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (43, 8, 3, TO_DATE('2025-08-21','YYYY-MM-DD'), 34567);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (44, 1, 3, TO_DATE('2025-08-10','YYYY-MM-DD'), 7890);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (45, 7, 3, TO_DATE('2025-08-29','YYYY-MM-DD'), 42100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (46, 4, 3, TO_DATE('2025-08-17','YYYY-MM-DD'), 29876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (47, 9, 3, TO_DATE('2025-08-03','YYYY-MM-DD'), 11223);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (48, 6, 3, TO_DATE('2025-08-26','YYYY-MM-DD'), 36540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (49, 3, 3, TO_DATE('2025-08-09','YYYY-MM-DD'), 23456);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (50, 10, 3, TO_DATE('2025-08-16','YYYY-MM-DD'), 49870);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (51, 1, 3, TO_DATE('2025-08-24','YYYY-MM-DD'), 14500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (52, 5, 3, TO_DATE('2025-08-02','YYYY-MM-DD'), 8900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (53, 8, 3, TO_DATE('2025-08-20','YYYY-MM-DD'), 32100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (54, 2, 3, TO_DATE('2025-08-13','YYYY-MM-DD'), 19876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (55, 9, 3, TO_DATE('2025-08-27','YYYY-MM-DD'), 45678);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (56, 7, 3, TO_DATE('2025-08-06','YYYY-MM-DD'), 28900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (57, 4, 3, TO_DATE('2025-08-18','YYYY-MM-DD'), 13450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (58, 6, 3, TO_DATE('2025-08-12','YYYY-MM-DD'), 39000);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (59, 3, 3, TO_DATE('2025-08-04','YYYY-MM-DD'), 7540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (60, 10, 3, TO_DATE('2025-08-31','YYYY-MM-DD'), 52300);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (61, 5, 3, TO_DATE('2025-08-15','YYYY-MM-DD'), 25450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (62, 8, 3, TO_DATE('2025-08-22','YYYY-MM-DD'), 12340);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (63, 2, 3, TO_DATE('2025-08-05','YYYY-MM-DD'), 56789);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (64, 9, 3, TO_DATE('2025-08-28','YYYY-MM-DD'), 30125);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (65, 1, 3, TO_DATE('2025-08-01','YYYY-MM-DD'), 15750);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (66, 7, 3, TO_DATE('2025-08-19','YYYY-MM-DD'), 48900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (67, 4, 3, TO_DATE('2025-08-11','YYYY-MM-DD'), 21050);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (68, 6, 3, TO_DATE('2025-08-08','YYYY-MM-DD'), 37600);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (69, 3, 3, TO_DATE('2025-08-25','YYYY-MM-DD'), 9850);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (70, 10, 3, TO_DATE('2025-08-30','YYYY-MM-DD'), 41220);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (71, 2, 3, TO_DATE('2025-08-14','YYYY-MM-DD'), 18500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (72, 5, 3, TO_DATE('2025-08-07','YYYY-MM-DD'), 6012);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (73, 8, 3, TO_DATE('2025-08-21','YYYY-MM-DD'), 34567);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (74, 1, 3, TO_DATE('2025-08-10','YYYY-MM-DD'), 7890);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (75, 7, 3, TO_DATE('2025-08-29','YYYY-MM-DD'), 42100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (76, 4, 3, TO_DATE('2025-08-17','YYYY-MM-DD'), 29876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (77, 9, 3, TO_DATE('2025-08-03','YYYY-MM-DD'), 11223);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (78, 6, 3, TO_DATE('2025-08-26','YYYY-MM-DD'), 36540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (79, 3, 3, TO_DATE('2025-08-09','YYYY-MM-DD'), 23456);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (80, 10, 3, TO_DATE('2025-08-16','YYYY-MM-DD'), 49870);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (81, 1, 3, TO_DATE('2025-08-24','YYYY-MM-DD'), 14500);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (82, 5, 3, TO_DATE('2025-08-02','YYYY-MM-DD'), 8900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (83, 8, 3, TO_DATE('2025-08-20','YYYY-MM-DD'), 32100);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (84, 2, 3, TO_DATE('2025-08-13','YYYY-MM-DD'), 19876);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (85, 9, 3, TO_DATE('2025-08-27','YYYY-MM-DD'), 45678);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (86, 7, 3, TO_DATE('2025-08-06','YYYY-MM-DD'), 28900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (87, 4, 3, TO_DATE('2025-08-18','YYYY-MM-DD'), 13450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (88, 6, 3, TO_DATE('2025-08-12','YYYY-MM-DD'), 39000);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (89, 3, 3, TO_DATE('2025-08-04','YYYY-MM-DD'), 7540);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (90, 10, 3, TO_DATE('2025-08-31','YYYY-MM-DD'), 52300);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (91, 5, 3, TO_DATE('2025-08-15','YYYY-MM-DD'), 25450);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (92, 8, 3, TO_DATE('2025-08-22','YYYY-MM-DD'), 12340);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (93, 2, 3, TO_DATE('2025-08-05','YYYY-MM-DD'), 56789);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (94, 9, 3, TO_DATE('2025-08-28','YYYY-MM-DD'), 30125);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (95, 1, 3, TO_DATE('2025-08-01','YYYY-MM-DD'), 15750);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (96, 7, 3, TO_DATE('2025-08-19','YYYY-MM-DD'), 48900);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (97, 4, 3, TO_DATE('2025-08-11','YYYY-MM-DD'), 21050);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (98, 6, 3, TO_DATE('2025-08-08','YYYY-MM-DD'), 37600);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (99, 3, 3, TO_DATE('2025-08-25','YYYY-MM-DD'), 9850);
INSERT INTO FIDE_PEDIDOS_TB (PEDIDOS_ID_PEDIDO_PK, USUARIOS_ID_USUARIO_FK, ESTADOS_ID_ESTADO_FK, FECHA_PEDIDO, TOTAL) VALUES (100, 10, 3, TO_DATE('2025-08-30','YYYY-MM-DD'), 41220);

-- ========================
-- DETALLE PEDIDOS
-- ========================

INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (1, 15, 3, 2, 12500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (2, 8, 3, 1, 34500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (3, 2, 3, 3, 5200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (4, 19, 3, 1, 45600);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (5, 5, 3, 4, 8900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (6, 12, 3, 1, 23450);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (7, 1, 3, 2, 10200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (8, 10, 3, 3, 17800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (9, 7, 3, 1, 5500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (10, 18, 3, 5, 3800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (11, 4, 3, 2, 29000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (12, 16, 3, 1, 16500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (13, 9, 3, 4, 7500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (14, 11, 3, 1, 49800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (15, 6, 3, 2, 21000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (16, 20, 3, 3, 9900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (17, 3, 3, 1, 35000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (18, 14, 3, 2, 18200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (19, 13, 3, 4, 6700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (20, 17, 3, 1, 41000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (21, 8, 3, 2, 13450);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (22, 1, 3, 3, 7890);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (23, 19, 3, 1, 26500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (24, 10, 3, 4, 4500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (25, 6, 3, 1, 31200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (26, 17, 3, 2, 19800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (27, 4, 3, 5, 8750);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (28, 11, 3, 1, 33200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (29, 13, 3, 3, 11500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (30, 20, 3, 2, 27800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (31, 7, 3, 1, 6200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (32, 16, 3, 4, 25600);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (33, 9, 3, 2, 18900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (34, 18, 3, 1, 39500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (35, 5, 3, 3, 7600);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (36, 14, 3, 2, 14300);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (37, 2, 3, 1, 28100);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (38, 15, 3, 4, 9100);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (39, 12, 3, 2, 20400);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (40, 3, 3, 1, 48700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (41, 10, 3, 3, 16900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (42, 1, 3, 2, 32100);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (43, 19, 3, 1, 10500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (44, 8, 3, 4, 25800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (45, 17, 3, 2, 6000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (46, 6, 3, 1, 42300);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (47, 11, 3, 5, 19900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (48, 14, 3, 2, 8500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (49, 13, 3, 3, 35700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (50, 2, 3, 1, 11200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (51, 9, 3, 4, 28000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (52, 18, 3, 2, 14900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (53, 5, 3, 1, 4100);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (54, 20, 3, 3, 22000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (55, 3, 3, 2, 9500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (56, 12, 3, 1, 36000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (57, 16, 3, 4, 13500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (58, 7, 3, 1, 49000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (59, 15, 3, 2, 21500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (60, 4, 3, 3, 8900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (61, 10, 3, 1, 30500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (62, 13, 3, 4, 17200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (63, 1, 3, 2, 25600);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (64, 17, 3, 1, 10500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (65, 8, 3, 3, 4000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (66, 2, 3, 1, 31800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (67, 19, 3, 2, 19000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (68, 5, 3, 4, 6500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (69, 18, 3, 1, 28700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (70, 12, 3, 3, 15500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (71, 6, 3, 2, 45000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (72, 15, 3, 1, 11800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (73, 4, 3, 4, 23900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (74, 16, 3, 2, 9700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (75, 11, 3, 1, 37500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (76, 7, 3, 3, 18400);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (77, 20, 3, 2, 44200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (78, 9, 3, 1, 13100);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (79, 1, 3, 5, 7900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (80, 14, 3, 2, 32000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (81, 17, 3, 1, 10200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (82, 3, 3, 3, 25500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (83, 10, 3, 2, 6500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (84, 19, 3, 1, 41000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (85, 8, 3, 4, 18800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (86, 12, 3, 2, 7200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (87, 6, 3, 1, 29000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (88, 15, 3, 3, 14500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (89, 4, 3, 2, 36800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (90, 16, 3, 1, 10800);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (91, 11, 3, 4, 25500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (92, 7, 3, 2, 5900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (93, 20, 3, 1, 48000);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (94, 9, 3, 3, 12200);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (95, 13, 3, 2, 39500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (96, 5, 3, 1, 8500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (97, 18, 3, 4, 21900);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (98, 2, 3, 2, 16700);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (99, 14, 3, 1, 34500);
INSERT INTO FIDE_DETALLE_PEDIDO_TB (PEDIDOS_ID_PEDIDO_FK, PRODUCTOS_ID_PRODUCTO_FK, ESTADOS_ID_ESTADO_FK, CANTIDAD, PRECIO_UNITARIO) VALUES (100, 3, 3, 3, 9900);
-- ========================
-- METODO PAGO
-- ========================
INSERT INTO FIDE_METODOS_PAGO_TB VALUES (1, 1, 'Efectivo', 'Pago en moneda física');
INSERT INTO FIDE_METODOS_PAGO_TB VALUES (2, 1, 'Tarjeta Crédito', 'Pago con tarjeta de crédito');
INSERT INTO FIDE_METODOS_PAGO_TB VALUES (3, 1, 'Tarjeta Débito', 'Pago con tarjeta de débito');
INSERT INTO FIDE_METODOS_PAGO_TB VALUES (4, 1, 'Transferencia Bancaria', 'Pago vía transferencia electrónica');
INSERT INTO FIDE_METODOS_PAGO_TB VALUES (5, 1, 'Pago Móvil', 'Pago a través de aplicaciones móviles');


-- ========================
-- FACTURAS
-- ========================

INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (1, 1, 1, TO_DATE('2025-08-16', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (2, 2, 2, TO_DATE('2025-08-23', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (3, 3, 3, TO_DATE('2025-08-06', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (4, 4, 1, TO_DATE('2025-08-29', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (5, 5, 2, TO_DATE('2025-08-02', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (6, 6, 3, TO_DATE('2025-08-20', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (7, 7, 1, TO_DATE('2025-08-12', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (8, 8, 2, TO_DATE('2025-08-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (9, 9, 3, TO_DATE('2025-08-26', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (10, 10, 1, TO_DATE('2025-08-31', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (11, 11, 2, TO_DATE('2025-08-15', 'YYYY-MM-DD'), 0.00, 18500.25, 2405.03, 20905.28, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (12, 12, 3, TO_DATE('2025-08-08', 'YYYY-MM-DD'), 0.00, 6012.30, 781.59, 6793.89, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (13, 13, 1, TO_DATE('2025-08-22', 'YYYY-MM-DD'), 0.00, 34567.89, 4493.82, 39061.71, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (14, 14, 2, TO_DATE('2025-08-11', 'YYYY-MM-DD'), 0.00, 7890.15, 1025.72, 8915.87, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (15, 15, 3, TO_DATE('2025-08-30', 'YYYY-MM-DD'), 4210.09, 42100.90, 4925.80, 42816.61, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (16, 16, 1, TO_DATE('2025-08-18', 'YYYY-MM-DD'), 0.00, 29876.54, 3883.95, 33760.49, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (17, 17, 2, TO_DATE('2025-08-04', 'YYYY-MM-DD'), 0.00, 11223.34, 1458.03, 12681.37, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (18, 18, 3, TO_DATE('2025-08-27', 'YYYY-MM-DD'), 0.00, 36540.70, 4750.29, 41290.99, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (19, 19, 1, TO_DATE('2025-08-10', 'YYYY-MM-DD'), 0.00, 23456.95, 3049.40, 26506.35, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (20, 20, 2, TO_DATE('2025-08-17', 'YYYY-MM-DD'), 4987.01, 49870.12, 5834.70, 50717.81, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (21, 21, 3, TO_DATE('2025-08-25', 'YYYY-MM-DD'), 0.00, 14500.67, 1885.09, 16385.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (22, 22, 1, TO_DATE('2025-08-03', 'YYYY-MM-DD'), 0.00, 8900.88, 1157.11, 10057.99, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (23, 23, 2, TO_DATE('2025-08-21', 'YYYY-MM-DD'), 0.00, 32100.40, 4173.05, 36273.45, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (24, 24, 3, TO_DATE('2025-08-14', 'YYYY-MM-DD'), 0.00, 19876.50, 2583.95, 22460.45, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (25, 25, 1, TO_DATE('2025-08-28', 'YYYY-MM-DD'), 4567.89, 45678.91, 5344.43, 46455.45, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (26, 26, 2, TO_DATE('2025-08-07', 'YYYY-MM-DD'), 0.00, 28900.23, 3757.03, 32657.26, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (27, 27, 3, TO_DATE('2025-08-19', 'YYYY-MM-DD'), 0.00, 13450.78, 1748.60, 15199.38, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (28, 28, 1, TO_DATE('2025-08-13', 'YYYY-MM-DD'), 0.00, 39000.56, 5070.07, 44070.63, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (29, 29, 2, TO_DATE('2025-08-05', 'YYYY-MM-DD'), 0.00, 7540.21, 980.23, 8520.44, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (30, 30, 3, TO_DATE('2025-09-01', 'YYYY-MM-DD'), 5230.03, 52300.33, 6116.14, 53186.44, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (31, 31, 1, TO_DATE('2025-08-16', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (32, 32, 2, TO_DATE('2025-08-23', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (33, 33, 3, TO_DATE('2025-08-06', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (34, 34, 1, TO_DATE('2025-08-29', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (35, 35, 2, TO_DATE('2025-08-02', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (36, 36, 3, TO_DATE('2025-08-20', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (37, 37, 1, TO_DATE('2025-08-12', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (38, 38, 2, TO_DATE('2025-08-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (39, 39, 3, TO_DATE('2025-08-26', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (40, 40, 1, TO_DATE('2025-08-31', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (41, 41, 2, TO_DATE('2025-08-15', 'YYYY-MM-DD'), 0.00, 18500.25, 2405.03, 20905.28, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (42, 42, 3, TO_DATE('2025-08-08', 'YYYY-MM-DD'), 0.00, 6012.30, 781.59, 6793.89, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (43, 43, 1, TO_DATE('2025-08-22', 'YYYY-MM-DD'), 0.00, 34567.89, 4493.82, 39061.71, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (44, 44, 2, TO_DATE('2025-08-11', 'YYYY-MM-DD'), 0.00, 7890.15, 1025.72, 8915.87, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (45, 45, 3, TO_DATE('2025-08-30', 'YYYY-MM-DD'), 4210.09, 42100.90, 4925.80, 42816.61, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (46, 46, 1, TO_DATE('2025-08-18', 'YYYY-MM-DD'), 0.00, 29876.54, 3883.95, 33760.49, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (47, 47, 2, TO_DATE('2025-08-04', 'YYYY-MM-DD'), 0.00, 11223.34, 1458.03, 12681.37, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (48, 48, 3, TO_DATE('2025-08-27', 'YYYY-MM-DD'), 0.00, 36540.70, 4750.29, 41290.99, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (49, 49, 1, TO_DATE('2025-08-10', 'YYYY-MM-DD'), 0.00, 23456.95, 3049.40, 26506.35, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (50, 50, 2, TO_DATE('2025-08-17', 'YYYY-MM-DD'), 4987.01, 49870.12, 5834.70, 50717.81, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (51, 51, 3, TO_DATE('2025-08-25', 'YYYY-MM-DD'), 0.00, 14500.67, 1885.09, 16385.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (52, 52, 1, TO_DATE('2025-08-03', 'YYYY-MM-DD'), 0.00, 8900.88, 1157.11, 10057.99, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (53, 53, 2, TO_DATE('2025-08-21', 'YYYY-MM-DD'), 0.00, 32100.40, 4173.05, 36273.45, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (54, 54, 3, TO_DATE('2025-08-14', 'YYYY-MM-DD'), 0.00, 19876.50, 2583.95, 22460.45, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (55, 55, 1, TO_DATE('2025-08-28', 'YYYY-MM-DD'), 4567.89, 45678.91, 5344.43, 46455.45, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (56, 56, 2, TO_DATE('2025-08-07', 'YYYY-MM-DD'), 0.00, 28900.23, 3757.03, 32657.26, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (57, 57, 3, TO_DATE('2025-08-19', 'YYYY-MM-DD'), 0.00, 13450.78, 1748.60, 15199.38, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (58, 58, 1, TO_DATE('2025-08-13', 'YYYY-MM-DD'), 0.00, 39000.56, 5070.07, 44070.63, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (59, 59, 2, TO_DATE('2025-08-05', 'YYYY-MM-DD'), 0.00, 7540.21, 980.23, 8520.44, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (60, 60, 3, TO_DATE('2025-09-01', 'YYYY-MM-DD'), 5230.03, 52300.33, 6116.14, 53186.44, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (61, 61, 1, TO_DATE('2025-08-16', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (62, 62, 2, TO_DATE('2025-08-23', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (63, 63, 3, TO_DATE('2025-08-06', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (64, 64, 1, TO_DATE('2025-08-29', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (65, 65, 2, TO_DATE('2025-08-02', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (66, 66, 3, TO_DATE('2025-08-20', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (67, 67, 1, TO_DATE('2025-08-12', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (68, 68, 2, TO_DATE('2025-08-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (69, 69, 3, TO_DATE('2025-08-26', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (70, 70, 1, TO_DATE('2025-08-31', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (71, 71, 2, TO_DATE('2025-08-15', 'YYYY-MM-DD'), 0.00, 18500.25, 2405.03, 20905.28, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (72, 72, 3, TO_DATE('2025-08-08', 'YYYY-MM-DD'), 0.00, 6012.30, 781.59, 6793.89, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (73, 73, 1, TO_DATE('2025-08-22', 'YYYY-MM-DD'), 0.00, 34567.89, 4493.82, 39061.71, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (74, 74, 2, TO_DATE('2025-08-11', 'YYYY-MM-DD'), 0.00, 7890.15, 1025.72, 8915.87, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (75, 75, 3, TO_DATE('2025-08-30', 'YYYY-MM-DD'), 4210.09, 42100.90, 4925.80, 42816.61, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (76, 76, 1, TO_DATE('2025-08-18', 'YYYY-MM-DD'), 0.00, 29876.54, 3883.95, 33760.49, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (77, 77, 2, TO_DATE('2025-08-04', 'YYYY-MM-DD'), 0.00, 11223.34, 1458.03, 12681.37, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (78, 78, 3, TO_DATE('2025-08-27', 'YYYY-MM-DD'), 0.00, 36540.70, 4750.29, 41290.99, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (79, 79, 1, TO_DATE('2025-08-10', 'YYYY-MM-DD'), 0.00, 23456.95, 3049.40, 26506.35, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (80, 80, 2, TO_DATE('2025-08-17', 'YYYY-MM-DD'), 4987.01, 49870.12, 5834.70, 50717.81, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (81, 81, 3, TO_DATE('2025-08-25', 'YYYY-MM-DD'), 0.00, 14500.67, 1885.09, 16385.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (82, 82, 1, TO_DATE('2025-08-03', 'YYYY-MM-DD'), 0.00, 8900.88, 1157.11, 10057.99, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (83, 83, 2, TO_DATE('2025-08-21', 'YYYY-MM-DD'), 0.00, 32100.40, 4173.05, 36273.45, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (84, 84, 3, TO_DATE('2025-08-14', 'YYYY-MM-DD'), 0.00, 19876.50, 2583.95, 22460.45, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (85, 85, 1, TO_DATE('2025-08-28', 'YYYY-MM-DD'), 4567.89, 45678.91, 5344.43, 46455.45, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (86, 86, 2, TO_DATE('2025-08-07', 'YYYY-MM-DD'), 0.00, 28900.23, 3757.03, 32657.26, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (87, 87, 3, TO_DATE('2025-08-19', 'YYYY-MM-DD'), 0.00, 13450.78, 1748.60, 15199.38, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (88, 88, 1, TO_DATE('2025-08-13', 'YYYY-MM-DD'), 0.00, 39000.56, 5070.07, 44070.63, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (89, 89, 2, TO_DATE('2025-08-05', 'YYYY-MM-DD'), 0.00, 7540.21, 980.23, 8520.44, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (90, 90, 3, TO_DATE('2025-09-01', 'YYYY-MM-DD'), 5230.03, 52300.33, 6116.14, 53186.44, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (91, 91, 1, TO_DATE('2025-08-16', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (92, 92, 2, TO_DATE('2025-08-23', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (93, 93, 3, TO_DATE('2025-08-06', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (94, 94, 1, TO_DATE('2025-08-29', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (95, 95, 2, TO_DATE('2025-08-02', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (96, 96, 3, TO_DATE('2025-08-20', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (97, 97, 1, TO_DATE('2025-08-12', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (98, 98, 2, TO_DATE('2025-08-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (99, 99, 3, TO_DATE('2025-08-26', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (100, 100, 1, TO_DATE('2025-08-31', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (101, 1, 2, TO_DATE('2025-09-02', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (102, 2, 3, TO_DATE('2025-09-03', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (103, 3, 1, TO_DATE('2025-09-04', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (104, 4, 2, TO_DATE('2025-09-05', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (105, 5, 3, TO_DATE('2025-09-06', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (106, 6, 1, TO_DATE('2025-09-07', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (107, 7, 2, TO_DATE('2025-09-08', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (108, 8, 3, TO_DATE('2025-09-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (109, 9, 1, TO_DATE('2025-09-10', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (110, 10, 2, TO_DATE('2025-09-11', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (111, 11, 3, TO_DATE('2025-09-12', 'YYYY-MM-DD'), 0.00, 18500.25, 2405.03, 20905.28, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (112, 12, 1, TO_DATE('2025-09-13', 'YYYY-MM-DD'), 0.00, 6012.30, 781.59, 6793.89, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (113, 13, 2, TO_DATE('2025-09-14', 'YYYY-MM-DD'), 0.00, 34567.89, 4493.82, 39061.71, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (114, 14, 3, TO_DATE('2025-09-15', 'YYYY-MM-DD'), 0.00, 7890.15, 1025.72, 8915.87, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (115, 15, 1, TO_DATE('2025-09-16', 'YYYY-MM-DD'), 4210.09, 42100.90, 4925.80, 42816.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (116, 16, 2, TO_DATE('2025-09-17', 'YYYY-MM-DD'), 0.00, 29876.54, 3883.95, 33760.49, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (117, 17, 3, TO_DATE('2025-09-18', 'YYYY-MM-DD'), 0.00, 11223.34, 1458.03, 12681.37, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (118, 18, 1, TO_DATE('2025-09-19', 'YYYY-MM-DD'), 0.00, 36540.70, 4750.29, 41290.99, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (119, 19, 2, TO_DATE('2025-09-20', 'YYYY-MM-DD'), 0.00, 23456.95, 3049.40, 26506.35, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (120, 20, 3, TO_DATE('2025-09-21', 'YYYY-MM-DD'), 4987.01, 49870.12, 5834.70, 50717.81, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (121, 21, 1, TO_DATE('2025-09-22', 'YYYY-MM-DD'), 0.00, 14500.67, 1885.09, 16385.76, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (122, 22, 2, TO_DATE('2025-09-23', 'YYYY-MM-DD'), 0.00, 8900.88, 1157.11, 10057.99, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (123, 23, 3, TO_DATE('2025-09-24', 'YYYY-MM-DD'), 0.00, 32100.40, 4173.05, 36273.45, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (124, 24, 1, TO_DATE('2025-09-25', 'YYYY-MM-DD'), 0.00, 19876.50, 2583.95, 22460.45, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (125, 25, 2, TO_DATE('2025-09-26', 'YYYY-MM-DD'), 4567.89, 45678.91, 5344.43, 46455.45, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (126, 26, 3, TO_DATE('2025-09-27', 'YYYY-MM-DD'), 0.00, 28900.23, 3757.03, 32657.26, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (127, 27, 1, TO_DATE('2025-09-28', 'YYYY-MM-DD'), 0.00, 13450.78, 1748.60, 15199.38, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (128, 28, 2, TO_DATE('2025-09-29', 'YYYY-MM-DD'), 0.00, 39000.56, 5070.07, 44070.63, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (129, 29, 3, TO_DATE('2025-09-30', 'YYYY-MM-DD'), 0.00, 7540.21, 980.23, 8520.44, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (130, 30, 1, TO_DATE('2025-10-01', 'YYYY-MM-DD'), 5230.03, 52300.33, 6116.14, 53186.44, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (131, 31, 2, TO_DATE('2025-10-02', 'YYYY-MM-DD'), 0.00, 25450.75, 3308.50, 28759.25, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (132, 32, 3, TO_DATE('2025-10-03', 'YYYY-MM-DD'), 0.00, 12340.50, 1604.26, 13944.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (133, 33, 1, TO_DATE('2025-10-04', 'YYYY-MM-DD'), 0.00, 56789.20, 7382.60, 64171.80, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (134, 34, 2, TO_DATE('2025-10-05', 'YYYY-MM-DD'), 0.00, 30125.00, 3916.25, 34041.25, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (135, 35, 3, TO_DATE('2025-10-06', 'YYYY-MM-DD'), 1575.10, 15750.99, 1842.87, 16018.76, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (136, 36, 1, TO_DATE('2025-10-07', 'YYYY-MM-DD'), 0.00, 48900.45, 6357.06, 55257.51, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (137, 37, 2, TO_DATE('2025-10-08', 'YYYY-MM-DD'), 0.00, 21050.10, 2736.51, 23786.61, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (138, 38, 3, TO_DATE('2025-10-09', 'YYYY-MM-DD'), 0.00, 37600.35, 4888.05, 42488.40, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (139, 39, 1, TO_DATE('2025-10-10', 'YYYY-MM-DD'), 0.00, 9850.80, 1280.60, 11131.40, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (140, 40, 2, TO_DATE('2025-10-11', 'YYYY-MM-DD'), 4122.07, 41220.65, 4826.89, 41925.47, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (141, 41, 3, TO_DATE('2025-10-12', 'YYYY-MM-DD'), 0.00, 18500.25, 2405.03, 20905.28, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (142, 42, 1, TO_DATE('2025-10-13', 'YYYY-MM-DD'), 0.00, 6012.30, 781.59, 6793.89, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (143, 43, 2, TO_DATE('2025-10-14', 'YYYY-MM-DD'), 0.00, 34567.89, 4493.82, 39061.71, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (144, 44, 3, TO_DATE('2025-10-15', 'YYYY-MM-DD'), 0.00, 7890.15, 1025.72, 8915.87, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (145, 45, 1, TO_DATE('2025-10-16', 'YYYY-MM-DD'), 4210.09, 42100.90, 4925.80, 42816.61, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (146, 46, 2, TO_DATE('2025-10-17', 'YYYY-MM-DD'), 0.00, 29876.54, 3883.95, 33760.49, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (147, 47, 3, TO_DATE('2025-10-18', 'YYYY-MM-DD'), 0.00, 11223.34, 1458.03, 12681.37, 3);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (148, 48, 1, TO_DATE('2025-10-19', 'YYYY-MM-DD'), 0.00, 36540.70, 4750.29, 41290.99, 1);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (149, 49, 2, TO_DATE('2025-10-20', 'YYYY-MM-DD'), 0.00, 23456.95, 3049.40, 26506.35, 2);
INSERT INTO FIDE_FACTURACION_TB (FACTURACION_ID_FACTURA_PK, PEDIDOS_ID_PEDIDO_FK, METODOS_PAGO_ID_PAGO_FK, FECHA_EMISION, DESCUENTOS, SUBTOTAL, IVA, TOTAL_FACTURADO, ESTADOS_ID_ESTADO_FK) VALUES (150, 50, 3, TO_DATE('2025-10-21', 'YYYY-MM-DD'), 4987.01, 49870.12, 5834.70, 50717.81, 3);



