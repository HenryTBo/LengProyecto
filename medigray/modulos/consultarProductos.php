<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function ConsultarProductosModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM FIDE_LISTAR_PRODUCTOS_V";
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


if (isset($_POST["busqueda"])) {
    $busqueda = trim($_POST["busqueda"]);
    $productos = BuscarProductosModel($busqueda);

    if ($productos && count($productos) > 0) {
        foreach ($productos as $row) {
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card product-card shadow-sm h-100">
                    <div class="product-img-container d-flex align-items-center justify-content-center bg-light"
                        style="height: 150px;">
                        <img src="<?php echo $row['IMAGEN']; ?>" alt="" style="display: block; margin:auto;" width="150"
                            height="125">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <span
                            class="product-category text-secondary fst-italic mb-1"><?php echo str_replace('_', ' ', $row["NOMBRE_CATEGORIA"]); ?></span>
                        <h3 class="product-title mt-1"><?php echo $row["NOMBRE_PRODUCTO"]; ?></h3>
                        <p class="product-description flex-grow-1 mb-2"><?php echo $row["DESCRIPCION_PRODUCTO"]; ?></p>
                        <ul class="list-unstyled mb-3">
                            <li><strong>Precio:</strong> $<?php echo number_format($row["PRECIO_UNITARIO"], 2); ?></li>
                            <li><strong>Presentación:</strong> <?php echo $row["TIPO_PRESENTACION"]; ?></li>
                            <li><strong>Descripción:</strong> <?php echo $row["DESCRIPCION_PRESENTACION"]; ?></li>
                        </ul>
                        <div class="mt-auto text-center">
                            <button class="btn btn-primary" onclick="AgregarCarrito(<?php echo $row['ID_PRODUCTO']; ?>)">
                                <i class="bi bi-cart"></i> Agregar al carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<h3 class='h4 mt-3'>No se encontraron productos</h3>";
    }
    exit;
}
function BuscarProductosModel($busqueda)
{
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    if ($busqueda == '') {
        $sql = "SELECT * FROM FIDE_LISTAR_PRODUCTOS_V";
        $stid = oci_parse($conn, $sql);
    } else {
        $sql = "SELECT * FROM FIDE_LISTAR_PRODUCTOS_V
                WHERE LOWER(NOMBRE_PRODUCTO) LIKE '%' || LOWER(:busqueda) || '%'";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":busqueda", $busqueda);
    }

    oci_execute($stid);

    $productos = [];
    while ($row = oci_fetch_assoc($stid)) {
        $productos[] = $row;
    }

    oci_free_statement($stid);
    oci_close($conn);

    return $productos;
}



function ConsultarProductosAdminModel()
{
    try {
        // Incluimos la conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Consulta a la vista
        $sql = "SELECT * FROM FIDE_LISTAR_PRODUCTOS_ADMIN_V";
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
        $sql = "SELECT * FROM FIDE_CATEGORIAS_LISTAR_V";
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
        $sql = "SELECT * FROM FIDE_PRESENTACIONES_LISTAR_V";
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
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PRODUCTOS_INSERTAR_SP(:p_categoria, :p_presentacion, :p_estado, :p_nombre, :p_descripcion, :p_precio, :p_imagen
                ); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
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

        $sql = "SELECT * FROM FIDE_LISTAR_PRODUCTOS_ADMIN_V WHERE ID_PRODUCTO = :id";
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

        $idUsuario = $_SESSION["idUsuario"];

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
        if (!isset($_SESSION["idUsuario"])) {
            throw new Exception("Usuario no autenticado");
        }
        $idUsuario = $_SESSION["idUsuario"];

        $sql = "SELECT * FROM FIDE_CARRITO_DETALLE_V WHERE IDUSUARIO = :idUsuario";
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
        $sql = "SELECT * FROM FIDE_PEDIDOS_LISTAR_V";
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

        $sql = "SELECT * FROM FIDE_PEDIDOS_LISTAR_V WHERE IDPEDIDO = :id";
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

function ConsultarPedidosUsuario($idUsuario)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_PEDIDOS_USUARIO_V WHERE USUARIOS_ID_USUARIO_FK = :idUsuario ORDER BY FECHA_PEDIDO DESC";

        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":idUsuario", $idUsuario);
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
    // Iniciar sesión si no está iniciada

    // Verificar que haya un usuario autenticado
    if (!isset($_SESSION["idUsuario"])) {
        echo "Debe iniciar sesión primero.";
        exit;
    }

    $idUsuario = $_SESSION["idUsuario"];

    // Llamada al modelo
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
        $sql = "SELECT * FROM FIDE_ALMACENAMIENTO_LISTAR_V";
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
        $sql = "SELECT * FROM FIDE_PRODUCTOS_SIN_INVENTARIO_V";
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
    $idProducto = $_POST["listaProductos"];
    $cantidadStock = $_POST["txtStock"];
    $idAlmacen = $_POST["listaAlmacenado"];
    $idEstado = $_POST["listaEstados"];
    $observaciones = $_POST["txtObservaciones"];

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

if (isset($_POST["btnRegistrarUsuario"])) {
    $nombre = $_POST["txtNombre"];
    $email = $_POST["txtEmail"];
    $telefono = $_POST["txtTelefono"];
    $contrasena = $_POST["txtContrasena"];

    // Conexión a Oracle
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    // Preparar el llamado al procedimiento
    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_USUARIOS_INSERTAR_SP(
                    :p_nombre,
                    :p_email,
                    :p_telefono,
                    :p_contrasena
                ); END;";

    $stid = oci_parse($conn, $sql);

    // Vincular parámetros
    oci_bind_by_name($stid, ":p_nombre", $nombre);
    oci_bind_by_name($stid, ":p_email", $email);
    oci_bind_by_name($stid, ":p_telefono", $telefono);
    oci_bind_by_name($stid, ":p_contrasena", $contrasena);
    // Ejecutar
    $respuesta = oci_execute($stid);

    if (!$respuesta) {
        $e = oci_error($stid);
        echo "Error Oracle: " . $e['message'];
        exit;
    }
    if ($respuesta) {
        // Redirigir a la lista o página de inventario
        header("Location: ../medigray/inicio.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "El inventario no fue actualizado correctamente.";
    }

    oci_free_statement($stid);
    oci_close($conn);
}

if (isset($_POST["btnIniciarSesion"])) {
    $correo = $_POST["txtCorreo"];
    $contrasenna = $_POST["txtContrasenna"];

    $sql = "BEGIN :p_id := FIDE_PROYECTO_FINAL_PKG.FIDE_VALIDAR_LOGIN_FN(:p_correo, :p_contrasena); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":p_correo", $correo);
    oci_bind_by_name($stid, ":p_contrasena", $contrasenna);
    oci_bind_by_name($stid, ":p_id", $idUsuario);


    oci_execute($stid);

    if ($idUsuario && $idUsuario > 0) {
        $_SESSION["idUsuario"] = $idUsuario;

        // Obtener tipo de usuario
        $sql2 = "BEGIN :p_tipo := FIDE_PROYECTO_FINAL_PKG.FIDE_TRAER_TIPO_USUARIO_FN(:p_correo, :p_contrasena); END;";
        $stid2 = oci_parse($conn, $sql2);

        oci_bind_by_name($stid2, ":p_correo", $correo);
        oci_bind_by_name($stid2, ":p_contrasena", $contrasenna);
        oci_bind_by_name($stid2, ":p_tipo", $tipoUsuario, 32);

        oci_execute($stid2);

        $_SESSION["tipoUsuario"] = $tipoUsuario;

        // Redirigir según tipo
        if ($tipoUsuario == 11) {
            header("Location: ../medigray/Home.php"); // Cliente
        } else {
            header("Location: ../medigray/AdminDashboard.php"); // Personal interno
        }
        exit;
    }
}

if (isset($_POST["btnCerrarSesion"])) {
    session_start();
    session_unset();
    session_destroy();

    header("Location: ../medigray/Inicio.php");
    exit;
}

if (isset($_POST["btnGuardarDireccion"])) {
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $idUsuario = $_SESSION["idUsuario"];
    $pais = $_POST["paises"];
    $provincia = $_POST["provincias"];
    $canton = $_POST["cantones"];
    $distrito = $_POST["distritos"];
    $otrasSenas = $_POST["direccionExacta"];

    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_DIRECCIONES_INSERTAR_SP(:idUsuario, :pais, :provincia, :canton, :distrito, :otrasSenas); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idUsuario", $idUsuario);
    oci_bind_by_name($stid, ":pais", $pais);
    oci_bind_by_name($stid, ":provincia", $provincia);
    oci_bind_by_name($stid, ":canton", $canton);
    oci_bind_by_name($stid, ":distrito", $distrito);
    oci_bind_by_name($stid, ":otrasSenas", $otrasSenas);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        $_POST["txtMensaje"] = 'Su direccion se guardo';
    } else {
        $_POST["txtMensaje"] = 'No se pudo guardar la dirección.';
    }

    oci_free_statement($stid);
    oci_close($conn);
}

function ConsultarPaises() {
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_PAISES_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $paises = [];
        while ($row = oci_fetch_assoc($stid)) {
            $paises[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $paises;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarProvincias() {
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_PROVINCIAS_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $provincias = [];
        while ($row = oci_fetch_assoc($stid)) {
            $provincias[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $provincias;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarCantones() {
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_CANTONES_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $cantones = [];
        while ($row = oci_fetch_assoc($stid)) {
            $cantones[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $cantones;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarDistritos() {
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_DISTRITOS_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $distritos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $distritos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $distritos;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarDireccionUsuario($idUsuario) {
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT * FROM FIDE_VISTA_DIRECCION_USUARIO_V WHERE USUARIOS_ID_USUARIO_FK = :idUsuario";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":idUsuario", $idUsuario);
        oci_execute($stid);

        $direccion = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $direccion ?: null;
    } catch (Exception $error) {
        return null;
    }
}

function UsuarioTieneDireccion($idUsuario) {
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    $sql = "SELECT FIDE_PROYECTO_FINAL_PKG.FIDE_FN_USUARIO_TIENE_DIRECCION(:idUsuario) AS TIENE_DIRECCION FROM DUAL";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ":idUsuario", $idUsuario);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);
    oci_free_statement($stid);
    oci_close($conn);

    return $row['TIENE_DIRECCION'] == 1;
}

if (isset($_POST["Accion"]) && $_POST["Accion"] === "VerificarDireccion") {
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarUsuarios.php';
    $idUsuario = $_SESSION["idUsuario"];

    if (UsuarioTieneDireccion($idUsuario)) {
        echo "SI";
    } else {
        echo "NO";
    }
    exit; // importante para que no siga ejecutando nada más
}

?>