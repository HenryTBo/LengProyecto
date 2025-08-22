<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

// Carga todos los productos inicialmente
$productos = BuscarProductosModel("");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
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
                            <a class="nav-link active" aria-current="page" href="Productos.php">
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
                                <li><a class="dropdown-item" href="direccion.php"><i
                                            class="bi bi-house-door me-1"></i>Mis Direcciones</a></li>
                                <li><a class="dropdown-item" href="carrito.php"><i
                                            class="bi bi-cart me-1"></i>Carrito</a></li>
                                <li><a class="dropdown-item" href="MisPedidos.php"><i
                                            class="bi bi-box-seam me-1"></i>Mis Pedidos</a></li>
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


    <section class="products-hero py-5 text-white">
        <div class="container py-4 text-center">
            <h1 class="display-5 fw-bold mb-3">Nuestros Productos</h1>
            <p class="lead">Descubra nuestra amplia gama de soluciones farmacéuticas diseñadas para el cuidado de la
                salud y bienestar.</p>
        </div>
    </section>

    <section class="products-content py-5">
        <div class="container">
            <div class="row g-4 mt-3">
                <!-- Sidebar izquierda -->
                <div class="col-lg-3">
                    <div class="sidebar-widget shadow-sm bg-white p-4 mb-4">
                        <h3 class="sidebar-title">Buscar Productos</h3>
                        <div class="input-group mb-2">
                            <input type="text" id="productSearchInput" class="form-control"
                                placeholder="Buscar producto...">
                            <button class="btn btn-primary" type="button" id="searchButton"><i
                                    class="bi bi-search"></i></button>
                        </div>
                        <button class="btn btn-secondary w-100" type="button" id="showAllButton">Mostrar todos</button>
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-lg-9">
                    <div class="row g-4" id="productosContainer">
                        <?php if ($productos && count($productos) > 0): ?>
                            <?php foreach ($productos as $row): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card product-card shadow-sm h-100">
                                        <div class="product-img-container d-flex align-items-center justify-content-center bg-light"
                                            style="height: 150px;">
                                            <img src="<?php echo $row['IMAGEN']; ?>" alt="" style="display: block; margin:auto;"
                                                width="150" height="125">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <span class="product-category text-secondary fst-italic mb-1">
                                                <?php echo str_replace('_', ' ', $row["NOMBRE_CATEGORIA"]); ?>
                                            </span>
                                            <h3 class="product-title mt-1"><?php echo $row["NOMBRE_PRODUCTO"]; ?></h3>
                                            <p class="product-description flex-grow-1 mb-2">
                                                <?php echo $row["DESCRIPCION_PRODUCTO"]; ?>
                                            </p>
                                            <ul class="list-unstyled mb-3">
                                                <li><strong>Precio:</strong>
                                                    $<?php echo number_format($row["PRECIO_UNITARIO"], 2); ?></li>
                                                <li><strong>Presentación:</strong> <?php echo $row["TIPO_PRESENTACION"]; ?></li>
                                                <li><strong>Descripción:</strong>
                                                    <?php echo $row["DESCRIPCION_PRESENTACION"]; ?></li>
                                            </ul>
                                            <div class="mt-auto text-center">
                                                <button class="btn btn-primary"
                                                    onclick="AgregarCarrito(<?php echo $row['ID_PRODUCTO']; ?>)">
                                                    <i class="bi bi-cart"></i> Agregar al carrito
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h3 class="h4 mt-3">No se encontraron productos</h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer aquí -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function AgregarCarrito(idProducto) {
            $.post("modulos/consultarProductos.php", { Accion: "AgregarCarrito", idProducto: idProducto }, function (res) {
                if (res === "ok") { window.location.reload(); } else { alert(res); }
            });
        }

        // Buscar productos
        $("#searchButton").click(function () {
            let busqueda = $("#productSearchInput").val();
            $.post("modulos/consultarProductos.php", { busqueda: busqueda }, function (res) {
                $("#productosContainer").html(res);
            });
        });

        // Mostrar todos los productos
        $("#showAllButton").click(function () {
            $("#productSearchInput").val(''); // Limpiar input
            $.post("modulos/consultarProductos.php", { busqueda: '' }, function (res) {
                $("#productosContainer").html(res);
            });
        });

        // Enter en input
        $("#productSearchInput").keypress(function (e) {
            if (e.which == 13) { $("#searchButton").click(); }
        });
    </script>
</body>

</html>