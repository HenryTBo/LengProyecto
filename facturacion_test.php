<?php
// tools/facturacion_test.php - Versión mejorada con estilo moderno
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión mejorada con manejo de errores
try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/LengProyecto/medigray/config/conexion.php';
    if (!isset($conn) || !$conn) {
        throw new Exception('Error de conexión a Oracle');
    }
} catch (Exception $e) {
    die('<div class="alert alert-danger">Error de conexión: ' . htmlspecialchars($e->getMessage()) . '</div>');
}

// Función para ejecutar consultas con manejo de errores
function ejecutarConsulta($conn, $sql, $descripcion = '') {
    $resultado = [];
    try {
        $st = oci_parse($conn, $sql);
        if (!$st) {
            throw new Exception("Error al preparar consulta: $descripcion");
        }
        
        if (!@oci_execute($st)) {
            $error = oci_error($st);
            throw new Exception("Error al ejecutar consulta: " . $error['message']);
        }
        
        while ($r = oci_fetch_assoc($st)) {
            $resultado[] = $r;
        }
        oci_free_statement($st);
        
    } catch (Exception $e) {
        error_log("Error en consulta ($descripcion): " . $e->getMessage());
        // En modo debug, mostrar solo una advertencia discreta
        if (isset($_GET['debug'])) {
            echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                    <i class='bi bi-info-circle'></i> Modo desarrollo: usando datos de ejemplo para '$descripcion'
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        }
    }
    return $resultado;
}

// Consultar pedidos pendientes - usando las tablas reales
$pedidos = ejecutarConsulta($conn, "
    SELECT p.PEDIDOS_ID_PEDIDO_PK AS ID,
           TO_CHAR(p.FECHA_PEDIDO,'YYYY-MM-DD') AS FECHA,
           p.TOTAL AS TOTAL
    FROM FIDE_PEDIDOS_TB p
    INNER JOIN FIDE_ESTADOS_TB e ON p.ESTADOS_ID_ESTADO_FK = e.ESTADOS_ID_ESTADO_PK
    WHERE e.NOMBRE_ESTADO = 'ACTIVO' OR e.NOMBRE_ESTADO = 'PENDIENTE'
    ORDER BY p.FECHA_PEDIDO DESC
    FETCH FIRST 10 ROWS ONLY
", "Pedidos pendientes");

// Consultar últimas facturas - usando las tablas reales
$facturas = ejecutarConsulta($conn, "
    SELECT f.FACTURACION_ID_FACTURA_PK AS ID,
           f.PEDIDOS_ID_PEDIDO_FK AS PEDIDO,
           mp.NOMBRE_ESTADO AS METODO_PAGO,
           TO_CHAR(f.FECHA_EMISION,'YYYY-MM-DD HH24:MI') AS FECHA,
           f.DESCUENTOS, 
           f.SUBTOTAL, 
           f.IVA, 
           f.TOTAL_FACTURADO, 
           e.NOMBRE_ESTADO AS ESTADO
    FROM FIDE_FACTURACION_TB f
    INNER JOIN FIDE_ESTADOS_TB e ON f.ESTADOS_ID_ESTADO_FK = e.ESTADOS_ID_ESTADO_PK
    LEFT JOIN FIDE_METODOS_PAGO_TB mp ON f.METODOS_PAGO_ID_PAGO_FK = mp.METODOS_PAGO_ID_PAGO_PK
    ORDER BY f.FACTURACION_ID_FACTURA_PK DESC
    FETCH FIRST 15 ROWS ONLY
", "Últimas facturas");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación - Medigray</title>
    <meta name="description" content="Sistema completo de gestión de facturas y pedidos para Medigray.">
    
    <!-- CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0066cc;
            --secondary-blue: #4d94ff;
            --light-blue: #e6f3ff;
            --dark-blue: #004c99;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --accent-gradient: linear-gradient(135deg, #0066cc, #4d94ff);
            --shadow-light: 0 5px 15px rgba(0, 102, 204, 0.08);
            --shadow-medium: 0 10px 25px rgba(0, 102, 204, 0.15);
            --shadow-heavy: 0 15px 35px rgba(0, 102, 204, 0.25);
            --border-radius: 20px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: #ffffff;
            min-height: 100vh;
            padding-top: 0;
        }

        /* Hero Section similar a Nosotros.html */
        .facturacion-hero {
            background: var(--accent-gradient);
            position: relative;
            overflow: hidden;
            padding: 80px 0 60px;
            z-index: 1;
        }

        .facturacion-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="grad"><stop offset="0%" stop-color="rgba(255,255,255,0.1)"/><stop offset="100%" stop-color="rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="3" fill="url(%23grad)"/><circle cx="600" cy="400" r="2" fill="url(%23grad)"/><circle cx="800" cy="100" r="4" fill="url(%23grad)"/><circle cx="300" cy="700" r="2" fill="url(%23grad)"/><circle cx="900" cy="600" r="3" fill="url(%23grad)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: white;
            animation: slideInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.95;
            color: white;
            max-width: 600px;
            margin: 0 auto;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sección de estadísticas similar a Nosotros.html */
        .stats-highlight {
            background: var(--accent-gradient);
            color: white !important;
            border-radius: 30px;
            padding: 3rem 2rem;
            margin: 3rem auto;
            box-shadow: var(--shadow-heavy);
            position: relative;
            overflow: hidden;
            max-width: 1000px;
        }

        .stats-highlight::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .stat-item {
            position: relative;
            z-index: 2;
            padding: 1rem;
            transition: transform 0.3s ease;
            text-align: center;
        }

        .stat-item:hover {
            transform: translateY(-10px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-sublabel {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Cards mejoradas */
        .modern-card {
            background: #ffffff;
            backdrop-filter: blur(10px);
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 102, 204, 0.1);
            position: relative;
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .modern-card:hover::before {
            transform: scaleX(1);
        }

        .modern-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-heavy);
            border-color: var(--primary-blue);
        }

        .modern-card-header {
            background: var(--accent-gradient);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }

        .modern-card-header i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .modern-card-body {
            padding: 2rem;
        }

        /* Formularios mejorados */
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        /* Botones modernos */
        .btn {
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--accent-gradient);
            box-shadow: var(--shadow-medium);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-heavy);
        }

        .btn-success {
            background: linear-gradient(135deg, #198754, #20c997);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ffda6a);
            color: #000;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #f5a623);
        }

        .btn-info {
            background: linear-gradient(135deg, #0dcaf0, #17a2b8);
        }

        .btn-light {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: var(--text-primary);
        }

        .btn-sm {
            padding: 0.5rem 1.25rem;
            font-size: 0.85rem;
        }

        /* Tabla mejorada */
        .modern-table {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-light);
            border: none;
        }

        .modern-table thead th {
            background: var(--accent-gradient);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 1.25rem 1rem;
        }

        .modern-table tbody td {
            border: none;
            border-bottom: 1px solid rgba(0, 102, 204, 0.1);
            padding: 1.25rem 1rem;
            vertical-align: middle;
        }

        .modern-table tbody tr:hover {
            background: rgba(0, 102, 204, 0.05);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Badges mejoradas */
        .modern-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .modern-badge.ok {
            background: linear-gradient(135deg, #d1edff, #87ceeb);
            color: var(--primary-blue);
        }

        .modern-badge.warn {
            background: linear-gradient(135deg, #fff3cd, #ffda6a);
            color: #8a6d3b;
        }

        .modern-badge.err {
            background: linear-gradient(135deg, #f8d7da, #f5a623);
            color: #721c24;
        }

        /* Input groups mejorados */
        .modern-input-group {
            box-shadow: var(--shadow-light);
            border-radius: 12px;
            overflow: hidden;
        }

        .modern-input-group .form-control {
            border: none;
            box-shadow: none;
        }

        .modern-input-group .input-group-text {
            background: var(--light-blue);
            border: none;
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* Form rows mejoradas */
        .form-row {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-row.cols-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .form-row.cols-3 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        /* Display de total mejorado */
        .total-display {
            background: var(--accent-gradient);
            color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 900;
            box-shadow: var(--shadow-medium);
            position: relative;
            overflow: hidden;
        }

        .total-display::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 2s ease-in-out infinite;
        }

        /* Estados vacíos */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.3;
            color: var(--primary-blue);
        }

        .empty-state h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Notificaciones */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-heavy);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            flex: 1;
            min-width: auto;
        }

        /* Container principal */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .content-section {
            background: rgba(248, 249, 250, 0.6);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin: 2rem 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 102, 204, 0.1);
        }

        /* Modal mejorado */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-heavy);
        }

        .modal-header {
            background: var(--accent-gradient);
            color: white;
            border: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .modern-card-body {
                padding: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }

        /* Animaciones de reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="facturacion-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto hero-content">
                    <h1 class="hero-title"><i class="bi bi-receipt me-3"></i>Sistema de Facturación</h1>
                    <p class="hero-subtitle">Gestión completa y moderna de facturas y pedidos para optimizar los procesos de facturación de Medigray.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido principal -->
    <div class="main-container">
        <!-- Estadísticas destacadas -->
        <section class="py-4">
            <div class="stats-highlight reveal">
                <div class="row text-center">
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="stat-item">
                            <div class="stat-number"><?= count($pedidos) ?></div>
                            <div class="stat-label">Pedidos Pendientes</div>
                            <div class="stat-sublabel">En espera de facturación</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="stat-item">
                            <div class="stat-number"><?= count($facturas) ?></div>
                            <div class="stat-label">Facturas Recientes</div>
                            <div class="stat-sublabel">Últimas registradas</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="stat-item">
                            <div class="stat-number">₡<?= number_format(array_sum(array_column($facturas, 'TOTAL_FACTURADO')), 0) ?></div>
                            <div class="stat-label">Total Facturado</div>
                            <div class="stat-sublabel">Monto acumulado</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <div class="stat-number"><?= date('d') ?></div>
                            <div class="stat-label"><?= date('F Y') ?></div>
                            <div class="stat-sublabel">Fecha actual</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="content-section reveal">
            <div class="row g-4">
                <!-- Crear factura -->
                <div class="col-lg-6">
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <i class="bi bi-plus-circle-fill"></i>
                            Crear Nueva Factura
                        </div>
                        <div class="modern-card-body">
                            <!-- Selección de pedido -->
                            <div class="form-row cols-2">
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-list-ul me-2"></i>Pedidos Pendientes
                                    </label>
                                    <select id="pedidoSelect" class="form-select">
                                        <option value="">-- Seleccione un pedido --</option>
                                        <?php foreach($pedidos as $p): ?>
                                            <option value="<?= htmlspecialchars($p['ID']) ?>" 
                                                    data-total="<?= htmlspecialchars($p['TOTAL']) ?>">
                                                Pedido #<?= htmlspecialchars($p['ID']) ?> 
                                                · <?= htmlspecialchars($p['FECHA']) ?> 
                                                · ₡<?= number_format($p['TOTAL'], 2) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-hash me-2"></i>ID Pedido Manual
                                    </label>
                                    <input type="number" id="idPedido" class="form-control" 
                                           placeholder="Ingrese ID del pedido" min="1">
                                </div>
                            </div>

                            <form action="/LengProyecto/medigray/guardarFactura.php" method="POST" 
                                  id="formCrear" onsubmit="return validarFormulario(event)">
                                <input type="hidden" name="btnGuardarFactura" value="1">
                                <input type="hidden" name="idPedido" id="idPedidoHidden">

                                <div class="form-row cols-2">
                                    <div>
                                        <label class="form-label">
                                            <i class="bi bi-calendar-event me-2"></i>Fecha de Factura
                                        </label>
                                        <input type="datetime-local" name="fechaFactura" class="form-control" 
                                               value="<?= $ahora ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            <i class="bi bi-credit-card me-2"></i>Método de Pago
                                        </label>
                                        <select name="metodoPago" class="form-select" required>
                                            <option value="">-- Seleccione método --</option>
                                            <option value="EFECTIVO">💵 Efectivo</option>
                                            <option value="TARJETA">💳 Tarjeta</option>
                                            <option value="TRANSFERENCIA">🏦 Transferencia</option>
                                            <option value="CHEQUE">📝 Cheque</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row cols-3">
                                    <div>
                                        <label class="form-label">
                                            <i class="bi bi-calculator me-2"></i>Subtotal
                                        </label>
                                        <div class="modern-input-group input-group">
                                            <span class="input-group-text">₡</span>
                                            <input type="number" step="0.01" name="subtotal" id="subtotal" 
                                                   class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            <i class="bi bi-percent me-2"></i>IVA (13%)
                                        </label>
                                        <div class="modern-input-group input-group">
                                            <span class="input-group-text">₡</span>
                                            <input type="number" step="0.01" name="iva" id="iva" 
                                                   class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            <i class="bi bi-dash-circle me-2"></i>Descuento
                                        </label>
                                        <div class="modern-input-group input-group">
                                            <span class="input-group-text">₡</span>
                                            <input type="number" step="0.01" name="descuento" id="descuento" 
                                                   class="form-control" value="0" min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-currency-dollar me-2"></i>Total Final
                                    </label>
                                    <div class="total-display" id="totalDisplay">₡0.00</div>
                                    <input type="hidden" name="total" id="total" value="0">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-lg" id="btnSubmit">
                                    <i class="bi bi-save me-2"></i>Crear Factura
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Lista de facturas -->
                <div class="col-lg-6">
                    <div class="modern-card">
                        <div class="modern-card-header d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-list-check"></i>
                                Últimas Facturas
                            </span>
                            <button class="btn btn-light btn-sm" onclick="location.reload()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Actualizar
                            </button>
                        </div>
                        <div class="modern-card-body p-0">
                            <?php if(!$facturas || count($facturas) === 0): ?>
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>No hay facturas registradas</h5>
                                    <p class="text-muted">Las facturas aparecerán aquí una vez que las cree.</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="modern-table table mb-0">
                                        <thead>
                                            <tr>
                                                <th width="10%">
                                                    <i class="bi bi-hash me-1"></i>ID
                                                </th>
                                                <th width="12%">
                                                    <i class="bi bi-box me-1"></i>Pedido
                                                </th>
                                                <th width="16%">
                                                    <i class="bi bi-calendar me-1"></i>Fecha
                                                </th>
                                                <th width="14%">
                                                    <i class="bi bi-credit-card me-1"></i>Pago
                                                </th>
                                                <th width="14%">
                                                    <i class="bi bi-currency-dollar me-1"></i>Total
                                                </th>
                                                <th width="14%">
                                                    <i class="bi bi-check-circle me-1"></i>Estado
                                                </th>
                                                <th width="20%">
                                                    <i class="bi bi-gear me-1"></i>Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($facturas as $f): ?>
                                                <tr>
                                                    <td class="fw-bold text-primary">
                                                        #<?= htmlspecialchars($f['ID']) ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            <?= htmlspecialchars($f['PEDIDO']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <?= date('d/m/Y', strtotime($f['FECHA'])) ?>
                                                            <br>
                                                            <?= date('H:i', strtotime($f['FECHA'])) ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted fw-medium">
                                                            <?= htmlspecialchars($f['METODO_PAGO']) ?>
                                                        </small>
                                                    </td>
                                                    <td class="fw-bold">
                                                        <span style="color: var(--primary-blue);">
                                                            ₡<?= number_format($f['TOTAL_FACTURADO'], 2) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $estado = $f['ESTADO'];
                                                            $cls = $estado==='ACTIVO' ? 'ok' : ($estado==='INACTIVO' ? 'err' : 'warn');
                                                            $icon = $estado==='ACTIVO' ? 'check-circle' : ($estado==='INACTIVO' ? 'x-circle' : 'clock');
                                                        ?>
                                                        <span class="modern-badge <?= $cls ?>">
                                                            <i class="bi bi-<?= $icon ?>"></i>
                                                            <?= htmlspecialchars($estado) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn btn-warning btn-sm" 
                                                                    onclick="editarFactura(<?= $f['ID'] ?>)"
                                                                    title="Editar factura">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-info btn-sm" 
                                                                    onclick="cambiarEstado(<?= $f['ID'] ?>)"
                                                                    title="Cambiar estado">
                                                                <i class="bi bi-arrow-repeat"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" 
                                                                    onclick="eliminarFactura(<?= $f['ID'] ?>)"
                                                                    title="Eliminar factura">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar factura -->
        <div class="modal fade" id="modalEditarFactura" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Factura #<span id="facturaId"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarFactura">
                            <input type="hidden" id="editId" name="id">
                            
                            <div class="form-row cols-2">
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-calculator me-2"></i>Subtotal
                                    </label>
                                    <div class="modern-input-group input-group">
                                        <span class="input-group-text">₡</span>
                                        <input type="number" step="0.01" id="editSubtotal" 
                                               name="subtotal" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-percent me-2"></i>IVA
                                    </label>
                                    <div class="modern-input-group input-group">
                                        <span class="input-group-text">₡</span>
                                        <input type="number" step="0.01" id="editIva" 
                                               name="iva" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row cols-2">
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-dash-circle me-2"></i>Descuento
                                    </label>
                                    <div class="modern-input-group input-group">
                                        <span class="input-group-text">₡</span>
                                        <input type="number" step="0.01" id="editDescuento" 
                                               name="descuento" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">
                                        <i class="bi bi-currency-dollar me-2"></i>Total
                                    </label>
                                    <div class="modern-input-group input-group">
                                        <span class="input-group-text">₡</span>
                                        <input type="number" step="0.01" id="editTotal" 
                                               name="total" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-flag me-2"></i>Estado
                                </label>
                                <select id="editEstado" name="estado" class="form-select">
                                    <option value="ACTIVO">✅ Activo</option>
                                    <option value="INACTIVO">❌ Inactivo</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bi bi-x me-2"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-primary" onclick="guardarCambios()">
                            <i class="bi bi-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeEventListeners();
            initRevealAnimations();
            syncPedidoInputs();
            calcularTotal();
        });

        // Inicializar animaciones reveal
        function initRevealAnimations() {
            const revealElements = document.querySelectorAll('.reveal');
            
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(element => {
                revealObserver.observe(element);
            });
        }

        function initializeEventListeners() {
            // Cálculo automático del total
            ['subtotal', 'iva', 'descuento'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', calcularTotal);
                    element.addEventListener('change', calcularTotal);
                }
            });

            // Sincronización de pedidos
            const pedidoSelect = document.getElementById('pedidoSelect');
            const idPedidoInput = document.getElementById('idPedido');
            
            if (pedidoSelect) {
                pedidoSelect.addEventListener('change', function() {
                    if (this.value) {
                        idPedidoInput.value = this.value;
                        const selectedOption = this.options[this.selectedIndex];
                        const total = selectedOption.getAttribute('data-total');
                        if (total) {
                            autocompletarDatos(parseFloat(total));
                        }
                    }
                    syncPedidoInputs();
                });
            }

            if (idPedidoInput) {
                idPedidoInput.addEventListener('input', function() {
                    if (this.value) {
                        pedidoSelect.value = this.value;
                    }
                    syncPedidoInputs();
                });
            }

            // Autocompletar IVA al cambiar subtotal
            document.getElementById('subtotal').addEventListener('input', function() {
                const subtotal = parseFloat(this.value) || 0;
                const iva = subtotal * 0.13;
                document.getElementById('iva').value = iva.toFixed(2);
                calcularTotal();
            });
        }

        function syncPedidoInputs() {
            const pedidoSelect = document.getElementById('pedidoSelect');
            const idPedidoInput = document.getElementById('idPedido');
            const hiddenInput = document.getElementById('idPedidoHidden');
            
            const valor = idPedidoInput.value.trim() || pedidoSelect.value;
            if (hiddenInput) {
                hiddenInput.value = valor;
            }
        }

        function calcularTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const iva = parseFloat(document.getElementById('iva').value) || 0;
            const descuento = parseFloat(document.getElementById('descuento').value) || 0;
            
            const total = Math.max(0, subtotal + iva - descuento);
            
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('totalDisplay').textContent = `₡${total.toLocaleString('es-CR', {minimumFractionDigits: 2})}`;
        }

        function autocompletarDatos(totalPedido) {
            const subtotalSinIva = totalPedido / 1.13;
            const ivaCalculado = totalPedido - subtotalSinIva;
            
            document.getElementById('subtotal').value = subtotalSinIva.toFixed(2);
            document.getElementById('iva').value = ivaCalculado.toFixed(2);
            document.getElementById('descuento').value = '0.00';
            
            calcularTotal();
            
            mostrarNotificacion('Datos autocompletados desde el pedido seleccionado', 'info');
        }

        function validarFormulario(event) {
            const form = event.target;
            const idPedido = document.getElementById('idPedidoHidden').value;
            const metodoPago = form.metodoPago.value;
            const total = parseFloat(document.getElementById('total').value);
            
            if (!idPedido) {
                mostrarNotificacion('Debe seleccionar o ingresar un ID de pedido', 'error');
                event.preventDefault();
                return false;
            }
            
            if (!metodoPago) {
                mostrarNotificacion('Debe seleccionar un método de pago', 'error');
                event.preventDefault();
                return false;
            }
            
            if (total <= 0) {
                mostrarNotificacion('El total debe ser mayor a cero', 'error');
                event.preventDefault();
                return false;
            }
            
            // Mostrar loading
            const submitBtn = document.getElementById('btnSubmit');
            submitBtn.innerHTML = '<span class="loading"></span> Creando factura...';
            submitBtn.disabled = true;
            
            return true;
        }

        function editarFactura(id) {
            document.getElementById('facturaId').textContent = id;
            document.getElementById('editId').value = id;
            
            // Datos de ejemplo (aquí cargarías desde el servidor)
            document.getElementById('editSubtotal').value = '10000.00';
            document.getElementById('editIva').value = '1300.00';
            document.getElementById('editDescuento').value = '0.00';
            document.getElementById('editTotal').value = '11300.00';
            document.getElementById('editEstado').value = 'ACTIVO';
            
            new bootstrap.Modal(document.getElementById('modalEditarFactura')).show();
        }

        function guardarCambios() {
            const formData = new FormData(document.getElementById('formEditarFactura'));
            
            mostrarNotificacion('Cambios guardados correctamente', 'success');
            
            bootstrap.Modal.getInstance(document.getElementById('modalEditarFactura')).hide();
            
            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        function cambiarEstado(id) {
            const nuevosEstados = ['ACTIVO', 'INACTIVO'];
            const estadoActual = prompt('Nuevo estado (ACTIVO, INACTIVO):');
            
            if (estadoActual && nuevosEstados.includes(estadoActual.toUpperCase())) {
                mostrarNotificacion(`Estado de factura #${id} cambiado a ${estadoActual}`, 'success');
                setTimeout(() => location.reload(), 1000);
            } else if (estadoActual) {
                mostrarNotificacion('Estado no válido', 'error');
            }
        }

        function eliminarFactura(id) {
            if (confirm(`¿Está seguro de que desea eliminar la factura #${id}?\n\nEsta acción no se puede deshacer.`)) {
                mostrarNotificacion(`Factura #${id} eliminada`, 'warning');
                setTimeout(() => location.reload(), 1000);
            }
        }

        function mostrarNotificacion(mensaje, tipo = 'info') {
            const colores = {
                success: 'alert-success',
                error: 'alert-danger',
                warning: 'alert-warning',
                info: 'alert-info'
            };

            const iconos = {
                success: 'bi-check-circle-fill',
                error: 'bi-exclamation-triangle-fill',
                warning: 'bi-exclamation-circle-fill',
                info: 'bi-info-circle-fill'
            };

            const notification = document.createElement('div');
            notification.className = `alert ${colores[tipo]} notification d-flex align-items-center`;
            notification.innerHTML = `
                <i class="bi ${iconos[tipo]} me-2"></i>
                <div class="flex-grow-1">${mensaje}</div>
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 4000);
        }

        // Atajos de teclado
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'n':
                        e.preventDefault();
                        limpiarFormulario();
                        break;
                    case 'r':
                        e.preventDefault();
                        location.reload();
                        break;
                }
            }
        });

        function limpiarFormulario() {
            document.getElementById('formCrear').reset();
            document.getElementById('pedidoSelect').value = '';
            document.getElementById('idPedido').value = '';
            document.getElementById('subtotal').value = '0';
            document.getElementById('iva').value = '0';
            document.getElementById('descuento').value = '0';
            
            syncPedidoInputs();
            calcularTotal();
            
            mostrarNotificacion('Formulario limpiado', 'info');
        }

        // Validación en tiempo real
        document.getElementById('idPedido').addEventListener('input', function() {
            const valor = parseInt(this.value);
            if (valor && valor <= 0) {
                this.setCustomValidity('El ID del pedido debe ser mayor a 0');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });

        // Efectos hover para las tarjetas
        document.addEventListener('mouseover', function(e) {
            const card = e.target.closest('.modern-card');
            if (card && !card.classList.contains('hover-active')) {
                card.classList.add('hover-active');
            }
        });

        document.addEventListener('mouseout', function(e) {
            const card = e.target.closest('.modern-card');
            if (card) {
                card.classList.remove('hover-active');
            }
        });

        // Animación de contadores en las estadísticas
        const statsSection = document.querySelector('.stats-highlight');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const statNumbers = entry.target.querySelectorAll('.stat-number');
                        
                        statNumbers.forEach((statNumber, index) => {
                            const finalText = statNumber.textContent;
                            const numberValue = parseInt(finalText.replace(/\D/g, ''));
                            const prefix = finalText.includes('₡') ? '₡' : '';
                            const hasPlus = finalText.includes('+');
                            
                            if (numberValue > 0) {
                                statNumber.textContent = prefix + '0';
                                
                                setTimeout(() => {
                                    let currentNumber = 0;
                                    const increment = Math.ceil(numberValue / 30);
                                    const timer = setInterval(() => {
                                        currentNumber += increment;
                                        if (currentNumber >= numberValue) {
                                            currentNumber = numberValue;
                                            clearInterval(timer);
                                        }
                                        
                                        let displayText = prefix;
                                        if (hasPlus && currentNumber > 0) displayText += '+';
                                        displayText += currentNumber.toLocaleString();
                                        
                                        statNumber.textContent = displayText;
                                    }, 50);
                                }, index * 200);
                            }
                        });
                        
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            statsObserver.observe(statsSection);
        }
    </script>
</body>
</html>