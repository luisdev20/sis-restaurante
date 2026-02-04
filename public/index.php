<?php

session_start();

// Cargar configuración
require_once __DIR__ . '/../src/config/conexion.php';

// Obtener página solicitada
$page = $_GET['page'] ?? 'home';
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

        default:
            header("Location: index.php");
            exit();
    }
}

// Mapeo de páginas a archivos de vista
$pages = [
    'home' => 'home.php',
    'carta' => 'carta.php',
    'delivery' => 'delivery.php',
    'reserva' => 'reserva.php',
    'exito' => 'exito.php'
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
    echo "Vista no encontrada";
    exit();
}
?>