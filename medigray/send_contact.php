<?php
session_start();

// Verificar CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido');
}

// Incluir conexión
include $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/config/conexion.php';

// Validar datos
$asunto = trim($_POST['asunto']);
$mensaje = trim($_POST['mensaje']);

if (empty($asunto) || empty($mensaje)) {
    $_POST["txtMensaje"] = "Por favor complete todos los campos obligatorios.";
    header("Location: contacto_form.php");
    exit;
}

if (strlen($asunto) > 100 || strlen($mensaje) > 1000) {
    $_POST["txtMensaje"] = "Los datos exceden el límite permitido.";
    header("Location: contacto_form.php");
    exit;
}

try {
    // Usuario fijo para el ejemplo (debería obtenerse de la sesión)
    $idUsuario = 1;
    $estado = 1; // Estado "Pendiente"
    
    // Llamada al procedimiento PL/SQL
    $sql = "BEGIN FIDE_PROYECTO_FINAL_PKG.FIDE_CONTACTO_INSERTAR_SP(:p_usuario_id, :p_estado, :p_asunto, :p_mensaje, :p_fecha_envio); END;";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ":p_usuario_id", $idUsuario);
    oci_bind_by_name($stid, ":p_estado", $estado);
    oci_bind_by_name($stid, ":p_asunto", $asunto);
    oci_bind_by_name($stid, ":p_mensaje", $mensaje);
    
    // Fecha actual
    $fechaEnvio = date('Y-m-d H:i:s');
    oci_bind_by_name($stid, ":p_fecha_envio", $fechaEnvio);

    $respuesta = oci_execute($stid);

    oci_free_statement($stid);
    oci_close($conn);

    if ($respuesta) {
        $_POST["txtMensaje"] = "Mensaje enviado correctamente.";
        header("Location: contacto_form.php");
        exit;
    } else {
        $_POST["txtMensaje"] = "Error al enviar el mensaje.";
        header("Location: contacto_form.php");
        exit;
    }

} catch (Exception $e) {
    $_POST["txtMensaje"] = "Error: " . $e->getMessage();
    header("Location: contacto_form.php");
    exit;
}
?>
