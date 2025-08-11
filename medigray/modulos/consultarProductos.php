<?php
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
?>
