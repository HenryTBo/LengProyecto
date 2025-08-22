<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$categorias = ConsultarCategoriasModel();
$Presentaciones = ConsultarPresentacionesModel();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$activePage = 'productos';
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
        <h2 class="mb-4">Registrar Producto</h2>

        <?php if (isset($_POST["txtMensaje"])): ?>
            <div class="alert alert-warning text-center">
                <?= $_POST["txtMensaje"] ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Nombre del producto -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-end col-form-label">Nombre</label>
                <div class="col-md-7">
                    <input type="text" name="txtNombre" class="form-control" required>
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
                    <input type="file" accept="image/png, image/jpeg" name="txtImagen" id="txtImagen"
                        class="form-control" required>
                </div>
            </div>

            <!-- Botón enviar -->
            <div class="form-group row mb-3">
                <div class="col-md-7 offset-sm-3">
                    <button type="submit" name="btnRegistrarProducto" id="btnRegistrarProducto"
                        class="btn btn-primary px-4">
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