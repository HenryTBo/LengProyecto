<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$productos = ConsultarProductosModel();
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

    <!-- Navegación principal -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="images/Logo_medigray.png" alt="Medigray Logo" style="height: 90px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.html">
                                <i class="bi bi-house-door me-1"></i>Inicio
                            </a>
                        </li>
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
                            <a class="nav-link" href="Trabaje-Aquí.html">
                                <i class="bi bi-briefcase me-1"></i>Trabaje Aquí
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="farmacovigilancia.html">
                                <i class="bi bi-shield-check me-1"></i>Farmacovigilancia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacto.html">
                                <i class="bi bi-envelope me-1"></i>Contacto
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="products-hero py-5 text-white">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">Nuestros Productos</h1>
                    <p class="lead">Descubra nuestra amplia gama de soluciones farmacéuticas diseñadas para el cuidado
                        de la salud y bienestar.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products-content py-5">
        <div class="container">
            <div class="row mb-4 align-items-center">
                <!-- Título y breadcrumb -->
            </div>

            <div id="categoryButtons" class="mb-4 text-center category-filter-buttons">
            </div>

            <div class="row g-4 mt-3">
                <!-- Sidebar izquierda -->
                <div class="col-lg-3">
                    <!-- Buscar productos -->
                    <div class="sidebar-widget shadow-sm bg-white p-4 mb-4">
                        <h3 class="sidebar-title">Buscar Productos</h3>
                        <div class="search-box">
                            <div class="input-group">
                                <input type="text" id="productSearchInput" class="form-control search-input"
                                    placeholder="Buscar producto...">
                                <button class="btn search-button" type="button" id="searchButton">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="sidebar-widget p-0 mb-4 shadow-sm overflow-hidden">
                        <div class="bg-primary text-white p-4">
                            <h3 class="h5 fw-bold mb-3">¿Necesita información adicional?</h3>
                            <p class="mb-3">Contáctenos para obtener información detallada sobre cualquiera de nuestros
                                productos.</p>
                            <a href="contacto.html" class="btn btn-light rounded-pill fw-medium">
                                <i class="bi bi-envelope me-2"></i>Contáctenos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Productos a la derecha -->
                <div class="col-lg-9">
                    <div class="row g-4">
                        <?php if ($productos && count($productos) > 0): ?>
                            <?php foreach ($productos as $row): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card product-card shadow-sm h-100">
                                        <div class="product-img-container d-flex align-items-center justify-content-center bg-light"
                                            style="height: 150px;">
                                            <img src="<?php echo $row['IMAGEN']; ?>" alt=""
                                                style="display: block; margin-left: auto; margin-right: auto;" width="150"
                                                height="125">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <span class="product-category text-secondary fst-italic mb-1">
                                                <?php echo str_replace('_', ' ', $row["NOMBRE_CATEGORIA"]); ?>
                                            </span>
                                            <h3 class="product-title mt-1">
                                                <?php echo $row["NOMBRE_PRODUCTO"]; ?>
                                            </h3>
                                            <p class="product-description flex-grow-1 mb-2">
                                                <?php echo $row["DESCRIPCION_PRODUCTO"]; ?>
                                            </p>
                                            <ul class="list-unstyled mb-3">
                                                <li><strong>Precio:</strong>
                                                    $<?php echo number_format($row["PRECIO_UNITARIO"], 2); ?></li>
                                                <li><strong>Presentación:</strong>
                                                    <?php echo $row["TIPO_PRESENTACION"]; ?></li>
                                                <li><strong>Presentación:</strong>
                                                    <?php echo $row["DESCRIPCION_PRESENTACION"]; ?></li>
                                            </ul>
                                            <a href="detalle_producto.php?id=<?php echo $row["ID_PRODUCTO"]; ?>"
                                                class="btn btn-product-detail mt-auto align-self-center">
                                                <i class="bi bi-cart"></i> Agregar al Carrito
                                            </a>
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

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row gy-4">
                <!-- Columna principal - Sobre Medigray -->
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <h5 class="text-uppercase mb-3 fw-bold text-primary">
                            <img src="images/Logo_medigray.png" alt="Medigray Footer Logo" height="30"
                                style="filter: brightness(0) invert(1); margin-right: 8px;">
                            Medigray
                        </h5>
                        <p class="text-white-50">En MEDIGRAY nos dedicamos a desarrollar, producir y comercializar
                            productos de la más alta calidad, que contribuyen a mejorar la salud y bienestar de las
                            personas.</p>
                    </div>

                    <!-- Dirección y contacto -->
                    <div class="mb-4">
                        <p class="text-white-50 mb-1"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Desamparados,
                            San José, Costa Rica</p>
                        <p class="text-white-50 mb-1"><i class="bi bi-telephone-fill me-2 text-primary"></i>(+506)
                            2270-7979</p>
                        <p class="text-white-50 mb-1"><i
                                class="bi bi-envelope-fill me-2 text-primary"></i>ventas@medigray.com</p>
                    </div>

                    <!-- Redes sociales -->
                    <div class="mt-4 social-icons">
                        <a href="#" class="btn btn-outline-light btn-floating m-1 rounded-circle"
                            aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1 rounded-circle"
                            aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1 rounded-circle"
                            aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn btn-outline-light btn-floating m-1 rounded-circle"
                            aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <!-- Columna de enlaces rápidos -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Navegación</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Inicio</a></li>
                        <li class="mb-2"><a href="nosotros.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Nosotros</a></li>
                        <li class="mb-2"><a href="farmacovigilancia.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Farmacovigilancia</a></li>
                        <li class="mb-2"><a href="productos.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Productos</a></li>
                        <li class="mb-2"><a href="trabaje-aqui.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Trabaje Aquí</a></li>
                        <li class="mb-2"><a href="contacto.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Contacto</a></li>
                    </ul>
                </div>

                <!-- Columna de Productos -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Productos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="productos.html?cat=RESPIRATORIA"
                                class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Respiratoria</a></li>
                        <li class="mb-2"><a href="productos.html?cat=DOLOR"
                                class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Dolor</a></li>
                        <li class="mb-2"><a href="productos.html?cat=DERMATOLÓGICO"
                                class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>DERMATOLÓGICO</a></li>
                        <li class="mb-2"><a href="productos.html?cat=GASTRICO"
                                class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Gástrico</a></li>
                        <li class="mb-2"><a href="productos.html" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Ver todas las categorías</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna de Legal y soporte -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Legal & Soporte</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Términos y condiciones</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Política de privacidad</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Preguntas frecuentes</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Soporte al cliente</a></li>
                    </ul>
                </div>

                <!-- Línea divisoria -->
                <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">

                <!-- Copyright -->
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="text-white-50 mb-0">&copy; <span id="currentYear"></span> Medigray. Todos los derechos
                            reservados.</p>
                    </div>
                </div>
            </div>
    </footer>

    <!-- Scripts de Bootstrap y personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/script.js"></script>
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>

</html>