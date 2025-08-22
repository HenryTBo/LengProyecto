<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
            /* Para navbar fijo */
        }

        .card-hover:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="AdminDashboard.php">Medigray Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="">
                            <button type="submit" name="btnCerrarSesion" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card card-hover text-center p-3">
                    <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">Usuarios</h5>
                    <p>Gestión de usuarios</p>
                    <a href="UsuariosAdmin.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-hover text-center p-3">
                    <i class="bi bi-capsule" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">Productos</h5>
                    <p>Gestión de productos</p>
                    <a href="ProductosAdmin.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-hover text-center p-3">
                    <i class="bi bi-cart-fill" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">Pedidos</h5>
                    <p>Revisar pedidos</p>
                    <a href="PedidosAdmin.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-hover text-center p-3">
                    <i class="bi bi-receipt" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">Facturas</h5>
                    <p>Gestión de facturas</p>
                    <a href="FacturacionAdmin.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>

            <!-- Nueva tarjeta: Contáctenos -->
            <div class="col-md-3">
                <div class="card card-hover text-center p-3">
                    <i class="bi bi-envelope-fill" style="font-size: 2rem;"></i>
                    <h5 class="mt-2">Contáctenos</h5>
                    <p>Ver mensajes recibidos</p>
                    <a href="ContactosAdmin.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
c

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>