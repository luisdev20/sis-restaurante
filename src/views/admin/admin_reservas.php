<?php
// Protección: solo admin puede ver esto
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

$admin_nombre = $_SESSION['usuario']['nombre_completo'] ?? 'Admin';

// Traer todas las reservas desde la BD
require_once __DIR__ . '/../../models/Reserva.php';
$reservaModel = new Reserva($conexion);
$reservas     = $reservaModel->findAll();

// Capacidad max de mesas
$capacidad_max   = 10;
$total_reservas  = count($reservas);
$porcentaje      = ($total_reservas / $capacidad_max) * 100;

// Contar num invitados
$total_invitados = 0;
foreach ($reservas as $r) {
    $total_invitados += $r['invitados'];
}

// Filtro de búsqueda
$busqueda = $_GET['busqueda'] ?? '';

// Filtrar reservas si hay búsqueda
$reservas_filtradas = [];
foreach ($reservas as $r) {
    $coincide = empty($busqueda) ||
        stripos($r['nombre'],   $busqueda) !== false ||
        stripos($r['email'],    $busqueda) !== false ||
        stripos($r['telefono'], $busqueda) !== false;

    if ($coincide) {
        $reservas_filtradas[] = $r;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas | BrasaBros Admin</title>
    <link rel="stylesheet" href="assets/styles/admin.css">
</head>
<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="brand-icon">🍖</div>
                <div>
                    <div class="brand-name">BrasaBros</div>
                    <div class="brand-sub">Panel Admin</div>
                </div>
            </div>
            <button class="sidebar-close" onclick="toggleSidebar()">✕</button>
        </div>

        <nav class="sidebar-nav">

            <a href="index.php?page=admin-dashboard" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <a href="index.php?page=admin-delivery" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/>
                </svg>
                Pedidos Delivery
            </a>

            <a href="index.php?page=admin-reservas" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Reservas
            </a>

            <a href="index.php?page=admin-usuarios" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                Usuarios
            </a>

            <a href="index.php?page=admin-carta" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10"/>
                </svg>
                Modificar Carta
            </a>

            <a href="index.php?page=admin-reportes" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10v-3"/>
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                </svg>
                Reportes
            </a>

        </nav>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content" id="mainContent">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="topbar-brand">
                    <div class="brand-icon">🍖</div>
                    <div>
                        <div class="brand-name">BrasaBros</div>
                        <div class="brand-sub">Panel de Administración</div>
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <div class="date-picker-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" width="15" height="15">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <input type="date" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="admin-info">
                    <div class="admin-name"><?= htmlspecialchars($admin_nombre) ?></div>
                    <div class="admin-role">Administrador</div>
                </div>

                <form method="POST" action="index.php?action=logout" style="display:inline;">
                    <button type="submit" class="logout-btn" title="Cerrar sesión">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- PÁGINA: RESERVAS -->
        <main class="page-body">

            <div class="page-header">
                <h1>Reservas</h1>
                <p>Gestión de reservas de mesas</p>
            </div>

            <!-- AFORO -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="capacity-header">
                    <div class="capacity-title">
                         Aforo de Mesas
                    </div>
                    <div class="capacity-count"><?= $total_reservas ?> / <?= $capacidad_max ?></div>
                </div>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill <?= $porcentaje >= 80 ? 'warning' : '' ?> <?= $porcentaje >= 95 ? 'danger' : '' ?>"
                             style="width: <?= min($porcentaje, 100) ?>%"></div>
                    </div>
                </div>
                <span class="disponible-badge">Disponible</span>
                <span style="font-size: 13px; color: var(--gray-500); margin-left: 10px;">
                    <?= $total_invitados ?> invitados totales
                </span>
            </div>

            <!-- BÚSQUEDA -->
            <div class="card" style="margin-bottom: 20px;">
                <form method="GET" action="index.php" class="filters-bar">
                    <input type="hidden" name="page" value="admin-reservas">
                    <div class="search-input-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="busqueda" placeholder="Buscar por nombre, email o teléfono..."
                               value="<?= htmlspecialchars($busqueda) ?>">
                    </div>
                </form>
            </div>

            <!-- TABLA DE RESERVAS -->
            <div class="card">
                <div class="section-title">Reservas (<?= count($reservas_filtradas) ?>)</div>

                <?php if (empty($reservas_filtradas)): ?>
                    <p style="color: var(--gray-400); text-align: center; padding: 40px 0;">
                        No se encontraron reservas.
                    </p>
                <?php else: ?>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Invitados</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas_filtradas as $r): ?>
                            <tr>
                                <td>#<?= $r['id'] ?></td>
                                <td><?= htmlspecialchars($r['nombre']) ?></td>
                                <td><?= htmlspecialchars($r['email']) ?></td>
                                <td><?= htmlspecialchars($r['telefono']) ?></td>
                                <td><?= $r['fecha'] ?></td>
                                <td><?= $r['hora'] ?></td>
                                <td><?= $r['invitados'] ?></td>
                                <td>
                                    <?php $estado = $r['estado'] ?? 'pendiente'; ?>
                                    <?php if ($estado === 'confirmada'): ?>
                                        <span class="badge badge-confirmada">confirmada</span>
                                    <?php elseif ($estado === 'pendiente'): ?>
                                        <span class="badge badge-pendiente">pendiente</span>
                                    <?php elseif ($estado === 'cancelada'): ?>
                                        <span class="badge badge-cancelado">cancelada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    
                                    <a href="index.php?page=admin-reservas&ver=<?= $r['id'] ?>" class="btn-icon" title="Ver detalle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                               
                                    <form method="POST" action="index.php?action=admin-cambiar-estado-reserva" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                        <select name="nuevo_estado" class="select-filter"
                                                style="padding: 4px 8px; font-size: 12px;"
                                                onchange="this.form.submit()">
                                            <option value="">Cambiar estado</option>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="confirmada">Confirmada</option>
                                            <option value="cancelada">Cancelada</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

        </main>

    </div><!-- /main-content -->

</div><!-- /admin-wrapper -->

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        var main    = document.getElementById('mainContent');

        sidebar.classList.toggle('hidden');
        overlay.classList.toggle('active');
        main.classList.toggle('sidebar-collapsed');
    }
</script>

</body>
</html>