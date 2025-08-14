<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$idPedido = $_GET["q"];
$resultado = ConsultarInfoPedidoModel($idPedido);

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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
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

    <main class="container py-5" style="margin-top:120px;">
        <h2 class="mb-4">Actualizar Producto</h2>

        <?php if (isset($_POST["txtMensaje"])): ?>
            <div class="alert alert-warning text-center">
                <?= $_POST["txtMensaje"] ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input id="txtId" name="txtId" type="hidden" value="<?= $resultado["IDPEDIDO"] ?>">

            <div class="mb-3">
                <label class="form-label">Nombre Usuario</label>
                <input id="txtNombre" name="txtNombre" type="text" class="form-control"
                    value="<?= $resultado["NOMBREUSUARIO"] ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha</label>
                <input id="txtFecha" name="txtFecha" type="date " step="0.01" class="form-control"
                    value="<?= $resultado["FECHAPEDIDO"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input id="txtTotal" name="txtTotal" type="number" step="0.01" class="form-control"
                    value="<?= $resultado["TOTAL"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="listaEstados" class="form-select" required>
                    <option value="1" <?= $resultado["IDESTADO"] == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="2" <?= $resultado["IDESTADO"] == 2 ? 'selected' : '' ?>>Inactivo</option>
                    <option value="3" <?= $resultado["IDESTADO"] == 3 ? 'selected' : '' ?>>Pendiente</option>
                    <option value="4" <?= $resultado["IDESTADO"] == 4 ? 'selected' : '' ?>>Suspendido</option>
                    <option value="7" <?= $resultado["IDESTADO"] == 7 ? 'selected' : '' ?>>Rechazado</option>
                </select>
            </div>

            <button type="submit" name="btnActualizarPedido" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </main>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>