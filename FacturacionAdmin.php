<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/consultarFacturacion.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/guardarFactura.php';
include_once $_SERVER["DOCUMENT_ROOT"] . '/LengProyecto/medigray/modulos/cambiarEstadoFactura.php';

$facturas = ConsultarFacturacionAdminModel();
$pedidosPendientes = ObtenerPedidosPendientes();
$estadosDisponibles = ObtenerEstadosDisponibles();
$metodosPago = ObtenerMetodosPago();
$tiposEntrega = ObtenerTiposEntrega();
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
    <style>
        .badge-estado {
            font-size: 0.85em;
            padding: 0.5em 0.8em;
        }
        .estado-activo { background-color: #28a745; }
        .estado-inactivo { background-color: #dc3545; }
        .estado-pendiente { background-color: #ffc107; color: #000; }
        .estado-completado { background-color: #17a2b8; }
        .estado-cancelado { background-color: #6c757d; }
        
        .btn-accion {
            margin: 2px;
            padding: 8px 12px;
            font-size: 0.9em;
        }
        
        .header-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
    </style>
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

    <!-- Header Admin -->
    <div class="header-admin" style="margin-top: 120px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="bi bi-receipt"></i> Administración de Facturas</h1>
                    <p class="mb-0">Gestiona todas las facturas del sistema MediGray</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalNuevaFactura">
                        <i class="bi bi-plus-circle"></i> Nueva Factura
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="products-content py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-12">

                    <!-- Alertas -->
                    <?php if (isset($_GET['ok'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i>
                            <?php if (isset($_GET['factura'])): ?>
                                Factura creada exitosamente.
                            <?php elseif (isset($_GET['updated'])): ?>
                                Factura #<?= $_GET['updated'] ?> actualizada exitosamente.
                            <?php elseif (isset($_GET['estado_changed'])): ?>
                                Estado de factura #<?= $_GET['estado_changed'] ?> cambiado exitosamente.
                            <?php elseif (isset($_GET['anulada'])): ?>
                                Factura #<?= $_GET['anulada'] ?> anulada exitosamente.
                            <?php else: ?>
                                Operación realizada exitosamente.
                            <?php endif; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['err'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i>
                            Error: <?= htmlspecialchars($_GET['err']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tabla de Facturas -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-table"></i> Lista de Facturas</h5>
                        </div>
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
                                                    <td><strong>#<?= $row["FACTURACION_ID_FACTURA_PK"]; ?></strong></td>
                                                    <td>#<?= $row["PEDIDOS_ID_PEDIDO_FK"]; ?></td>
                                                    <td><?= $row["METODO_PAGO"]; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($row["FECHA_EMISION"])); ?></td>
                                                    <td>₡<?= number_format($row["DESCUENTOS"], 2); ?></td>
                                                    <td>₡<?= number_format($row["SUBTOTAL"], 2); ?></td>
                                                    <td>₡<?= number_format($row["IVA"], 2); ?></td>
                                                    <td><strong>₡<?= number_format($row["TOTAL_FACTURADO"], 2); ?></strong></td>
                                                    <td>
                                                        <span class="badge badge-estado estado-<?= strtolower($row["ESTADO"]); ?>">
                                                            <?= $row["ESTADO"]; ?>
                                                        </span>
                                                    </td>
                                                    <td><?= date('d/m/Y H:i', strtotime($row["FECHA_CREACION"])); ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group-vertical" role="group">
                                                            <!-- Cambiar Estado -->
                                                            <?php if ($row["ESTADO"] != 'Inactivo' && $row["ESTADO"] != 'Completado'): ?>
                                                                <button class="btn btn-warning btn-accion btnCambiarEstado" 
                                                                        data-bs-toggle="modal" data-bs-target="#modalCambiarEstado"
                                                                        data-id="<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                                        data-estado="<?= $row["ESTADO"]; ?>"
                                                                        title="Cambiar Estado">
                                                                    <i class="bi bi-arrow-repeat"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <!-- Editar -->
                                                            <?php if ($row["ESTADO"] != 'Inactivo'): ?>
                                                                <a class="btn btn-info btn-accion"
                                                                   href="actualizarFactura.php?q=<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                                   title="Editar">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            
                                                            <!-- Anular -->
                                                            <?php if ($row["ESTADO"] != 'Inactivo'): ?>
                                                                <button class="btn btn-danger btn-accion btnAnularFactura"
                                                                        data-bs-toggle="modal" data-bs-target="#modalAnularFactura"
                                                                        data-id="<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                                        data-nombre="Factura #<?= $row["FACTURACION_ID_FACTURA_PK"]; ?>"
                                                                        title="Anular">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
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

        <!-- Modal Nueva Factura -->
        <div class="modal fade" id="modalNuevaFactura" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Crear Nueva Factura</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="modulos/guardarFactura.php" method="POST">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pedido Pendiente *</label>
                                    <select name="idPedido" class="form-select" required>
                                        <option value="">Seleccionar pedido...</option>
                                        <?php if ($pedidosPendientes): ?>
                                            <?php foreach ($pedidosPendientes as $pedido): ?>
                                                <option value="<?= $pedido['PEDIDOS_ID_PEDIDO_PK']; ?>" 
                                                        data-total="<?= $pedido['TOTAL']; ?>">
                                                    Pedido #<?= $pedido['PEDIDOS_ID_PEDIDO_PK']; ?> - 
                                                    <?= $pedido['CLIENTE_NOMBRE']; ?> - 
                                                    ₡<?= number_format($pedido['TOTAL'], 2); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha Factura *</label>
                                    <input type="date" name="fechaFactura" class="form-control" 
                                           value="<?= date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total *</label>
                                    <input type="number" name="total" class="form-control" step="0.01" 
                                           placeholder="0.00" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Entrega *</label>
                                    <select name="tipoEntrega" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($tiposEntrega as $key => $value): ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Método de Pago *</label>
                                    <select name="metodoPago" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($metodosPago as $key => $value): ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dirección de Envío</label>
                                    <input type="text" name="direccionEnvio" class="form-control" 
                                           placeholder="Solo para entregas a domicilio">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notas</label>
                                    <textarea name="notas" class="form-control" rows="3" 
                                              placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btnGuardarFactura" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Crear Factura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Cambiar Estado -->
        <div class="modal fade" id="modalCambiarEstado" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-arrow-repeat"></i> Cambiar Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="modulos/cambiarEstadoFactura.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="idFacturaCambio" name="idFactura">
                            <div class="mb-3">
                                <label class="form-label">Estado Actual</label>
                                <input type="text" id="estadoActual" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nuevo Estado *</label>
                                <select name="nuevoEstado" id="nuevoEstado" class="form-select" required>
                                    <option value="">Seleccionar nuevo estado...</option>
                                    <?php foreach ($estadosDisponibles as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Motivo del Cambio</label>
                                <textarea name="motivoCambio" class="form-control" rows="3" 
                                          placeholder="Razón del cambio de estado..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btnCambiarEstado" class="btn btn-warning">
                                <i class="bi bi-arrow-repeat"></i> Cambiar Estado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Anular Factura -->
        <div class="modal fade" id="modalAnularFactura" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Anular Factura</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="modulos/cambiarEstadoFactura.php" method="POST">
                        <div class="modal-body text-center">
                            <input type="hidden" id="idFacturaAnular" name="idFactura">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">¿Confirmar anulación?</h5>
                            <p id="textoAnulacion" class="text-muted"></p>
                            <div class="mt-3">
                                <label class="form-label">Motivo de Anulación *</label>
                                <textarea name="motivoAnulacion" class="form-control" rows="3" 
                                          placeholder="Especifique el motivo de la anulación..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="btnDesactivarFactura" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Anular Factura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="JS/script.js"></script>
    <script>
        $(function () {
            // Inicializar DataTable
            new DataTable('#tablaDatos', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json',
                },
                order: [[0, 'desc']] // Ordenar por ID de factura descendente
            });

            // Estados disponibles para cambios desde PHP
            const estadosDisponibles = <?= json_encode($estadosDisponibles) ?>;

            // Modal Nueva Factura - Auto llenar total
            $('select[name="idPedido"]').change(function() {
                const selectedOption = $(this).find(':selected');
                const total = selectedOption.data('total');
                $('input[name="total"]').val(total || '');
            });

            // Modal Cambiar Estado
            $('.btnCambiarEstado').click(function() {
                const id = $(this).data('id');
                const estadoActual = $(this).data('estado');
                
                $('#idFacturaCambio').val(id);
                $('#estadoActual').val(estadoActual);
            });

            // Modal Anular Factura
            $('.btnAnularFactura').click(function() {
                const id = $(this).data('id');
                const nombre = $(this).data('nombre');
                $('#idFacturaAnular').val(id);
                $('#textoAnulacion').text(`¿Está seguro de anular la ${nombre}? Esta acción no se puede deshacer.`);
            });
        });
    </script>
</body>
</html>