<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarProductos.php';

$carrito = ConsultarCarrito();
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

    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-7">
                                    <h5 class="mb-3"><a href="Productos.php" class="text-body">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Seguir comprando
                                        </a></h5>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-1">Carrito de compras</p>
                                            <p class="mb-0">Tienes <?php echo count($carrito); ?> productos en tu
                                                carrito</p>
                                        </div>
                                    </div>

                                    <?php if ($carrito && count($carrito) > 0): ?>
                                        <?php foreach ($carrito as $item): ?>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div>
                                                            <img src="<?php echo $item['IMAGEN']; ?>"
                                                                class="img-fluid rounded-3" alt="Producto" style="width: 80px;">
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">
                                                            <h5><?php echo $item['NOMBREPRODUCTO']; ?></h5>
                                                            <p class="small text-muted mb-2"><?php echo $item['DESCRIPCION']; ?>
                                                            </p>
                                                            <div class="d-flex justify-content-start gap-3 align-items-center">
                                                                <span class="badge bg-secondary">Cantidad:
                                                                    <?php echo $item['CANTIDADCARRITO']; ?></span>
                                                                <span
                                                                    class="fw-bold">₡<?php echo $item['PRECIOPRODUCTO']; ?></span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                onclick="EliminarProductoCarrito(<?php echo $item['IDCARRITO']; ?>, <?php echo $item['IDPRODUCTO']; ?>)">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No hay productos en el carrito.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Resumen del pago -->
                                <div class="col-lg-5">
                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <?php
                                            $subtotal = 0;
                                            foreach ($carrito as $item) {
                                                $subtotal += $item['SUBTOTAL'];
                                            }
                                            $impuesto = $subtotal * 0.13;
                                            $total = $subtotal + $impuesto;
                                            ?>
                                            <h5 class="mb-3">Resumen del pedido</h5>
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Subtotal</p>
                                                <p class="mb-2">₡<?php echo $subtotal; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2">Impuesto</p>
                                                <p class="mb-2">₡<?php echo $impuesto; ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2 fw-bold">Total</p>
                                                <p class="mb-2 fw-bold">₡<?php echo $total; ?></p>
                                            </div>

                                            <button type="button" class="btn btn-info btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span>$<?php echo $total; ?></span>
                                                    <span> Pagar <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
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
                $('#IdProducto').val(id);
                $('#lblNombre').text("¿Desea eliminar el estado del producto " + nombre + "?");
            });
        });

        function EliminarProductoCarrito(idCarrito, idProducto) {
            $.ajax({
                url: "modulos/consultarProductos.php",
                type: "POST",
                dataType: 'text',
                data: {
                    Accion: "EliminarProductoCarrito",
                    idCarrito: idCarrito,
                    idProducto: idProducto
                },
                success: function (response) {
                    if (response === "OK") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                }
            });
        }

    </script>

</body>

</html>