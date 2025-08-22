<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* Estilos específicos para esta página */
        .contact-info-item {
            background-color: #f0f5ff;
            border-left: 4px solid #0066cc;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            background-color: #e0eaff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-form-card {
            background-color: #f8f9fa;
            border-top: 4px solid #0066cc;
        }

        .circle-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #0066cc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 102, 204, 0.3);
        }

        .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 204, 0.25);
        }

        .btn-send {
            background-color: #0066cc;
            color: white;
            padding: 10px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-send:hover {
            background-color: #004e9e;
            color: white;
            transform: translateY(-2px);
        }

        footer {
            background-color: #111827 !important;
        }

        footer .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .contact-section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            color: #0066cc;
            font-weight: 700;
        }

        .contact-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #0066cc;
        }
    </style>
</head>

<body>

    <!-- Navegación principal -->
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
                            <a class="nav-link active" aria-current="page" href="contacto.php">
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


    <!-- Encabezado de contacto mejorado -->
    <section class="contact-hero py-5" style="background-color: #0066cc; color: white;">
        <div class="container py-3">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">Póngase en Contacto</h1>
                    <p class="lead">Estamos aquí para ayudarle. Envíenos sus consultas y nos pondremos en contacto a la
                        brevedad.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido principal mejorado -->
    <section class="contact py-5" id="contact">
        <div class="container">
            <div class="row g-4">
                <!-- Columna de información de contacto -->
                <div class="col-lg-5">
                    <h2 class="contact-section-title">Información de Contacto</h2>

                    <!-- Dirección Principal - Mejorada -->
                    <div class="contact-info-item p-4 mb-4 shadow-sm rounded">
                        <div class="d-flex align-items-center">
                            <div class="circle-icon me-3">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h4 class="h5 fw-bold mb-1">Dirección Principal</h4>
                                <p class="mb-0" style="color: #444;">Desamparados, San José, Costa Rica</p>
                            </div>
                        </div>
                    </div>

                    <!-- Teléfono - Mejorado -->
                    <div class="contact-info-item p-4 mb-4 shadow-sm rounded">
                        <div class="d-flex align-items-center">
                            <div class="circle-icon me-3">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h4 class="h5 fw-bold mb-1">Teléfono</h4>
                                <p class="mb-0" style="color: #444;">(+506) 2270-7979</p>
                                <p class="mb-0" style="color: #444;">Teléfono IP: (305) 677-2852</p>
                                <p class="mb-0" style="color: #444;">FAX: (506) 2270-7071</p>
                            </div>
                        </div>
                    </div>

                    <!-- Correo Electrónico - Mejorado -->
                    <div class="contact-info-item p-4 mb-4 shadow-sm rounded">
                        <div class="d-flex align-items-center">
                            <div class="circle-icon me-3">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h4 class="h5 fw-bold mb-1">Correo Electrónico</h4>
                                <p class="mb-0" style="color: #444;">ventas@medigray.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Horario de Atención - Mejorado -->
                    <div class="contact-info-item p-4 mb-4 shadow-sm rounded">
                        <div class="d-flex align-items-center">
                            <div class="circle-icon me-3">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h4 class="h5 fw-bold mb-1">Horario de Atención</h4>
                                <p class="mb-0" style="color: #444;">Lunes a Viernes: 8:00 AM - 5:00 PM</p>
                                <p class="mb-0" style="color: #444;">Sábados y Domingos: Cerrado</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa simple -->
                    <div class="mt-4 shadow-sm rounded overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.9539737399873!2d-84.06761532427882!3d9.854228675524627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e283e8d1654b%3A0xd782e526e77a90e6!2sMedigray!5e0!3m2!1ses!2scr!4v1751266300379!5m2!1ses!2scr"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="col-lg-7">
                    <div class="card shadow p-4 p-md-5 rounded">
                        <h2 class="contact-section-title">Envíenos un Mensaje</h2>

                        <?php if (isset($_POST['txtMensaje'])): ?>
                            <div class="alert alert-info"><?= $_POST['txtMensaje'] ?></div>
                        <?php endif; ?>

                        <form action="" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="usuarios_id_usuario_fk" value="<?= $idUsuario ?>">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="contactAsunto" class="form-label fw-medium">Asunto <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="contactAsunto"
                                        name="asunto" required>
                                    <div class="invalid-feedback">Por favor ingrese el asunto de su mensaje.</div>
                                </div>
                                <div class="col-12">
                                    <label for="contactMensaje" class="form-label fw-medium">Su mensaje <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-lg" id="contactMensaje" name="mensaje"
                                        rows="5" required></textarea>
                                    <div class="invalid-feedback">Por favor ingrese su mensaje.</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="contactConsentimiento"
                                            required>
                                        <label class="form-check-label" for="contactConsentimiento">
                                            Acepto que Medigray procese mis datos personales con el fin de gestionar mi
                                            consulta. <span class="text-danger">*</span>
                                        </label>
                                        <div class="invalid-feedback">
                                            Debe aceptar el procesamiento de sus datos para continuar.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-3">
                                    <button type="submit" name="btnEnviarContacto"
                                        class="btn btn-send btn-lg rounded-pill px-5 shadow">
                                        <i class="bi bi-send me-2"></i> Enviar Mensaje
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row gy-4 align-items-start">
                <!-- Columna del Logo - Izquierda -->
                <div class="col-lg-3 col-md-12 text-center text-lg-start">
                    <div class="mb-3">
                        <img src="images/Logo_medigray.png" alt="Medigray Logo" style="height: 300px;">
                    </div>
                </div>

                <!-- Columna principal - Información de la empresa -->
                <div class="col-lg-5 col-md-6">
                    <h5 class="text-uppercase mb-3 fw-bold text-primary">MEDIGRAY</h5>
                    <p class="text-white-50 mb-4">En MEDIGRAY nos dedicamos a desarrollar, producir y comercializar
                        productos de la más alta calidad, que contribuyen a mejorar la salud y bienestar de las
                        personas.</p>

                    <!-- Información de contacto -->
                    <div class="contact-info">
                        <p class="text-white-50 mb-2">
                            <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                            Desamparados, San José, Costa Rica
                        </p>
                        <p class="text-white-50 mb-2">
                            <i class="bi bi-telephone-fill me-2 text-primary"></i>
                            (+506) 2270-7979
                        </p>
                        <p class="text-white-50 mb-0">
                            <i class="bi bi-envelope-fill me-2 text-primary"></i>
                            ventas@medigray.com
                        </p>
                    </div>
                </div>

                <!-- Columna de enlaces rápidos -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Navegación</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white-50 text-decoration-none hover-link"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Inicio</a></li>
                        <li class="mb-2"><a href="productos.php"
                                class="text-white-50 text-decoration-none hover-link"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Productos</a></li>
                        <li class="mb-2"><a href="nosotros.html"
                                class="text-white-50 text-decoration-none hover-link"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Nosotros</a></li>
                        <li class="mb-2"><a href="contacto.php" class="text-white-50 text-decoration-none hover-link"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Contacto</a></li>
                        <li class="mb-2"><a href="carrito.php" class="text-white-50 text-decoration-none hover-link"><i
                                    class="bi bi-chevron-right me-1 small text-primary"></i>Carrito</a></li>
                    </ul>
                </div>

                <!-- Columna de categorías de productos -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Productos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-white-50"><i
                                class="bi bi-chevron-right me-1 small text-primary"></i>Respiratoria</li>
                        <li class="mb-2 text-white-50"><i class="bi bi-chevron-right me-1 small text-primary"></i>Dolor
                        </li>
                        <li class="mb-2 text-white-50"><i
                                class="bi bi-chevron-right me-1 small text-primary"></i>Dermatológico</li>
                        <li class="mb-2 text-white-50"><i
                                class="bi bi-chevron-right me-1 small text-primary"></i>Gástrico</li>
                        <li class="mb-2 text-white-50"><i class="bi bi-chevron-right me-1 small text-primary"></i>Ver
                            todas</li>
                    </ul>
                </div>
            </div>

            <!-- Línea divisoria -->
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">

            <!-- Copyright -->
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-white-50 mb-0">© <span id="currentYear"></span> Medigray. Todos los derechos
                        reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Año actual en el footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>