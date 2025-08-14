<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$categorias = ConsultarCategoriasModel();
$Presentaciones = ConsultarPresentacionesModel();

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
        <h2 class="mb-4">Registrar Producto</h2>

        <?php if (isset($_POST["txtMensaje"])): ?>
            <div class="alert alert-warning text-center">
                <?= $_POST["txtMensaje"] ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">ID</label>
                <div class="col-md-7">
                    <input type="number" name="txtId" class="form-control" required>
                </div>
            </div>

        
            <!-- Nombre del producto -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Nombre</label>
                <div class="col-md-7">
                    <input type="text" name="txtNombre"class="form-control" required>
                </div>
            </div>

            <!-- Descripción -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Descripción</label>
                <div class="col-md-7">
                    <textarea name="txtDescripcion" class="form-control" rows="3" required></textarea>
                </div>
            </div>

            <!-- Precio unitario -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Precio Unitario</label>
                <div class="col-md-7">
                    <input type="number" step="0.01" name="txtPrecio" class="form-control" required>
                </div>
            </div>

            <!-- Categoría -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Categoría</label>
                <div class="col-md-7">
                    <select id="listaCategorias" name="listaCategorias" class="form-select mb-2" required>
                        <option value="" selected disabled>Seleccionar categoría</option>
                        <?php foreach ($categorias as $fila): ?>
                            <option value="<?= $fila['CATEGORIA_ID_CATEGORIA_PK'] ?>">
                                <?= $fila['NOMBRE_CATEGORIA'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Presentación -->
                    <select id="listaPresentaciones" name="listaPresentaciones" class="form-select" required>
                        <option value="" selected disabled>Seleccionar presentación</option>
                        <?php foreach ($Presentaciones as $fila): ?>
                            <option value="<?= $fila['PRESENTACIONES_ID_PRESENTACION_PK'] ?>">
                                <?= $fila['TIPO_PRESENTACION'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Estado</label>
                <div class="col-md-7">
                    <select name="listaEstados" class="form-select" required>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
            </div>

            <!-- Imagen -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Imagen</label>
                <div class="col-md-7">
                    <input type="file" accept="image/png, image/jpeg" name="txtImagen" id="txtImagen" class="form-control" required>
                </div>
            </div>

            <!-- Botón enviar -->
            <div class="form-group row mb-3">
                <div class="col-md-7 offset-sm-3">
                    <button type="submit" name="btnRegistrarProducto" id="btnRegistrarProducto" class="btn btn-primary px-4">
                        Guardar Producto
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>