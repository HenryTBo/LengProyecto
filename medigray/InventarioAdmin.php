<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$productos = ConsultarInventarioAdminModel();
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
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="registrarInventario.php" class="btn btn-info">
                                    <i class="fa fa-plus me-1"></i> Agregar
                                </a>
                            </div>
                            <div class="table-responsive"
                                style="max-height: 600px; overflow-y: auto; overflow-x: auto;">
                                <table id="tablaDatos" class="table table-striped table-bordered align-middle"
                                    style="min-width:1300px;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID_Movi</th>
                                            <th>ID_Pro</th>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Almacén</th>
                                            <th>Stock</th>
                                            <th>Estado Inventario</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($productos && count($productos) > 0): ?>
                                            <?php foreach ($productos as $row): ?>
                                                <tr>
                                                    <td><?= $row["ID_MOVIMIENTO"]; ?></td>
                                                    <td><?= $row["ID_PRODUCTO"]; ?></td>
                                                    <td><?= $row["NOMBRE_PRODUCTO"]; ?></td>
                                                    <td>₡<?= number_format($row["PRECIO_UNITARIO"], 2); ?></td>
                                                    <td><?= $row["ALMACENADO"]; ?></td>
                                                    <td><?= $row["CANTIDAD_STOCK"]; ?></td>
                                                    <td><?= $row["ESTADO_INVENTARIO"]; ?></td>
                                                    <td><?= $row["FECHA_INGRESO"]; ?></td>
                                                    <td><?= $row["OBSERVACIONES"]; ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btnAbrirModal" data-bs-toggle="modal"
                                                            data-bs-target="#EliminarMovimiento"
                                                            data-id="<?= $row["ID_MOVIMIENTO"]; ?>"
                                                            data-nombre="<?= $row["NOMBRE_PRODUCTO"]; ?>">
                                                            <i class="fa fa-trash fs-4"></i>
                                                        </a>
                                                        <a class="btn btnActualizar"
                                                            href="actualizarInventario.php?q=<?= $row["ID_MOVIMIENTO"]; ?>">
                                                            <i class="fa fa-edit fs-4"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="10" class="text-center">No se encontraron registros de
                                                    inventario</td>
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



        <!-- Modal Cambiar Estado Producto -->
        <!-- Modal Eliminar Inventario -->
        <div class="modal fade" id="EliminarMovimiento" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="tituloModal">Confirmación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body text-center">
                            <input type="hidden" id="idMovimientoEliminar" name="idMovimientoEliminar">
                            <p class="mb-3">¿Estás seguro que deseas eliminar este registro de inventario?</p>
                            <p id="lblNombreProducto" class="fw-bold text-secondary"></p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" name="btnEliminarMovimiento" class="btn btn-danger px-4">
                                <i class="fa fa-trash me-1"></i> Eliminar
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
                const idMovimiento = $(this).data('id');       // ID_MOVIMIENTO
                const nombreProducto = $(this).data('nombre'); // Nombre del producto

                $('#idMovimientoEliminar').val(idMovimiento);
                $('#lblNombreProducto').text("¿Deseas eliminar el registro de inventario de: " + nombreProducto + "?");
            });
        });
    </script>
</body>

</html>