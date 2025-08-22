<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

$pedidosPendientes = ConsultarTodosPedidosPendientes();
$metodosPago = ConsultarMetodosPagoModel();

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
        <h2 class="mb-4">Generar Factura</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-warning text-center">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Seleccionar Pedido -->
            <div class="mb-3">
                <label class="form-label">Seleccionar Pedido Pendiente</label>
                <select name="listaPedidos" class="form-select" required>
                    <option value="" selected disabled>Seleccione un pedido</option>
                    <?php foreach ($pedidosPendientes as $pedido): ?>
                        <option value="<?= $pedido['PEDIDOS_ID_PEDIDO_PK'] ?>">
                            Pedido #<?= $pedido['PEDIDOS_ID_PEDIDO_PK'] ?> - Usuario:
                            <?= $pedido['USUARIOS_ID_USUARIO_FK'] ?> - Total:
                            ₡<?= number_format($pedido['TOTAL'], 0, '.', ',') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Seleccionar Método de Pago -->
            <div class="mb-3">
                <label class="form-label">Método de Pago</label>
                <select name="listaMetodosPago" class="form-select" required>
                    <option value="" selected disabled>Seleccione método</option>
                    <?php foreach ($metodosPago as $metodo): ?>
                        <option value="<?= $metodo['METODOS_PAGO_ID_PAGO_PK'] ?>">
                            <?= $metodo['NOMBRE_METODO'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón Generar -->
            <div class="mb-3">
                <button type="submit" name="btnGenerarFactura" class="btn btn-primary px-4">
                    Generar Factura
                </button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>