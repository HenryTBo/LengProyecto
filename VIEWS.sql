-- Vista catalogo de productos con categoria presentacion precio stock y estado
CREATE OR REPLACE VIEW fide_vw_catalogo_productos AS
    SELECT
        p.producto_id_producto_pk   AS id_producto,
        p.nombre    AS nombre_producto,
        c.nombre_categoria,
        pr.tipo_presentacion,
        p.descripcion,
        p.precio_unitario,
        nvl(SUM(i.cantidad_stock), 0)    AS stock_disponible,
        e.nombre_estado    AS estado
    FROM
             fide_productos_tb p
        JOIN fide_categoria_tb       c ON c.categoria_id_categoria_pk = p.categoria_id_categoria_fk
        JOIN fide_presentaciones_tb  pr ON pr.presentaciones_id_presentacion_pk = p.presentaciones_id_presentacion_fk
        JOIN fide_estados_tb  e ON e.estados_id_estado_pk = p.estados_id_estado_fk
        LEFT JOIN fide_inventario_tb  i ON i.productos_id_producto_fk = p.producto_id_producto_pk
AND i.estados_id_estado_fk = p.estados_id_estado_fk
    GROUP BY
        p.producto_id_producto_pk,
        p.nombre,
        c.nombre_categoria,
        pr.tipo_presentacion,
        p.descripcion,
        p.precio_unitario,
        e.nombre_estado;

-- Vista detalle de carrito de compras con usuario producto cantidad total y estado
CREATE OR REPLACE VIEW fide_vw_detalle_carrito AS
    SELECT
        ca.carrito_id_carrito_pk AS id_carrito,
        u.usuario_id_usuario_pk AS id_usuario,
        u.nombre AS nombre_usuario,
        pr.producto_id_producto_pk AS id_producto,
        pr.nombre   AS nombre_producto,
        ca.cantidad,
        pr.precio_unitario,
        ca.cantidad * pr.precio_unitario AS total_linea,
        ca.fecha_agregado,
        es.nombre_estado AS estado_item
    FROM
             fide_carrito_tb ca
        JOIN fide_usuarios_tb   u ON u.usuario_id_usuario_pk = ca.usuarios_id_usuario_fk
        JOIN fide_productos_tb  pr ON pr.producto_id_producto_pk = ca.productos_id_producto_fk
        JOIN fide_estados_tb    es ON es.estados_id_estado_pk = ca.estados_id_estado_fk;

-- Vista resumen de pedidos con usuario fecha total y estado
CREATE OR REPLACE VIEW fide_vw_pedidos_resumen AS
    SELECT
        p.pedidos_id_pedido_pk  AS id_pedido,
        u.usuario_id_usuario_pk  AS id_usuario,
        u.nombre  AS nombre_usuario,
        p.fecha_pedido,
        p.total,
        es.nombre_estado AS estado_pedido
    FROM
             fide_pedidos_tb p
        JOIN fide_usuarios_tb  u ON u.usuario_id_usuario_pk = p.usuarios_id_usuario_fk
        JOIN fide_estados_tb   es ON es.estados_id_estado_pk = p.estados_id_estado_fk;

-- Vista detalle de productos en cada pedido con cantidad precio y estado
CREATE OR REPLACE VIEW fide_vw_detalle_pedido AS
    SELECT
        d.detalle_pedido_id_detalle_pk AS id_detalle,
        d.pedidos_id_pedido_fk AS id_pedido,
        pr.producto_id_producto_pk AS id_producto,
        pr.nombre  AS nombre_producto,
        d.cantidad,
        d.precio_unitario,
        d.cantidad * d.precio_unitario AS subtotal,
        es.nombre_estado  AS estado_detalle
    FROM
             fide_detalle_pedido_tb d
        JOIN fide_productos_tb  pr ON pr.producto_id_producto_pk = d.productos_id_producto_fk
        JOIN fide_estados_tb    es ON es.estados_id_estado_pk = d.estados_id_estado_fk;

-- Vista facturas de usuario con pedido fecha montos metodo de pago y estado
CREATE OR REPLACE VIEW fide_vw_facturas_usuario AS
    SELECT
        f.facturacion_id_factura_pk AS id_factura,
        p.pedidos_id_pedido_pk   AS id_pedido,
        u.usuario_id_usuario_pk  AS id_usuario,
        u.nombre  AS nombre_usuario,
        f.fecha_emision,
        f.subtotal,
        f.descuentos,
        f.iva,
        f.total_facturado,
        mp.nombre_metodo  AS metodo_pago,
        es.nombre_estado  AS estado_factura
    FROM
             fide_facturacion_tb f
        JOIN fide_pedidos_tb  p ON p.pedidos_id_pedido_pk = f.pedidos_id_pedido_fk
        JOIN fide_usuarios_tb  u ON u.usuario_id_usuario_pk = p.usuarios_id_usuario_fk
        JOIN fide_metodos_pago_tb  mp ON mp.metodos_pago_id_pago_pk = f.metodos_pago_id_pago_fk
        JOIN fide_estados_tb       es ON es.estados_id_estado_pk = f.estados_id_estado_fk;