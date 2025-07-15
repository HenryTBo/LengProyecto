FUNCTION fide_total_pedidos_usuario_fn(
    p_usuario_id IN NUMBER
) RETURN NUMBER;

FUNCTION fide_verificar_stock_producto_fn(
    p_producto_id IN NUMBER
) RETURN NUMBER;

FUNCTION fide_obtener_direccion_fn(
    p_usuario_id IN NUMBER
) RETURN VARCHAR2;

FUNCTION fide_productos_categoria_fn(
    p_categoria_id IN NUMBER
) RETURN NUMBER ;

FUNCTION fide_obtener_nombre_usuario_fn(
    p_usuario_id IN NUMBER
) RETURN VARCHAR2;

FUNCTION fide_calcular_valor_carrito_fn(
    p_usuario_id IN NUMBER
) RETURN NUMBER;

FUNCTION fide_obtener_descripcion_producto_fn(
    p_producto_id IN NUMBER
) RETURN VARCHAR2;

FUNCTION fide_calcular_total_pedido_fn(
    p_pedido_id IN NUMBER
) RETURN NUMBER;