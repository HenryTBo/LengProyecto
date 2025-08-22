<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

// --- POST de GUARDAR = crear nueva factura ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnGuardarFactura'])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    
    $idPedido = (int)$_POST['idPedido'];
    $fechaFactura = $_POST['fechaFactura'];
    $total = (float)$_POST['total'];
    $tipoEntrega = $_POST['tipoEntrega'];
    $metodoPago = $_POST['metodoPago'];
    $direccionEnvio = $_POST['direccionEnvio'] ?? '';
    $notas = $_POST['notas'] ?? '';

    if ($idPedido > 0 && $total > 0) {
        // Calcular componentes de la factura
        $subtotal = $total / 1.13; // Quitar IVA para obtener subtotal
        $iva = $total - $subtotal;
        $descuentos = 0; // Por defecto sin descuentos

        // Insertar nueva factura usando el procedimiento almacenado
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_INSERTAR_SP(
                    :p_pedido_id,
                    :p_metodo_pago,
                    :p_fecha_emision,
                    :p_descuentos,
                    :p_subtotal,
                    :p_iva,
                    :p_total,
                    :p_estado_id,
                    :p_tipo_entrega,
                    :p_direccion_envio,
                    :p_notas
                ); END;";
                
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':p_pedido_id', $idPedido);
        oci_bind_by_name($stid, ':p_metodo_pago', $metodoPago);
        oci_bind_by_name($stid, ':p_fecha_emision', $fechaFactura);
        oci_bind_by_name($stid, ':p_descuentos', $descuentos);
        oci_bind_by_name($stid, ':p_subtotal', $subtotal);
        oci_bind_by_name($stid, ':p_iva', $iva);
        oci_bind_by_name($stid, ':p_total', $total);
        
        $estadoGenerada = 1; // Estado "Generada"
        oci_bind_by_name($stid, ':p_estado_id', $estadoGenerada);
        oci_bind_by_name($stid, ':p_tipo_entrega', $tipoEntrega);
        oci_bind_by_name($stid, ':p_direccion_envio', $direccionEnvio);
        oci_bind_by_name($stid, ':p_notas', $notas);

        if (!oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid);
            oci_rollback($conn);
            oci_free_statement($stid);
            header('Location: ../FacturacionAdmin.php?err=' . urlencode($e['message']));
            exit;
        }

        // Actualizar estado del pedido a "Facturado" (estado 4)
        $sqlPedido = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_PEDIDOS_MODIFICAR_SP(
                        :p_id, 
                        :p_estado, 
                        :p_total
                      ); END;";
        $stidPedido = oci_parse($conn, $sqlPedido);
        $estadoFacturado = 4; // Estado "Facturado" 
        oci_bind_by_name($stidPedido, ':p_id', $idPedido);
        oci_bind_by_name($stidPedido, ':p_estado', $estadoFacturado);
        oci_bind_by_name($stidPedido, ':p_total', $total);

        if (!oci_execute($stidPedido, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stidPedido);
            oci_rollback($conn);
            oci_free_statement($stid);
            oci_free_statement($stidPedido);
            header('Location: ../FacturacionAdmin.php?err=' . urlencode($e['message']));
            exit;
        }

        oci_commit($conn);
        oci_free_statement($stid);
        oci_free_statement($stidPedido);
        
        header('Location: ../FacturacionAdmin.php?ok=1&factura=nueva');
        exit;
    } else {
        header('Location: ../FacturacionAdmin.php?err=' . urlencode('Datos incompletos o incorrectos'));
        exit;
    }
}

// --- Función para obtener pedidos pendientes ---
function ObtenerPedidosPendientes()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT p.IDPEDIDO as PEDIDOS_ID_PEDIDO_PK, 
                       p.FECHAPEDIDO as FECHA_PEDIDO, 
                       p.TOTAL, 
                       p.NOMBREUSUARIO as CLIENTE_NOMBRE
                FROM VW_PEDIDOS_LISTAR p 
                WHERE p.NOMBREESTADO = 'Pendiente' 
                ORDER BY p.FECHAPEDIDO DESC";
        
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $pedidos = [];
        while ($row = oci_fetch_assoc($stid)) {
            $pedidos[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $pedidos;
    } catch (Exception $error) {
        return [];
    }
}

// --- Función para obtener detalle de un pedido ---
function ObtenerDetallePedido($idPedido)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT dp.CANTIDAD, dp.PRECIO as PRECIO_UNITARIO, dp.NOMBRE_PRODUCTO,
                       (dp.CANTIDAD * dp.PRECIO) as SUBTOTAL
                FROM FIDE_DETALLE_PEDIDO_V dp
                WHERE dp.ID_PEDIDO = :id_pedido";
        
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id_pedido', $idPedido);
        oci_execute($stid);

        $detalles = [];
        while ($row = oci_fetch_assoc($stid)) {
            $detalles[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $detalles;
    } catch (Exception $error) {
        return [];
    }
}

// --- Función para obtener métodos de pago desde BD ---
function ObtenerMetodosPago()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usando los métodos de pago comunes en Costa Rica
        $metodos = [
            'Efectivo' => 'Efectivo',
            'Tarjeta' => 'Tarjeta de Crédito/Débito',
            'Transferencia' => 'Transferencia Bancaria',
            'SINPE Móvil' => 'SINPE Móvil'
        ];

        return $metodos;
    } catch (Exception $error) {
        return [
            'Efectivo' => 'Efectivo',
            'Tarjeta' => 'Tarjeta'
        ];
    }
}

// --- Función para obtener tipos de entrega ---
function ObtenerTiposEntrega()
{
    return [
        'Recoger en local' => 'Recoger en local',
        'Express' => 'Express (pago en línea)',
        'Domicilio' => 'Entrega a domicilio'
    ];
}
?>