<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
$direccionUsuario = ConsultarDireccionUsuario($idUsuario);

$paises = ConsultarPaises();
$provincias = ConsultarProvincias();
$cantones = ConsultarCantones();
$distritos = ConsultarDistritos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Dirección - Pharma</title>
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
                    <img src="images/Logo_medigray.png" alt="Logo" style="height: 90px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="Home.php"><i class="bi bi-house-door me-1"></i>Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Productos.php"><i class="bi bi-capsule me-1"></i>Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="nosotros.html"><i class="bi bi-info-circle me-1"></i>Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contacto.php"><i class="bi bi-envelope me-1"></i>Contacto</a>
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
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="" class="m-0">
                                        <button type="submit" name="btnCerrarSesion" class="dropdown-item"><i
                                                class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sección Actualizar Dirección -->
    <section class="container py-5 mt-5">
        <div class="card shadow-sm p-4 rounded" style="max-width: 600px; margin: auto;">
            <div class="text-center mb-4">
                <h4>Actualizar Dirección</h4>
            </div>

            <form method="POST" class="needs-validation" novalidate>
                <?php
                if (isset($_POST['txtMensaje'])) {
                    echo '<div class="alert alert-success text-center">' . $_POST['txtMensaje'] . '</div>';
                }
                ?>

                <div class="mb-3">
                    <label for="paises" class="form-label">País</label>
                    <select id="paises" name="paises" class="form-select" required>
                        <option value="">Seleccione un país</option>
                        <?php foreach ($paises as $pais):
                            $selected = (isset($direccionUsuario['PAISES_ID_PAIS_FK']) && $direccionUsuario['PAISES_ID_PAIS_FK'] == $pais['PAISES_ID_PAIS_PK']) ? 'selected' : '';
                            ?>
                            <option value="<?= $pais['PAISES_ID_PAIS_PK'] ?>" <?= $selected ?>><?= $pais['NOMBRE_PAIS'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="provincias" class="form-label">Provincia</label>
                    <select id="provincias" name="provincias" class="form-select" required>
                        <option value="">Seleccione una provincia</option>
                        <?php foreach ($provincias as $prov):
                            $selected = (isset($direccionUsuario['PROVINCIAS_ID_PROVINCIA_FK']) && $direccionUsuario['PROVINCIAS_ID_PROVINCIA_FK'] == $prov['PROVINCIAS_ID_PROVINCIA_PK']) ? 'selected' : '';
                            ?>
                            <option value="<?= $prov['PROVINCIAS_ID_PROVINCIA_PK'] ?>" <?= $selected ?>>
                                <?= $prov['NOMBRE_PROVINCIA'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantones" class="form-label">Cantón</label>
                    <select id="cantones" name="cantones" class="form-select" required>
                        <option value="">Seleccione un cantón</option>
                        <?php foreach ($cantones as $c):
                            $selected = (isset($direccionUsuario['CANTONES_ID_CANTON_FK']) && $direccionUsuario['CANTONES_ID_CANTON_FK'] == $c['CANTONES_ID_CANTON_PK']) ? 'selected' : '';
                            ?>
                            <option value="<?= $c['CANTONES_ID_CANTON_PK'] ?>" <?= $selected ?>><?= $c['NOMBRE_CANTON'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="distritos" class="form-label">Distrito</label>
                    <select id="distritos" name="distritos" class="form-select" required>
                        <option value="">Seleccione un distrito</option>
                        <?php foreach ($distritos as $d):
                            $selected = (isset($direccionUsuario['DISTRITOS_ID_DISTRITO_FK']) && $direccionUsuario['DISTRITOS_ID_DISTRITO_FK'] == $d['DISTRITOS_ID_DISTRITO_PK']) ? 'selected' : '';
                            ?>
                            <option value="<?= $d['DISTRITOS_ID_DISTRITO_PK'] ?>" <?= $selected ?>>
                                <?= $d['NOMBRE_DISTRITO'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="direccionExacta" class="form-label">Dirección Exacta</label>
                    <input type="text" id="direccionExacta" name="direccionExacta" class="form-control"
                        placeholder="Ej: 500m sur del mercado central"
                        value="<?= isset($direccionUsuario['OTRAS_SENAS']) ? $direccionUsuario['OTRAS_SENAS'] : '' ?>"
                        required>
                </div>

                <div class="text-center">
                    <button type="submit" name="btnGuardarDireccion" class="btn btn-primary">Guardar Dirección</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Pharma. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>