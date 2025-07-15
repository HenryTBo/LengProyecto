--Calcular el total de pedidos de un usuario
FUNCTION fide_total_pedidos_usuario_fn(
    p_usuario_id IN NUMBER
) RETURN NUMBER IS
    v_total NUMBER := 0;
    CURSOR c_pedidos IS
        SELECT SUM(TOTAL)
        FROM FIDE_PEDIDOS_TB
        WHERE USUARIOS_ID_USUARIO_FK = p_usuario_id;
BEGIN
    OPEN c_pedidos;
    FETCH c_pedidos INTO v_total;
    CLOSE c_pedidos;
    RETURN NVL(v_total, 0);
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
END fide_total_pedidos_usuario_fn;

--Verificar Stock disponible
FUNCTION fide_verificar_stock_producto_fn(
    p_producto_id IN NUMBER
) RETURN NUMBER IS
    v_stock NUMBER := 0;
    CURSOR c_stock IS
        SELECT SUM(CANTIDAD_STOCK)
        FROM FIDE_INVENTARIO_TB
        WHERE PRODUCTOS_ID_PRODUCTO_FK = p_producto_id;
BEGIN
    OPEN c_stock;
    FETCH c_stock INTO v_stock;
    CLOSE c_stock;
    RETURN NVL(v_stock, 0);
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
END fide_verificar_stock_producto_fn;

--Obtener direccion completa de un Usuario
FUNCTION fide_obtener_direccion_fn(
    p_usuario_id IN NUMBER
) RETURN VARCHAR2 IS
    v_direccion VARCHAR2(1000);
    CURSOR c_dir IS
        SELECT 
            p.NOMBRE_PAIS || ', ' || 
            pr.NOMBRE_PROVINCIA || ', ' || 
            c.NOMBRE_CANTON || ', ' || 
            d.NOMBRE_DISTRITO || ', ' || 
            dir.OTRAS_SENAS
        FROM FIDE_DIRECCIONES_TB dir
        JOIN FIDE_PAISES_TB p ON dir.PAISES_ID_PAIS_FK = p.PAISES_ID_PAIS_PK
        JOIN FIDE_PROVINCIAS_TB pr ON dir.PROVINCIAS_ID_PROVINCIA_FK = pr.PROVINCIAS_ID_PROVINCIA_PK
        JOIN FIDE_CANTONES_TB c ON dir.CANTONES_ID_CANTON_FK = c.CANTONES_ID_CANTON_PK
        JOIN FIDE_DISTRITOS_TB d ON dir.DISTRITOS_ID_DISTRITO_FK = d.DISTRITOS_ID_DISTRITO_PK
        WHERE dir.USUARIOS_ID_USUARIO_FK = p_usuario_id;
BEGIN
    OPEN c_dir;
    FETCH c_dir INTO v_direccion;
    CLOSE c_dir;
    RETURN v_direccion;
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
    WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
END fide_obtener_direccion_fn;

--Contar productos por categoria
FUNCTION fide_productos_categoria_fn(
    p_categoria_id IN NUMBER
) RETURN NUMBER IS
    v_cantidad NUMBER := 0;
    
    CURSOR c_productos IS
        SELECT COUNT(*)
        FROM FIDE_PRODUCTOS_TB
        WHERE CATEGORIA_ID_CATEGORIA_FK = p_categoria_id;
BEGIN
    OPEN c_productos;
    FETCH c_productos INTO v_cantidad;
    CLOSE c_productos;
    
    RETURN NVL(v_cantidad, 0);
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
        RETURN 0;
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
        RETURN NULL;
END fide_productos_categoria_fn;

--Obtener el nombre completo de un Usuario y email
FUNCTION fide_obtener_nombre_usuario_fn(
    p_usuario_id IN NUMBER
) RETURN VARCHAR2 IS
    v_nombre_completo VARCHAR2(200);
    
    CURSOR c_usuario IS
        SELECT NOMBRE, EMAIL
        FROM FIDE_USUARIOS_TB
        WHERE USUARIO_ID_USUARIO_PK = p_usuario_id;
BEGIN
    FOR usuario_rec IN c_usuario LOOP
        v_nombre_completo := usuario_rec.NOMBRE || ' (' || usuario_rec.EMAIL || ')';
    END LOOP;
    
    RETURN v_nombre_completo;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
        RETURN 'Usuario no encontrado';
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
        RETURN NULL;
END fide_obtener_nombre_usuario_fn;

--Calcular el valor de un carrito

FUNCTION fide_calcular_valor_carrito_fn(
    p_usuario_id IN NUMBER
) RETURN NUMBER IS
    v_total NUMBER := 0;
    CURSOR c_carrito IS
        SELECT SUM(p.PRECIO_UNITARIO * c.CANTIDAD)
        FROM FIDE_CARRITO_TB c
        JOIN FIDE_PRODUCTOS_TB p ON c.PRODUCTOS_ID_PRODUCTO_FK = p.PRODUCTO_ID_PRODUCTO_PK
        WHERE c.USUARIOS_ID_USUARIO_FK = p_usuario_id;
BEGIN
    OPEN c_carrito;
    FETCH c_carrito INTO v_total;
    CLOSE c_carrito;
    RETURN NVL(v_total, 0);
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('NO SE ENCONTRARON DATOS');
        RETURN 'Usuario no encontrado';
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('ERROR:'||SQLERRM);
        RETURN NULL;
END fide_calcular_valor_carrito_fn;

--Obtener toda la descripcion completa de un producto

FUNCTION fide_obtener_descripcion_producto_fn(
    p_producto_id IN NUMBER
) RETURN VARCHAR2 IS
    v_descripcion_completa VARCHAR2(500);
    
    CURSOR c_producto IS
        SELECT p.NOMBRE || ' - ' || p.DESCRIPCION || ' (Presentación: ' || pr.TIPO_PRESENTACION || ')' AS descripcion
        FROM FIDE_PRODUCTOS_TB p
        JOIN FIDE_PRESENTACIONES_TB pr ON p.PRESENTACIONES_ID_PRESENTACION_FK = pr.PRESENTACIONES_ID_PRESENTACION_PK
        WHERE p.PRODUCTO_ID_PRODUCTO_PK = p_producto_id;
BEGIN
    OPEN c_producto;
    FETCH c_producto INTO v_descripcion_completa;
    CLOSE c_producto;
    
    RETURN v_descripcion_completa;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Producto no encontrado');
        RETURN 'Descripción no disponible';
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error al obtener descripción: '||SQLERRM);
        RETURN NULL;
        
END fide_obtener_descripcion_producto_fn;

--Obtener el valor total de un pedido
FUNCTION fide_calcular_total_pedido_fn(
    p_pedido_id IN NUMBER
) RETURN NUMBER IS
    v_total_pedido NUMBER := 0;
    
    CURSOR c_detalle_pedido IS
        SELECT SUM(dp.CANTIDAD * dp.PRECIO_UNITARIO)
        FROM FIDE_DETALLE_PEDIDO_TB dp
        WHERE dp.PEDIDOS_ID_PEDIDO_FK = p_pedido_id
        AND dp.ESTADOS_ID_ESTADO_FK = 1; 
BEGIN
    OPEN c_detalle_pedido;
    FETCH c_detalle_pedido INTO v_total_pedido;
    CLOSE c_detalle_pedido;
    
    RETURN NVL(v_total_pedido, 0);
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('No se encontraron detalles para el pedido');
        RETURN 0;
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error al calcular total del pedido: '||SQLERRM);
        RETURN NULL;
END fide_calcular_total_pedido_fn;
