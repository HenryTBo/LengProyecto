<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

$usuarios = ConsultarUsuariosAdminModel(); // Debe devolver todos los usuarios con info de tipo y cargo

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$activePage = 'usuarios';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
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
                        } ?>"
                            href="InventarioAdmin.php">
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


    <section class="users-content py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-12">
                    <h3 class="mb-4">Gestión de Usuarios</h3>
                    <?php if (isset($_POST["txtMensaje"])): ?>
                        <div class="alert alert-warning text-center">
                            <?= $_POST["txtMensaje"] ?>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablaDatos" class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Tipo Usuario</th>
                                            <th>Cargo</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($usuarios && count($usuarios) > 0): ?>
                                            <?php foreach ($usuarios as $row): ?>
                                                <tr>
                                                    <td><?= $row["USUARIO_ID_USUARIO_PK"]; ?></td>
                                                    <td><?= $row["NOMBRE"]; ?></td>
                                                    <td><?= $row["TELEFONO"]; ?></td>
                                                    <td><?= $row["EMAIL"]; ?></td>
                                                    <td><?= $row["NOMBRE_TIPO_USUARIO"]; ?></td>
                                                    <td><?= $row["NOMBRE_CARGO"]; ?></td>
                                                    <td><?= $row["ESTADO"]; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btnAbrirModal btn-sm"
                                                            data-id="<?= $row["USUARIO_ID_USUARIO_PK"]; ?>"
                                                            data-nombre="<?= $row["NOMBRE"]; ?>"
                                                            title="<?= $row["ESTADO"] == 'Activo' ? 'Inactivar Usuario' : 'Activar Usuario'; ?>">
                                                            <i
                                                                class="<?= $row["ESTADO"] == 'Activo' ? 'bi bi-toggle-on text-success' : 'bi bi-toggle-off text-danger'; ?>"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No se encontraron usuarios</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Cambiar Estado Usuario -->
        <div class="modal fade" id="CambiarEstadoUsuario" tabindex="-1" role="dialog" aria-labelledby="tituloModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-3 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="tituloModal">Confirmación</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <form method="POST" action="">
                        <div class="modal-body text-center">
                            <input type="hidden" id="IdUsuario" name="IdUsuario" class="form-control">
                            <p id="lblNombre" class="mb-0" style="font-weight:600;"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btnInactivarUsuario" name="btnInactivarUsuario"
                                class="btn btn-primary px-4">
                                Procesar
                            </button>
                            <button type="button" class="btn btn-secondary px-4"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts de Bootstrap y DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function () {
            $('#tablaDatos').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json'
                }
            });

            $('.btnAbrirModal').on('click', function () {
                const id = $(this).data('id');
                const nombre = $(this).data('nombre');

                $('#IdUsuario').val(id);
                $('#lblNombre').text("¿Desea inactivar al usuario \"" + nombre + "\"?");
                $('#CambiarEstadoUsuario').modal('show');
            });
        });
    </script>
</body>

</html>