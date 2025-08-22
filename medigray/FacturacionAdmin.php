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
    <title>Facturación - Medigray</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
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
                        <a class="nav-link active" href="AdminDashboard.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="UsuariosAdmin.php">
                            <i class="bi bi-people-fill me-1"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ProductosAdmin.php">
                            <i class="bi bi-capsule me-1"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PedidosAdmin.php">
                            <i class="bi bi-cart-fill me-1"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="FacturasAdmin.php">
                            <i class="bi bi-receipt me-1"></i> Facturas
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
    <div class="container py-5 mt-4">
        <h3 class="mb-4">Gestión de Facturación</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <a href="generarFactura.php" class="btn btn-success">
                        <i class="bi bi-file-earmark-plus"></i> Generar Factura
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="tablaDatos" class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID FacturaS</th>
                                <th>ID Pedido</th>
                                <th>Método Pago</th>
                                <th>Fecha Emisión</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
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
                                        <td>₡<?= number_format((float) str_replace(',', '.', $row["DESCUENTOS"]), 2); ?></td>
                                        <td>₡<?= number_format((float) str_replace(',', '.', $row["SUBTOTAL"]), 2); ?></td>
                                        <td>₡<?= number_format((float) str_replace(',', '.', $row["IVA"]), 2); ?></td>
                                        <td>₡<?= number_format((float) str_replace(',', '.', $row["TOTAL_FACTURADO"]), 2); ?>
                                        </td>
                                        <td><?= $row["ESTADO"]; ?></td>

                                        <!-- Acciones (sin restricciones) -->
                                        <td class="text-center">
                                            <!-- Editar -->
                                            <a class="btn btn-info btn-accion"
                                                href="ActualizarFactura.php?q=<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Cancelar -->
                                            <button type="button" class="btn btn-danger btnCancelarFactura"
                                                data-id="<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>" data-bs-toggle="modal"
                                                data-bs-target="#modalCancelarFactura" title="Cancelar Factura">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">No se encontraron facturas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCancelarFactura" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="modulos/consultarFacturacion.php" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Cancelar Factura</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idFacturaCancelar" id="idFacturaCancelar">
                        <p>¿Está seguro que desea <strong>cancelar</strong> la factura #<span id="numFactura"></span>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="btnCancelarFactura" class="btn btn-danger">Sí, Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            new DataTable('#tablaDatos', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json',
                },
            });
        });

        // Llenar modal cancelar factura
        $('.btnCancelarFactura').click(function () {
            const id = $(this).data('id');
            $('#idFacturaCancelar').val(id);
            $('#numFactura').text(id);
        });
    </script>
</body>

</html>