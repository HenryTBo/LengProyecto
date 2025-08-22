<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

// Llamada al modelo que trae todos los contactos
$contactos = ConsultarContactosAdminModel();

$activePage = 'contactos';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
</head>

<body>
    <header>
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
    </header>

    <section class="py-5">
        <div class="container">

            <h3 class="mb-4">Gestión de Contacto</h3>

            <?php if (isset($_POST["txtMensaje"])): ?>
                <div class="alert alert-warning text-center">
                    <?= $_POST["txtMensaje"] ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaContactos" class="table table-striped table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Contacto</th>
                                    <th>ID Usuario</th>
                                    <th>Asunto</th>
                                    <th>Mensaje</th>
                                    <th>Fecha Envío</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($contactos && count($contactos) > 0): ?>
                                    <?php foreach ($contactos as $row): ?>
                                        <tr>
                                            <td><?= $row["CONTACTO_ID_CONTACTO_PK"]; ?></td>
                                            <td><?= $row["USUARIOS_ID_USUARIO_FK"]; ?></td>
                                            <td><?= htmlspecialchars($row["ASUNTO"]); ?></td>
                                            <td><?= substr(htmlspecialchars($row["MENSAJE"]), 0, 100) . '...'; ?></td>
                                            <td><?= $row["FECHA_ENVIO"]; ?></td>
                                            <td><?= $row["ESTADO"]; ?></td>
                                            <td class="text-center">
                                                <form method="POST" action="" style="display:inline;">
                                                    <input type="hidden" name="contacto_id"
                                                        value="<?= $row["CONTACTO_ID_CONTACTO_PK"]; ?>">
                                                    <button type="submit" name="btnMarcarLeido"
                                                        class="btn btn-sm btn-outline-primary" title="Marcar como leído">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No se encontraron contactos</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tablaContactos').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>

</html>