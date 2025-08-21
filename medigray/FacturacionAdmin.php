<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';

$facturas = ConsultarFacturacionAdminModel();
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
                                            <th>Fecha Creación</th>
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
                                                    <td>₡<?= number_format($row["DESCUENTOS"], 2); ?></td>
                                                    <td>₡<?= number_format($row["SUBTOTAL"], 2); ?></td>
                                                    <td>₡<?= number_format($row["IVA"], 2); ?></td>
                                                    <td>₡<?= number_format($row["TOTAL_FACTURADO"], 2); ?></td>
                                                    <td><?= $row["ESTADO"]; ?></td>
                                                    <td><?= $row["FECHA_CREACION"]; ?></td>
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
