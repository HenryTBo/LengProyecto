<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$idPedido = $_GET["q"];
$resultado = ConsultarDetallePedidoModel($idPedido);
$estados = ConsultarEstadosModel();
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
                                    <thead class="table- table-dark">
                                        <tr>
                                            <th>Id pedido</th>
                                            <th>Estado</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($resultado && count($resultado) > 0): ?>
                                            <?php foreach ($resultado as $row): ?>
                                                <tr>
                                                    <td><?= $row["ID_PEDIDO"]; ?></td>
                                                    <td><?= $row["ESTADO_DETALLE_NOMBRE"]; ?></td>
                                                    <td><?= $row["NOMBRE_PRODUCTO"]; ?></td>
                                                    <td><?= $row["CANTIDAD"]; ?></td>
                                                    <td>₡<?= number_format($row["PRECIO"], 2); ?></td>
                                                    <td>₡<?= number_format($row["SUBTOTAL"], 2); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btnAbrirModal" data-bs-toggle="modal"
                                                            data-bs-target="#EliminarPedido" data-id="<?= $row["ID_PEDIDO"]; ?>"
                                                            data-producto="<?= $row["ID_PRODUCTO"]; ?>"
                                                            data-nombre="<?= $row["NOMBRE_PRODUCTO"]; ?>">
                                                            <i class="fa fa-trash fs-4"></i>
                                                        </a>
                                                        </a>
                                                        <a class="btn btn-secondary btnAbrirModalEstado" data-bs-toggle="modal"
                                                            data-bs-target="#CambiarEstadoDetallePedido"
                                                            data-idpedido="<?= $row['ID_PEDIDO']; ?>"
                                                            data-idproducto="<?= $row['ID_PRODUCTO']; ?>"
                                                            data-nombre="<?= $row['NOMBRE_PRODUCTO']; ?>">
                                                            <i class="bi bi-caret-up"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No se encontraron productos</td>
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
        <div class="modal fade" id="EliminarPedido" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Confirmación</h5>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body text-center">
                            <input type="hidden" id="idPedidoEliminar" name="idPedidoEliminar">
                            <input type="hidden" id="idProductoEliminar" name="idProductoEliminar">
                            <p id="lblNombre" class="mb-0 font-weight-bold text-secondary"></p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" name="btnEliminarDetallePedido" class="btn btn-danger px-4">
                                <i class="fa fa-trash me-1"></i> Eliminar
                            </button>
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Cambiar Estado Detalle Pedido -->
        <div class="modal fade" id="CambiarEstadoDetallePedido" tabindex="-1" aria-labelledby="tituloModalEstado"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Cambiar Estado del Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body text-center">
                            <input type="hidden" id="idPedidoEstado" name="idPedidoEstado">
                            <input type="hidden" id="idProductoEstado" name="idProductoEstado">
                            <p id="lblProductoEstado" class="mb-3 font-weight-bold text-secondary"></p>

                            <div class="mb-3">
                                <label for="nuevoEstado" class="form-label">Seleccione nuevo estado:</label>
                                <select id="nuevoEstado" name="nuevoEstado" class="form-select" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO'] ?>"><?= $estado['ESTADO'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" name="btnActualizarEstadoDetalle" class="btn btn-success px-4">
                                <i class="fa fa-check me-1"></i> Actualizar
                            </button>
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                Cancelar
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
                const idPedido = $(this).data('id');
                const idProducto = $(this).data('producto'); // nuevo atributo
                const nombre = $(this).data('nombre');

                $('#idPedidoEliminar').val(idPedido);
                $('#idProductoEliminar').val(idProducto);
                $('#lblNombre').text("¿Desea eliminar el producto " + nombre + " de este pedido?");
            });

            $('.btnAbrirModalEstado').on('click', function () {
                const idPedido = $(this).data('idpedido');
                const idProducto = $(this).data('idproducto');
                const nombre = $(this).data('nombre');

                $('#idPedidoEstado').val(idPedido);
                $('#idProductoEstado').val(idProducto);
                $('#lblProductoEstado').text("Producto: " + nombre);
            });
        });
    </script>
</body>

</html>