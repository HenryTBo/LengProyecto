<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

// --- POST de CAMBIAR ESTADO = modificar estado de factura ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnCambiarEstado'])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    
    $idFactura = (int)$_POST['idFactura'];
    $nuevoEstado = $_POST['nuevoEstado'];
    $motivoCambio = $_POST['motivoCambio'] ?? '';

    if ($idFactura > 0 && !empty($nuevoEstado)) {
        // Usar procedimiento almacenado para cambiar estado
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_CAMBIAR_ESTADO_SP(
                    :p_factura_id,
                    :p_nuevo_estado,
                    :p_motivo
                ); END;";
                
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':p_factura_id', $idFactura);
        oci_bind_by_name($stid, ':p_nuevo_estado', $nuevoEstado);
        oci_bind_by_name($stid, ':p_motivo', $motivoCambio);

        if (!oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid);
            oci_rollback($conn);
            oci_free_statement($stid);
            header('Location: ../FacturacionAdmin.php?err=' . urlencode($e['message']));
            exit;
        }

        oci_commit($conn);
        oci_free_statement($stid);
        
        header('Location: ../FacturacionAdmin.php?ok=1&estado_changed=' . $idFactura);
        exit;
    } else {
        header('Location: ../FacturacionAdmin.php?err=' . urlencode('Datos incompletos para cambiar estado'));
        exit;
    }
}

// --- POST de DESACTIVAR = anular factura (no eliminar) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnDesactivarFactura'])) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';
    
    $idFactura = (int)$_POST['idFactura'];
    $motivoAnulacion = $_POST['motivoAnulacion'] ?? 'Anulación administrativa';

    if ($idFactura > 0) {
        // Usar procedimiento almacenado para eliminar/anular factura
        $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_FACTURACION_ELIMINAR_SP(
                    :p_factura_id,
                    :p_motivo
                ); END;";
                
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':p_factura_id', $idFactura);
        oci_bind_by_name($stid, ':p_motivo', $motivoAnulacion);

        if (!oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid);
            oci_rollback($conn);
            oci_free_statement($stid);
            header('Location: ../FacturacionAdmin.php?err=' . urlencode($e['message']));
            exit;
        }

        oci_commit($conn);
        oci_free_statement($stid);
        
        header('Location: ../FacturacionAdmin.php?ok=1&anulada=' . $idFactura);
        exit;
    } else {
        header('Location: ../FacturacionAdmin.php?err=' . urlencode('ID de factura inválido'));
        exit;
    }
}

// --- Función para obtener estados disponibles ---
function ObtenerEstadosDisponibles()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT ID_ESTADO, ESTADO FROM FIDE_LISTAR_ESTADOS_V ORDER BY ID_ESTADO";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $estados = [];
        while ($row = oci_fetch_assoc($stid)) {
            $estados[$row['ESTADO']] = $row['ESTADO'];
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $estados;
    } catch (Exception $error) {
        return [
            'GENERADA' => 'Generada',
            'PENDIENTE' => 'Pendiente de Pago',
            'PAGADA' => 'Pagada',
            'ENVIADA' => 'Enviada',
            'ENTREGADA' => 'Entregada',
            'COMPLETADA' => 'Completada',
            'ANULADA' => 'Anulada'
        ];
    }
}

// --- Función para validar transiciones de estado ---
function ValidarCambioEstado($estadoActual, $estadoNuevo)
{
    $transicionesValidas = [
        'Activo' => ['Pendiente', 'Completado', 'Inactivo'],
        'Pendiente' => ['Activo', 'Completado', 'Inactivo'],
        'Completado' => ['Inactivo'], // Estado final
        'Inactivo' => [] // Estado final
    ];

    return isset($transicionesValidas[$estadoActual]) && 
           in_array($estadoNuevo, $transicionesValidas[$estadoActual]);
}

// --- Función para obtener facturas por estado ---
function ObtenerFacturasPorEstado($estado)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT f.FACTURACION_ID_FACTURA_PK, f.PEDIDOS_ID_PEDIDO_FK, 
                       f.METODO_PAGO, f.FECHA_EMISION, f.TOTAL_FACTURADO, 
                       f.ESTADO, p.NOMBREUSUARIO as CLIENTE_NOMBRE
                FROM VW_FACTURACION_LISTAR f
                LEFT JOIN VW_PEDIDOS_LISTAR p ON f.PEDIDOS_ID_PEDIDO_FK = p.IDPEDIDO
                WHERE f.ESTADO = :estado
                ORDER BY f.FECHA_EMISION DESC";
        
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':estado', $estado);
        oci_execute($stid);

        $facturas = [];
        while ($row = oci_fetch_assoc($stid)) {
            $facturas[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $facturas;
    } catch (Exception $error) {
        return [];
    }
}

// --- Función para obtener estadísticas de estados ---
function ObtenerEstadisticasEstados()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT ESTADO, COUNT(*) as CANTIDAD, SUM(TOTAL_FACTURADO) as TOTAL_MONTO
                FROM VW_FACTURACION_LISTAR
                GROUP BY ESTADO
                ORDER BY ESTADO";
        
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        $estadisticas = [];
        while ($row = oci_fetch_assoc($stid)) {
            $estadisticas[] = $row;
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $estadisticas;
    } catch (Exception $error) {
        return [];
    }
}

// --- Función para obtener estados específicos para facturas ---
function ObtenerEstadosFactura()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        $sql = "SELECT ID_ESTADO, ESTADO FROM FIDE_LISTAR_ESTADOS_V 
                WHERE ID_ESTADO IN (1,2,3,4,5) ORDER BY ID_ESTADO";
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
            4 => 'Completado',
            5 => 'Cancelado'
        ];
    }
}
?>