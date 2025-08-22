<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

$idFactura = $_GET["q"];
$factura = ConsultarInfoFacturaModel($idFactura); // Devuelve los datos de la factura
$metodosPago = ConsultarMetodosPagoModel();
$estados = ConsultarEstadosModel();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$activePage = 'facturas';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Factura - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="AdminDashboard.php">Medigray Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
                aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'dashboard') {
                            echo 'active';
                        } ?>" href="AdminDashboard.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'usuarios') {
                            echo 'active';
                        } ?>" href="UsuariosAdmin.php">
                            <i class="bi bi-people-fill me-1"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'productos') {
                            echo 'active';
                        } ?>" href="ProductosAdmin.php">
                            <i class="bi bi-capsule me-1"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'pedidos') {
                            echo 'active';
                        } ?>" href="PedidosAdmin.php">
                            <i class="bi bi-cart-fill me-1"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'facturas') {
                            echo 'active';
                        } ?>" href="FacturacionAdmin.php">
                            <i class="bi bi-receipt me-1"></i> Facturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'contactos') {
                            echo 'active';
                        } ?>" href="ContactosAdmin.php">
                            <i class="bi bi-envelope-fill me-1"></i> Contáctenos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($activePage == 'inventario') {
                            echo 'active';
                        } ?>" href="InventarioAdmin.php">
                            <i class="bi bi-box-seam me-1"></i> Inventario
                        </a>
                    </li>

                    <!-- Botón cerrar sesión -->
                    <li class="nav-item ms-3">
                        <form method="POST" action="">
                            <button type="submit" name="btnCerrarSesion" class="btn btn-link p-0">
                                <i class="bi bi-box-arrow-right text-light" style="font-size: 1.3rem;"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-5" style="margin-top:120px;">
        <h2 class="mb-4">Actualizar Factura</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-warning text-center">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="txtIdFactura" value="<?= $factura["FACTURACION_ID_FACTURA_PK"] ?>">

            <div class="mb-3">
                <label class="form-label">Descuentos</label>
                <input type="number" step="0.01" name="txtDescuentos" class="form-control"
                    value="<?= str_replace(',', '.', $factura["DESCUENTOS"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Subtotal</label>
                <input type="number" step="0.01" name="txtSubtotal" class="form-control"
                    value="<?= str_replace(',', '.', $factura["SUBTOTAL"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">IVA</label>
                <input type="number" step="0.01" name="txtIVA" class="form-control"
                    value="<?= str_replace(',', '.', $factura["IVA"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Facturado</label>
                <input type="number" step="0.01" name="txtTotal" class="form-control"
                    value="<?= str_replace(',', '.', $factura["TOTAL_FACTURADO"]) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Método de Pago</label>
                <select name="listaMetodosPago" class="form-select" required>
                    <?php foreach ($metodosPago as $metodo): ?>
                        <option value="<?= $metodo["METODOS_PAGO_ID_PAGO_PK"] ?>"
                            <?= $factura["METODOS_PAGO_ID_PAGO_FK"] == $metodo["METODOS_PAGO_ID_PAGO_PK"] ? 'selected' : '' ?>>
                            <?= $metodo["NOMBRE_METODO"] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="listaEstados" class="form-select" required>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado["ID_ESTADO"] ?>"
                            <?= $factura["ESTADOS_ID_ESTADO_FK"] == $estado["ID_ESTADO"] ? 'selected' : '' ?>>
                            <?= $estado["ESTADO"] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="btnActualizarFactura" class="btn btn-primary">Actualizar Factura</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>