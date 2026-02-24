<?php
// solo admin puede ver esto
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

$admin_nombre = $_SESSION['usuario']['nombre_completo'] ?? 'Admin';

// Traer todos los usuarios desde la BD
require_once __DIR__ . '/../../models/Usuario.php';
$usuarioModel = new Usuario($conexion);
$usuarios     = $usuarioModel->findAll();


$total_usuarios = count($usuarios);
$total_admins   = 0;
$total_clientes = 0;
foreach ($usuarios as $u) {
    if ($u['rol'] === 'admin')   $total_admins++;
    if ($u['rol'] === 'cliente') $total_clientes++;
}


$busqueda    = $_GET['busqueda'] ?? '';
$filtro_rol  = $_GET['rol']      ?? '';

$usuarios_filtrados = [];
foreach ($usuarios as $u) {
    $coincide_busqueda = empty($busqueda) ||
        stripos($u['nombre_completo'], $busqueda) !== false ||
        stripos($u['email'],           $busqueda) !== false;

    $coincide_rol = empty($filtro_rol) || $u['rol'] === $filtro_rol;

    if ($coincide_busqueda && $coincide_rol) {
        $usuarios_filtrados[] = $u;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | BrasaBros Admin</title>
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

            <a href="index.php?page=admin-reservas" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Reservas
            </a>

            <a href="index.php?page=admin-usuarios" class="nav-item active">
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

        <!-- PÁGINA: USUARIOS -->
        <main class="page-body">

            <div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h1>Usuarios</h1>
                    <p>Gestión de usuarios del sistema</p>
                </div>
                <a href="index.php?page=admin-agregar-usuario" class="btn btn-primary">
                    + Agregar Usuario
                </a>
            </div>

         
            <div class="stats-grid" style="margin-bottom: 20px;">
                <div class="stat-card">
                    <div class="stat-info">
                        <label>Total Usuarios</label>
                        <div class="stat-number"><?= $total_usuarios ?></div>
                    </div>
                    <div class="stat-icon blue"></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <label>Administradores</label>
                        <div class="stat-number"><?= $total_admins ?></div>
                    </div>
                    <div class="stat-icon orange"></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <label>Clientes</label>
                        <div class="stat-number"><?= $total_clientes ?></div>
                    </div>
                    <div class="stat-icon green"></div>
                </div>
            </div>

            <!-- FILTROS -->
            <div class="card" style="margin-bottom: 20px;">
                <form method="GET" action="index.php" class="filters-bar">
                    <input type="hidden" name="page" value="admin-usuarios">
                    <div class="search-input-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="busqueda" placeholder="Buscar por nombre o email..."
                               value="<?= htmlspecialchars($busqueda) ?>">
                    </div>
                    <select name="rol" class="select-filter" onchange="this.form.submit()">
                        <option value="">Todos los roles</option>
                        <option value="admin"   <?= $filtro_rol === 'admin'   ? 'selected' : '' ?>>Administrador</option>
                        <option value="cliente" <?= $filtro_rol === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    </select>
                </form>
            </div>

            
            <div class="card">
                <div class="section-title">Usuarios (<?= count($usuarios_filtrados) ?>)</div>

                <?php if (empty($usuarios_filtrados)): ?>
                    <p style="color: var(--gray-400); text-align: center; padding: 40px 0;">
                        No se encontraron usuarios.
                    </p>
                <?php else: ?>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios_filtrados as $u): ?>
                            <tr>
                                <td>#<?= $u['id'] ?></td>
                                <td><?= htmlspecialchars($u['nombre_completo']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <?php if ($u['rol'] === 'admin'): ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php else: ?>
                                        <span class="badge badge-cliente">Cliente</span>
                                    <?php endif; ?>
                                </td>
                                <td style="display:flex; align-items:center; gap:8px;">

                                    <!-- Cambiar rol -->
                                    <form method="POST" action="index.php?action=admin-cambiar-rol" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <select name="nuevo_rol" class="select-filter"
                                                style="padding: 4px 8px; font-size: 12px;"
                                                onchange="this.form.submit()">
                                            <option value="">Cambiar rol</option>
                                            <option value="admin">Admin</option>
                                            <option value="cliente">Cliente</option>
                                        </select>
                                    </form>

                              
                                    <?php if ($u['email'] !== $_SESSION['usuario']['email']): ?>
                                    <form method="POST" action="index.php?action=admin-eliminar-usuario"
                                          style="display:inline;"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <button type="submit" class="btn-icon" title="Eliminar"
                                                style="color: var(--red);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 00-1-1h-4a1 1 0 00-1 1m-4 0h10"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

        </main>

    </div>

</div>

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