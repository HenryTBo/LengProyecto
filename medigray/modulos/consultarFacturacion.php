<?php
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

function ConsultarFacturacionAdminModel($offset = 0, $limit = 100)
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usar vista SQL existente como en ProductosAdmin.php
        $sql = "SELECT * FROM VW_FACTURACION_LISTAR";
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

function ConsultarContactosAdminModel()
{
    try {
        include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

        // Usar vista SQL existente como en ProductosAdmin.php
        $sql = "SELECT * FROM VW_CONTACTOS_LISTAR";
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
?>
