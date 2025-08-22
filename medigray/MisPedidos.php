<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
$pedidos = ConsultarPedidosUsuario($idUsuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="Home.php">
                    <img src="images/Logo_medigray.png" alt="Medigray Logo" style="height: 90px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="Home.php">
                                <i class="bi bi-house-door me-1"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Productos.php">
                                <i class="bi bi-capsule me-1"></i>Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="nosotros.html">
                                <i class="bi bi-info-circle me-1"></i>Nosotros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacto.php">
                                <i class="bi bi-envelope me-1"></i>Contacto
                            </a>
                        </li>

                        <!-- Dropdown Mi Cuenta -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item active" href="MisPedidos.php"><i
                                            class="bi bi-list-check me-1"></i>Mis Pedidos</a></li>
                                <li><a class="dropdown-item" href="carrito.php"><i
                                            class="bi bi-cart me-1"></i>Carrito</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="" class="m-0">
                                        <button type="submit" name="btnCerrarSesion" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sección Mis Pedidos -->

    <section class="container py-5 mt-5">
        <h2 class="mb-4">Mis Pedidos</h2>

        <?php if ($pedidos && count($pedidos) > 0): ?>
            <?php foreach ($pedidos as $pedido):
                $detalles = ConsultarDetallePedidoModel($pedido['PEDIDOS_ID_PEDIDO_PK']); ?>
                <div class="card mb-4 shadow-sm" style="border-radius:10px;">
                    <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                        <span>Fecha: <?= $pedido['FECHA_PEDIDO']?></span>
                        <span class="badge bg-light text-dark"><?= $pedido['NOMBRE_ESTADO'] ?></span>
                    </div>
                    <div class="card-body">
                        <?php foreach ($detalles as $detalle): ?>
                            <div class="d-flex align-items-center mb-3 p-2 border rounded shadow-sm" style="background-color:#fff;">
                                <img src="<?= $detalle['IMAGEN'] ?>" alt=""
                                    style="display: block; width:150px; height:auto; max-height:120px; object-fit:cover; border-radius:10px;"
                                    class="me-3">
                                <div>
                                    <h6 class="mb-1"><?= $detalle['NOMBRE_PRODUCTO'] ?></h6>
                                    <small class="text-muted d-block">Cantidad: <?= $detalle['CANTIDAD'] ?></small>
                                    <strong class="d-block mt-1">₡<?= number_format($detalle['PRECIO'], 2) ?></strong>
                                    <small class="d-block text-muted">Subtotal:
                                        ₡<?= number_format($detalle['SUBTOTAL'], 2) ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>₡<?= number_format($pedido['TOTAL'], 2) ?></strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">No tienes pedidos registrados aún.</div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Medigray. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>