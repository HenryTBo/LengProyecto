<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pagar Pedido - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h3 class="mb-4">Confirmar envío a domicilio</h3>
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tipo de tarjeta</label>
                <select name="metodoPago" class="form-select" required>
                    <option value="">Seleccione tipo</option>
                    <option value="3">Débito</option>
                    <option value="2">Crédito</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Número de tarjeta</label>
                <input type="text" name="numTarjeta" class="form-control" placeholder="0000 0000 0000 0000" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">MM/AA</label>
                <input type="text" name="vencimiento" class="form-control" placeholder="MM/AA" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">CVV</label>
                <input type="password" name="cvv" class="form-control" maxlength="3" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nombre en la tarjeta</label>
                <input type="text" name="nombreTarjeta" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" name="btnPagar" class="btn btn-success">Generar Factura</button>
            </div>
        </form>
    </div>
</body>

</html>