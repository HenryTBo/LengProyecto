<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

// --- POST de ACTUALIZAR = modificar datos de factura ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnActualizarFactura'])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    
    $idFactura = (int)$_POST['idFactura'];
    $fechaFactura = $_POST['fechaFactura'];
    $total = (float)$_POST['total'];
    $tipoEntrega = $_POST['tipoEntrega'];
    $metodoPago = $_POST['metodoPago'];
    $direccionEnvio = $_POST['direccionEnvio'] ?? '';
    $notas = $_POST['notas'] ?? '';

    if ($idFactura > 0) {
        // Calcular componentes de la factura
        $subtotal = $total / 1.13; // Quitar IVA para obtener subtotal
        $iva = $total - $subtotal;
        $descuentos = 0; // Por defecto sin descuentos

        // Usar procedimiento almacenado para actualizar
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_MODIFICAR_SP(
                    :p_factura_id,
                    :p_metodo_pago,
                    :p_fecha_emision,
                    :p_descuentos,
                    :p_subtotal,
                    :p_iva,
                    :p_total,
                    :p_tipo_entrega,
                    :p_direccion_envio,
                    :p_notas
                ); END;";
                
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':p_factura_id', $idFactura);
        oci_bind_by_name($stid, ':p_metodo_pago', $metodoPago);
        oci_bind_by_name($stid, ':p_fecha_emision', $fechaFactura);
        oci_bind_by_name($stid, ':p_descuentos', $descuentos);
        oci_bind_by_name($stid, ':p_subtotal', $subtotal);
        oci_bind_by_name($stid, ':p_iva', $iva);
        oci_bind_by_name($stid, ':p_total', $total);
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

        oci_commit($conn);
        oci_free_statement($stid);
        
        header('Location: ../FacturacionAdmin.php?ok=1&updated=' . $idFactura);
        exit;
    } else {
        header('Location: ../FacturacionAdmin.php?err=' . urlencode('ID de factura inválido'));
        exit;
    }
}

// --- Función para obtener datos de una factura específica ---
function ObtenerFacturaPorId($idFactura)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT f.FACTURACION_ID_FACTURA_PK, f.PEDIDOS_ID_PEDIDO_FK, 
                       f.METODO_PAGO, f.FECHA_EMISION, f.DESCUENTOS, 
                       f.SUBTOTAL, f.IVA, f.TOTAL_FACTURADO, f.ESTADO,
                       f.FECHA_CREACION, p.IDPEDIDO, p.NOMBREUSUARIO as CLIENTE_NOMBRE
                FROM VW_FACTURACION_LISTAR f
                LEFT JOIN VW_PEDIDOS_LISTAR p ON f.PEDIDOS_ID_PEDIDO_FK = p.IDPEDIDO
                WHERE f.FACTURACION_ID_FACTURA_PK = :id_factura";
        
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id_factura', $idFactura);
        oci_execute($stid);

        $factura = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        return $factura;
    } catch (Exception $error) {
        return null;
    }
}

// --- Función para validar si una factura se puede editar ---
function PuedeEditarFactura($idFactura)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT ESTADO FROM VW_FACTURACION_LISTAR WHERE FACTURACION_ID_FACTURA_PK = :id_factura";
        
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id_factura', $idFactura);
        oci_execute($stid);

        $factura = oci_fetch_assoc($stid);

        oci_free_statement($stid);
        oci_close($conn);

        // Solo se puede editar si está en estado GENERADA o PENDIENTE
        return $factura && in_array($factura['ESTADO'], ['GENERADA', 'PENDIENTE']);
    } catch (Exception $error) {
        return false;
    }
}

// --- Función para obtener estados disponibles ---
function ObtenerEstadosFactura()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT ID_ESTADO, ESTADO FROM FIDE_LISTAR_ESTADOS_V ORDER BY ID_ESTADO";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $estados = [];
        while ($row = oci_fetch_assoc($stid)) {
            $estados[$row['ID_ESTADO']] = $row['ESTADO'];
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $estados;
    } catch (Exception $error) {
        return [
            1 => 'Activo',
            2 => 'Inactivo',
            3 => 'Pendiente',
            4 => 'Completado'
        ];
    }
}

// --- Función para obtener historial de cambios (opcional) ---
function ObtenerHistorialFactura($idFactura)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Si tienen tabla de auditoría, usar esta consulta
        $sql = "SELECT FECHA_CREACION as FECHA_CAMBIO, 
                       'MODIFICACION' as CAMPO_MODIFICADO,
                       'ANTERIOR' as VALOR_ANTERIOR,
                       'NUEVO' as VALOR_NUEVO,
                       'SISTEMA' as USUARIO_MODIFICACION
                FROM VW_FACTURACION_LISTAR
                WHERE FACTURACION_ID_FACTURA_PK = :id_factura
                ORDER BY FECHA_CREACION DESC";
        
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':id_factura', $idFactura);
        oci_execute($stid);

        $historial = [];
        while ($row = oci_fetch_assoc($stid)) {
            $historial[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $historial;
    } catch (Exception $error) {
        return [];
    }
}

// --- Función para obtener métodos de pago ---
function ObtenerMetodosPago()
{
    return [
        'Efectivo' => 'Efectivo',
        'Tarjeta' => 'Tarjeta de Crédito/Débito',
        'Transferencia' => 'Transferencia Bancaria',
        'SINPE Móvil' => 'SINPE Móvil'
    ];
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