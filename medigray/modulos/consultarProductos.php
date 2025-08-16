<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

function ConsultarProductosModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_LISTAR_PRODUCTOS";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarProductosAdminModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_LISTAR_PRODUCTOS_ADMIN";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}


if (isset($_POST["btnEliminarProducto"])) {
    $idProducto = $_POST["IdProducto"];
    $estadoInactivo = 2; // ID del estado inactivo

    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PRODUCTOS_ELIMINAR_SP(:idProducto, :estadoInactivo); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idProducto", $idProducto);
    oci_bind_by_name($stid, ":estadoInactivo", $estadoInactivo);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        header("Location: ../medigray/ProductosAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El producto no fue actualizado correctamente.";
    }
}

function ConsultarCategoriasModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_CATEGORIAS_LISTAR";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarPresentacionesModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_PRESENTACIONES_LISTAR";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnRegistrarProducto"])) {

    // Datos del formulario
    $id = $_POST["txtId"]; // O puedes calcular el siguiente ID si lo deseas
    $nombre = $_POST["txtNombre"];
    $descripcion = $_POST["txtDescripcion"];
    $precio = $_POST["txtPrecio"];
    $categoria = $_POST["listaCategorias"];
    $presentacion = $_POST["listaPresentaciones"];
    $estado = $_POST["listaEstados"];

    // Manejo de imagen
    $imagen = "/LengProyecto/medigray/images/" . $_FILES["txtImagen"]["name"];
    $origen = $_FILES["txtImagen"]["tmp_name"];
    $destino = $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/images/' . $_FILES["txtImagen"]["name"];
    copy($origen, $destino);

    try {
        // Llamada al SP
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PRODUCTOS_INSERTAR_SP(
                    :p_id, :p_categoria, :p_presentacion, :p_estado, :p_nombre, :p_descripcion, :p_precio, :p_imagen
                ); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
        oci_bind_by_name($stid, ":p_id", $id);
        oci_bind_by_name($stid, ":p_categoria", $categoria);
        oci_bind_by_name($stid, ":p_presentacion", $presentacion);
        oci_bind_by_name($stid, ":p_estado", $estado);
        oci_bind_by_name($stid, ":p_nombre", $nombre);
        oci_bind_by_name($stid, ":p_descripcion", $descripcion);
        oci_bind_by_name($stid, ":p_precio", $precio);
        oci_bind_by_name($stid, ":p_imagen", $imagen);

        // Ejecutar
        $r = oci_execute($stid);

        if ($r) {
            header("Location: ../medigray/ProductosAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "Error al registrar el producto en la base de datos.";
        }

        oci_free_statement($stid);
        oci_close($conn);

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}

function ConsultarInfoProductoModel($idProducto)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM VW_LISTAR_PRODUCTOS_ADMIN WHERE ID_PRODUCTO = :id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":id", $idProducto);
        oci_execute($stid);

        $producto = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $producto;

    } catch (Exception $error) {
        return null;
    }
}


if (isset($_POST["btnActualizarProducto"])) {

    // Obtener datos del formulario
    $idProducto = $_POST["txtId"];
    $nombre = $_POST["txtNombre"];
    $descripcion = $_POST["txtDescripcion"];
    $precio = $_POST["txtPrecio"];
    $categoria = $_POST["listaCategorias"];
    $presentacion = $_POST["listaPresentaciones"];
    $estado = $_POST["listaEstados"];

    try {
        // Incluir conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Llamada al SP de Oracle
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PRODUCTOS_MODIFICAR_SP(
                    :p_id, :p_categoria, :p_presentacion, :p_estado, :p_nombre, :p_descripcion, :p_precio
                ); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
        oci_bind_by_name($stid, ":p_id", $idProducto);
        oci_bind_by_name($stid, ":p_categoria", $categoria);
        oci_bind_by_name($stid, ":p_presentacion", $presentacion);
        oci_bind_by_name($stid, ":p_estado", $estado);
        oci_bind_by_name($stid, ":p_nombre", $nombre);
        oci_bind_by_name($stid, ":p_descripcion", $descripcion);
        oci_bind_by_name($stid, ":p_precio", $precio);

        // Ejecutar
        $respuesta = oci_execute($stid);

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        // Redirigir o mostrar mensaje
        if ($respuesta) {
            header("Location: ../medigray/ProductosAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "El producto no fue actualizado correctamente.";
        }

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}

if (isset($_POST["Accion"]) && $_POST["Accion"] === "AgregarCarrito" && isset($_POST["idProducto"])) {
    $respuesta = AgregarCarritoModel($_POST["idProducto"]);
    if ($respuesta) {
        echo "ok";
    } else {
        echo "El producto no fue agregado a su carrito.";
    }
}


function AgregarCarritoModel($idProducto)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $idUsuario = 1;

        $sql = 'BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_CARRITO_INSERTAR_SP(:pIdUsuario, :pIdProducto); END;';
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":pIdUsuario", $idUsuario);
        oci_bind_by_name($stid, ":pIdProducto", $idProducto);

        $resultado = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $resultado;

    } catch (Exception $error) {
        return false;
    }
}

if (isset($_POST["Accion"]) && $_POST["Accion"] == "EliminarProductoCarrito") {
    $resultado = EliminarProductoCarritoModel($_POST["idCarrito"], $_POST["idProducto"]);
    if ($resultado) {
        echo "OK";
    } else {
        echo "No se pudo eliminar el producto del carrito.";
    }
}

function EliminarProductoCarritoModel($idCarrito, $idProducto)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_CARRITO_ELIMINAR_SP(:idCarrito, :idProducto); END;";
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":idCarrito", $idCarrito);
        oci_bind_by_name($stid, ":idProducto", $idProducto);

        $resultado = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $resultado;

    } catch (Exception $e) {
        return false;
    }
}


function ConsultarCarrito()
{
    return ConsultarCarritoModel();
}

function ConsultarCarritoModel()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
        $idUsuario = 1;

        $sql = "SELECT * FROM VW_CARRITO_DETALLE WHERE IDUSUARIO = :idUsuario";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":idUsuario", $idUsuario);
        oci_execute($stid);

        $carrito = [];
        while ($row = oci_fetch_assoc($stid)) {
            $carrito[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $carrito;

    } catch (Exception $e) {
        return [];
    }
}

function ConsultarPedidosAdminModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_PEDIDOS_LISTAR";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $pedidos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $pedidos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $pedidos;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnEliminarPedido"])) {
    $idPedido = $_POST["idPedidoEliminar"];
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PEDIDOS_ELIMINAR_SP(:idPedido); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idPedido", $idPedido);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        header("Location: ../medigray/PedidosAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El pedido no fue eliminado   correctamente.";
    }
}

function ConsultarInfoPedidoModel($idPedido)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM VW_PEDIDOS_LISTAR WHERE IDPEDIDO = :id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":id", $idPedido);
        oci_execute($stid);

        $pedido = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $pedido;

    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnActualizarPedido"])) {

    // Obtener datos del formulario
    $idPedido = $_POST["txtId"];
    $estado = $_POST["listaEstados"];
    $total = $_POST["txtTotal"];

    try {
        // Incluir conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Llamada al SP de Oracle
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PEDIDOS_MODIFICAR_SP(
                    :p_id, :p_estado, :p_total); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
        oci_bind_by_name($stid, ":p_id", $idPedido);
        oci_bind_by_name($stid, ":p_estado", $estado);
        oci_bind_by_name($stid, ":p_total", $total);

        // Ejecutar
        $respuesta = oci_execute($stid);

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        // Redirigir o mostrar mensaje
        if ($respuesta) {
            header("Location: ../medigray/PedidosAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "El pedido no fue eliminado   correctamente.";
        }

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}

function ConsultarDetallePedidoModel($idPedido)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_DETALLE_PEDIDO_V WHERE ID_PEDIDO = :id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":id", $idPedido);
        oci_execute($stid);

        $pedidos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $pedidos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $pedidos;

    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnEliminarDetallePedido"])) {
    $idPedido = $_POST["idPedidoEliminar"];
    $idProducto = $_POST["idProductoEliminar"];

    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_DETALLE_PEDIDO_ELIMINAR_SP(:idPedido, :idProducto); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idPedido", $idPedido);
    oci_bind_by_name($stid, ":idProducto", $idProducto);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        header("Location: ../medigray/PedidosAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El pedido no fue eliminado   correctamente.";
    }
}

if (isset($_POST["btnActualizarEstadoDetalle"])) {
    $idPedido = $_POST["idPedidoEstado"];
    $idProducto = $_POST["idProductoEstado"];
    $nuevoEstado = $_POST["nuevoEstado"];

    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_DETALLE_PEDIDO_MODIFICAR_SP(:idPedido, :idProducto, :nuevoEstado); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idPedido", $idPedido);
    oci_bind_by_name($stid, ":idProducto", $idProducto);
    oci_bind_by_name($stid, ":nuevoEstado", $nuevoEstado);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        header("Location: ../medigray/PedidosAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El estado del detalle del pedido no fue actualizado correctamente.";
    }

    oci_free_statement($stid);
    oci_close($conn);
}


function ConsultarEstadosModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM FIDE_LISTAR_ESTADOS_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["Accion"]) && $_POST["Accion"] == "ProcesarPagoCarrito") {
    RealizarPagoCarrito();
}

function RealizarPagoCarrito()
{
    $idUsuario = 1;

    $respuesta = RealizarPagoCarritoModel($idUsuario);

    if ($respuesta) {
        echo "OK";
    } else {
        echo "El carrito no fue cancelado correctamente.";
    }
}



function RealizarPagoCarritoModel($idUsuario)
{
    try {
        // Incluir conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Procedimiento PL/SQL
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PEDIDOS_INSERTAR_LOCAL_SP(:idUsuario); END;";
        $stid = oci_parse($conn, $sql);

        // Enlazar parámetros
        oci_bind_by_name($stid, ":idUsuario", $idUsuario);

        // Ejecutar procedimiento
        $respuesta = oci_execute($stid);

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        // Retornar resultado booleano
        return $respuesta;
    } catch (Exception $error) {
        return false;
    }
}

function ConsultarInventarioAdminModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM FIDE_VISTA_INVENTARIO_ADMIN_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $invetario = [];
        while ($row = oci_fetch_assoc($stid)) {
            $invetario[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $invetario;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarInfoInventarioModel($idMovimiento)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_INVENTARIO_ADMIN_V WHERE ID_MOVIMIENTO = :id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":id", $idMovimiento);
        oci_execute($stid);

        $inventario = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $inventario;

    } catch (Exception $error) {
        return null;
    }
}

function ConsultarAlmacenamientosModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_ALMACENAMIENTO_LISTAR";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $almacenados = [];
        while ($row = oci_fetch_assoc($stid)) {
            $almacenados[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $almacenados;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnActualizarInventario"])) {
    $idMovimiento = $_POST["txtId"];
    $cantidadStock = $_POST["txtStock"];
    $idAlmacenado = $_POST["listaAlmacenado"];
    $idEstado = $_POST["listaEstados"];
    $observaciones = $_POST["txtObservaciones"];

    // Conexión a Oracle
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    // Preparar el llamado al procedimiento
    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_INVENTARIO_MODIFICAR_SP(:idMovimiento,:cantidadStock,:idAlmacenado,:idEstado,:observaciones); END;";

    $stid = oci_parse($conn, $sql);

    // Vincular parámetros
    oci_bind_by_name($stid, ":idMovimiento", $idMovimiento);
    oci_bind_by_name($stid, ":cantidadStock", $cantidadStock);
    oci_bind_by_name($stid, ":idAlmacenado", $idAlmacenado);
    oci_bind_by_name($stid, ":idEstado", $idEstado);
    oci_bind_by_name($stid, ":observaciones", $observaciones);

    // Ejecutar
    $respuesta = oci_execute($stid);

    if ($respuesta) {
        // Redirigir a la lista o página de inventario
        header("Location: ../medigray/InventarioAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El inventario no fue actualizado correctamente.";
    }

    oci_free_statement($stid);
    oci_close($conn);
}

if (isset($_POST["btnEliminarMovimiento"])) {
    $resultado = EliminarInventarioModel($_POST["idMovimientoEliminar"]);
    if ($resultado) {
        header("Location: ../medigray/InventarioAdmin.php");
        exit();
    } else {
        echo "No se pudo eliminar el producto del inventario.";
    }
}

function EliminarInventarioModel($idMovimiento)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_INVENTARIO_ELIMINAR_SP(:id); END;";
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":id", $idMovimiento);

        $resultado = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $resultado;
    } catch (Exception $e) {
        return false;
    }
}

function ConsultarProductosInventarioModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM VW_PRODUCTOS_SIN_INVENTARIO";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        // Pasar resultados a un array
        $productos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $productos[] = $row;
        }

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        return $productos;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnAgregarInventario"])) {

    // Datos del formulario
    $idProducto      = $_POST["listaProductos"];
    $cantidadStock   = $_POST["txtStock"];
    $idAlmacen       = $_POST["listaAlmacenado"];
    $idEstado        = $_POST["listaEstados"];
    $observaciones   = $_POST["txtObservaciones"];

    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Llamada al SP
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_INVENTARIO_INSERTAR_SP(
                    :p_producto,
                    :p_estado,
                    :p_almacen,
                    :p_cantidad,
                    :p_observaciones
                ); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
        oci_bind_by_name($stid, ":p_producto", $idProducto);
        oci_bind_by_name($stid, ":p_estado", $idEstado);
        oci_bind_by_name($stid, ":p_almacen", $idAlmacen);
        oci_bind_by_name($stid, ":p_cantidad", $cantidadStock);
        oci_bind_by_name($stid, ":p_observaciones", $observaciones);

        // Ejecutar
        $r = oci_execute($stid);

        if ($r) {
            // Redirigir si se inserta correctamente
            header("Location: ../medigray/InventarioAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "Error al registrar el inventario en la base de datos.";
        }

        oci_free_statement($stid);
        oci_close($conn);

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}


?>