<?php

session_start();

// Cargar configuración
require_once __DIR__ . '/../src/config/conexion.php';

// Obtener página solicitada
$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? null;

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    switch ($action) {
        case 'reserva':
            require_once __DIR__ . '/../src/controllers/ReservaController.php';
            $controller = new ReservaController($conexion);
            $controller->process();
            break;

        case 'delivery':
            require_once __DIR__ . '/../src/controllers/DeliveryController.php';
            $controller = new DeliveryController($conexion);
            $controller->process();
            break;

        case 'login':
            require_once __DIR__ . '/../src/controllers/AuthController.php';
            $controller = new AuthController($conexion);
            $controller->login();
            break;

        case 'logout':
            require_once __DIR__ . '/../src/controllers/AuthController.php';
            $controller = new AuthController($conexion);
            $controller->logout();
            break;

        case 'registro':
            require_once __DIR__ . '/../src/controllers/RegistroController.php';
            $controller = new RegistroController($conexion);
            $controller->process();
            break;

        // NUEVO: Cambiar estado de un pedido delivery desde el panel admin
        case 'admin-cambiar-estado-delivery':
            require_once __DIR__ . '/../src/controllers/DeliveryController.php';
            $controller = new DeliveryController($conexion);
            $controller->cambiarEstado();
            break;

        // NUEVO: Cambiar estado de una reserva desde el panel admin
        case 'admin-cambiar-estado-reserva':
            require_once __DIR__ . '/../src/controllers/ReservaController.php';
            $controller = new ReservaController($conexion);
            $controller->cambiarEstado();
            break;

        // NUEVO: Cambiar rol de un usuario desde el panel admin
        case 'admin-cambiar-rol':
            require_once __DIR__ . '/../src/models/Usuario.php';
            $id        = $_POST['id']        ?? 0;
            $nuevo_rol = $_POST['nuevo_rol'] ?? '';
            $roles_validos = ['admin', 'cliente'];
            if (in_array($nuevo_rol, $roles_validos)) {
                $usuario     = new Usuario($conexion);
                $usuario->id = $id;
                $usuario->updateRol($nuevo_rol);
            }
            header("Location: index.php?page=admin-usuarios");
            exit();

        // NUEVO: Eliminar usuario desde el panel admin
        case 'admin-eliminar-usuario':
            require_once __DIR__ . '/../src/models/Usuario.php';
            $id      = $_POST['id'] ?? 0;
            $usuario = new Usuario($conexion);
            $usuario->id = $id;
            $usuario->delete();
            header("Location: index.php?page=admin-usuarios");
            exit();

        default:
            header("Location: index.php");
            exit();
    }
}

// Páginas que requieren ser admin
$admin_pages = [
    'admin-dashboard',
    'admin-delivery',
    'admin-reservas',
    'admin-usuarios',
    'admin-carta',
    'admin-reportes'
];

// Proteger rutas admin
if (in_array($page, $admin_pages)) {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        header("Location: index.php?page=login&error=2");
        exit();
    }
}

// Mapeo de páginas a vistas
$pages = [
    // Páginas de usuario
    'home'           => 'home.php',
    'carta'          => 'carta.php',
    'delivery'       => 'delivery.php',
    'reserva'        => 'reserva.php',
    'login'          => 'login.php',
    'exito_reserva'  => 'exito_reserva.php',
    'exito_delivery' => 'exito_delivery.php',

    // Páginas de administrador
    'admin-dashboard' => 'admin/dashboard.php',
    'admin-delivery'  => 'admin/admin_delivery.php',
    'admin-reservas'  => 'admin/admin_reservas.php',
    'admin-usuarios'  => 'admin/admin_usuarios.php',
    'admin-carta'     => 'admin/admin_carta.php',
    'admin-reportes'  => 'admin/admin_reportes.php',
];

// Verificar si la página existe
if (!isset($pages[$page])) {
    http_response_code(404);
    echo "Página no encontrada";
    exit();
}

// Cargar la vista
$viewFile = __DIR__ . '/../src/views/' . $pages[$page];
if (file_exists($viewFile)) {
    require_once $viewFile;
} else {
    http_response_code(404);
    echo "Vista no encontrada en: " . $viewFile;
    exit();
}
?>