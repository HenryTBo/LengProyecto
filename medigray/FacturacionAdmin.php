<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

$facturas = ConsultarFacturacionAdminModel();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

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
                        <a class="nav-link active" href="AdminDashboard.php">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="UsuariosAdmin.php">
                            <i class="bi bi-people-fill me-1"></i>Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ProductosAdmin.php">
                            <i class="bi bi-capsule me-1"></i>Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PedidosAdmin.php">
                            <i class="bi bi-cart-fill me-1"></i>Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="FacturacionAdmin.php">
                            <i class="bi bi-receipt me-1"></i>Facturación
                        </a>
                    </li>
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

    <section class="products-content py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-12">

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
                                            <th>ID Factura</th>
                                            <th>ID Pedido</th>
                                            <th>Método Pago</th>
                                            <th>Fecha Emisión</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($facturas && count($facturas) > 0): ?>
                                            <?php foreach ($facturas as $row): ?>
                                                <tr>
                                                    <td><?= $row["FACTURACION_ID_FACTURA_PK"]; ?></td>
                                                    <td><?= $row["PEDIDOS_ID_PEDIDO_FK"]; ?></td>
                                                    <td><?= $row["METODO_PAGO"]; ?></td>
                                                    <td><?= $row["FECHA_EMISION"]; ?></td>
                                                    <td>₡<?= number_format((float) str_replace(',', '.', $row["DESCUENTOS"]), 2); ?>
                                                    </td>
                                                    <td>₡<?= number_format((float) str_replace(',', '.', $row["SUBTOTAL"]), 2); ?>
                                                    </td>
                                                    <td>₡<?= number_format((float) str_replace(',', '.', $row["IVA"]), 2); ?>
                                                    </td>
                                                    <td>₡<?= number_format((float) str_replace(',', '.', $row["TOTAL_FACTURADO"]), 2); ?>
                                                    </td>

                                                    <td><?= $row["ESTADO"]; ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btnAbrirModal" data-bs-toggle="modal"
                                                            data-bs-target="#EliminarFactura"
                                                            data-id="<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                            data-nombre="Factura #<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>">
                                                            <i class="fa fa-trash fs-4"></i>
                                                        </a>
                                                        <a class="btn"
                                                            href="ActualizarFactura.php?q=<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>">
                                                            <i class="fa fa-edit fs-4"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="11" class="text-center">No se encontraron facturas</td>
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

        <!-- Modal Eliminar Factura -->
        <div class="modal fade" id="EliminarFactura" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Confirmación</h5>
                    </div>
                    <form action="modulos/consultarFacturacion.php" method="POST">
                        <div class="modal-body text-center">
                            <input type="hidden" id="idFacturaEliminar" name="idFacturaEliminar">
                            <p id="lblNombre" class="mb-0 font-weight-bold text-secondary"></p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" name="btnEliminarFactura" class="btn btn-primary px-4">
                                <i class="fa fa-check mr-1"></i> Procesar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts de Bootstrap y personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="JS/script.js"></script>
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
    <script>
        $(function () {
            new DataTable('#tablaDatos', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json',
                },
            });

            $('.btnAbrirModal').on('click', function () {
                const id = $(this).data('id');
                const nombre = $(this).data('nombre');
                $('#idFacturaEliminar').val(id);
                $('#lblNombre').text("¿Desea eliminar la " + nombre + "?");
            });
        });
    </script>
</body>

</html>