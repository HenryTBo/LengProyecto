<?php
$conn = oci_connect("PROYECTOLENGUAJES", "123", "localhost/XE");

if (!$conn) {
    $e = oci_error();
    echo "¡Error de conexión! " . $e['message'];
}
?>
