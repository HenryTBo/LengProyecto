<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$idUsuario = $_SESSION["idUsuario"];

function ConsultarFacturacionAdminModel($offset = 0, $limit = 100)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usar vista SQL existente como en ProductosAdmin.php
        $sql = "SELECT * FROM FIDE_FACTURACION_LISTA_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $facturacion = [];
        while ($row = oci_fetch_assoc($stid)) {
            $facturacion[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $facturacion;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnGenerarFactura"])) {
    $idPedido = (int) $_POST["listaPedidos"];
    $metodoPago = (int) $_POST["listaMetodosPago"];

    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Preparar la llamada al SP
        $sql = "BEGIN
                    FIDE_PROYECTO_FINAL_PKG.GENERAR_FACTURA(
                        p_pedido_id   => :p_pedido_id,
                        p_metodo_pago => :p_metodo_pago
                    );
                END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros
        oci_bind_by_name($stid, ":p_pedido_id", $idPedido);
        oci_bind_by_name($stid, ":p_metodo_pago", $metodoPago);

        // Ejecutar SP
        $r = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        if ($r) {
            $mensaje = "Factura generada correctamente.";
            header("Location: FacturacionAdmin.php");
            exit;
        } else {
            $mensaje = "Error al generar la factura.";
        }

    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

function ConsultarInfoFacturaModel($idFactura)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Seleccionamos la factura por su ID usando la misma vista
        $sql = "SELECT * FROM FIDE_FACTURACION_LISTA_V WHERE FACTURACION_ID_FACTURA_PK = :idFactura";
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":idFactura", $idFactura);
        oci_execute($stid);

        $factura = oci_fetch_assoc($stid); // Devuelve solo una fila

        oci_free_statement($stid);
        oci_close($conn);

        return $factura; // Retorna el array asociativo de la factura
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST["btnActualizarFactura"])) {
    // Obtener datos del formulario y convertirlos a float
    $idFactura = (int) $_POST["txtIdFactura"];
    $descuentos = number_format((float) $_POST["txtDescuentos"], 0, '.', '');
    $subtotal = number_format((float) $_POST["txtSubtotal"], 0, '.', '');
    $iva = number_format((float) $_POST["txtIVA"], 0, '.', '');
    $total = number_format((float) $_POST["txtTotal"], 0, '.', '');
    $metodoPago = (int) $_POST["listaMetodosPago"];
    $estado = (int) $_POST["listaEstados"];

    try {
        // Incluir conexión
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Preparar llamada al SP
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_MODIFICAR_SP(
                    :p_factura_id,
                    :p_descuentos,
                    :p_subtotal,
                    :p_iva,
                    :p_total,
                    :p_metodo_pago,
                    :p_estado
                ); END;";

        $stid = oci_parse($conn, $sql);

        // Vincular parámetros (reservando espacio suficiente para floats)
        oci_bind_by_name($stid, ":p_factura_id", $idFactura);
        oci_bind_by_name($stid, ":p_descuentos", $descuentos, 32);
        oci_bind_by_name($stid, ":p_subtotal", $subtotal, 32);
        oci_bind_by_name($stid, ":p_iva", $iva, 32);
        oci_bind_by_name($stid, ":p_total", $total, 32);
        oci_bind_by_name($stid, ":p_metodo_pago", $metodoPago);
        oci_bind_by_name($stid, ":p_estado", $estado);

        // Ejecutar SP
        $respuesta = oci_execute($stid);

        // Liberar recursos
        oci_free_statement($stid);
        oci_close($conn);

        // Redirigir o mostrar mensaje
        if ($respuesta) {
            header("Location: ../medigray/FacturacionAdmin.php");
            exit;
        } else {
            $mensaje = "La factura no fue actualizada correctamente.";
        }
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
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

function ConsultarContactosAdminModel()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usar vista SQL existente como en ProductosAdmin.php
        $sql = "SELECT * FROM FIDE_CONTACTOS_ADMIN_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $contactos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $contactos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $contactos;
    } catch (Exception $error) {
        return null;
    }
}

if (isset($_POST['btnMarcarLeido'])) {
    $contactoId = (int) $_POST['contacto_id'];

    try {
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_CONTACTO_ELIMINAR_SP(:p_contacto_id); END;";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":p_contacto_id", $contactoId);
        $respuesta = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        if ($respuesta) {
            header("Location: ContactosAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "No se pudo actualizar el estado del contacto.";
        }

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}


function ConsultarMetodosPagoModel()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usar vista SQL existente como en ProductosAdmin.php
        $sql = "SELECT * FROM FIDE_METODOS_PAGO_LISTAR_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $contactos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $contactos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $contactos;
    } catch (Exception $error) {
        return null;
    }
}

function ConsultarPedidoPendienteUsuario($idUsuario)
{
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    try {
        $sql = "SELECT * FROM FIDE_PEDIDOS_PENDIENTES_V WHERE USUARIOS_ID_USUARIO_FK = :idUsuario";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":idUsuario", $idUsuario);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        oci_free_statement($stid);
        oci_close($conn);
        return $row ? $row : null; // retornamos todo el pedido, no solo ID
    } catch (Exception $e) {
        return null;
    }
}

function GenerarFacturaDomicilio($pedido, $metodo_pago)
{
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    try {
        // Forzar tipos numéricos
        $pedido_id = (int) $pedido['PEDIDOS_ID_PEDIDO_PK'];
        $subtotal = round((float) $pedido['TOTAL'], 2);
        $iva = round($subtotal * 0.13, 2); // 13% ejemplo
        $descuento = round(0.0, 2); // si aplica
        $total = round($subtotal + $iva - $descuento, 2);
        $metodo_pago = (int) $metodo_pago;

        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_GENERAR_SP(
                    :p_pedido_id, 
                    :p_metodo_pago, 
                    :p_total_facturado, 
                    :p_subtotal, 
                    :p_iva, 
                    :p_descuentos
                ); END;";

        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":p_pedido_id", $pedido_id);
        oci_bind_by_name($stid, ":p_metodo_pago", $metodo_pago);
        oci_bind_by_name($stid, ":p_total_facturado", $total);
        oci_bind_by_name($stid, ":p_subtotal", $subtotal);
        oci_bind_by_name($stid, ":p_iva", $iva);
        oci_bind_by_name($stid, ":p_descuentos", $descuento);

        $r = oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        return $r;
    } catch (Exception $e) {
        return false;
    }
}



if (isset($_POST['btnPagar'])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

    session_start();
    $idUsuario = $_SESSION["idUsuario"];
    $pedidoPendiente = ConsultarPedidoPendienteUsuario($idUsuario);

    if ($pedidoPendiente) {
        $metodoPago = $_POST['metodoPago'];

        // Llamamos a la función pasando todo el pedido
        $resultado = GenerarFacturaDomicilio($pedidoPendiente, $metodoPago);

        if ($resultado === true) {
            echo "<script>alert('Factura generada correctamente'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Error al generar la factura');</script>";
        }
    } else {
        echo "<script>alert('No hay pedidos pendientes'); window.location.href='home.php';</script>";
    }
}


if (isset($_POST["btnCancelarFactura"])) {
    $idFactura = $_POST["idFacturaCancelar"];

    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

    // Llamamos el procedimiento para cancelar factura
    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_ELIMINAR_SP(:idFactura); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":idFactura", $idFactura);

    $respuesta = oci_execute($stid);

    if ($respuesta) {
        header("Location: ../FacturacionAdmin.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "La factura no pudo ser cancelada correctamente.";
    }
}

function ConsultarTodosPedidosPendientes()
{
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    try {
        $sql = "SELECT * FROM FIDE_PEDIDOS_PENDIENTES_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $pedidos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $pedidos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $pedidos;
    } catch (Exception $e) {
        return [];
    }
}

function ConsultarUsuariosAdminModel()
{
    include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    try {
        $sql = "SELECT * FROM FIDE_USUARIOS_ADMIN_V";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $usuarios = [];
        while ($row = oci_fetch_assoc($stid)) {
            $usuarios[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $usuarios;
    } catch (Exception $e) {
        return [];
    }
}

if (isset($_POST['btnInactivarUsuario'])) {
    $idUsuario = (int) $_POST['IdUsuario']; // viene del modal

    try {
        // Llamada al SP para inactivar usuario
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_USUARIOS_ELIMINAR_SP(:p_usuario_id); END;";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ":p_usuario_id", $idUsuario);
        $respuesta = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        if ($respuesta) {
            header("Location: UsuariosAdmin.php");
            exit;
        } else {
            $_POST["txtMensaje"] = "No se pudo inactivar el usuario.";
        }

    } catch (Exception $e) {
        $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    }
}

if (isset($_POST['btnEnviarContacto'])) {

    $idUsuario = $idUsuario = $_SESSION["idUsuario"];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];


    try {
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_CONTACTO_INSERTAR_SP(:p_usuario_id, :p_asunto, :p_mensaje); END;";
        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":p_usuario_id", $idUsuario);
        oci_bind_by_name($stid, ":p_asunto", $asunto);
        oci_bind_by_name($stid, ":p_mensaje", $mensaje);

        $respuesta = oci_execute($stid);

        oci_free_statement($stid);
        oci_close($conn);

        if ($respuesta) {
            $_POST['txtMensaje'] = "Mensaje enviado correctamente.";
        } else {
            $_POST['txtMensaje'] = "No se pudo enviar el mensaje, inténtalo de nuevo.";
        }

    } catch (Exception $e) {
        $_POST['txtMensaje'] = "Error al enviar mensaje: " . $e->getMessage();
    }

    header("Location: contacto.php");
    exit;
}
?>