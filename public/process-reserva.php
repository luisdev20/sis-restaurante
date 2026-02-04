<?php
/**
 * Procesar formulario de reserva
 */

require_once dirname(__DIR__) . '/src/config/conexion.php';
require_once dirname(__DIR__) . '/src/controllers/ReservaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva = new ReservaController($conexion);
    $result = $reserva->guardar(
        $_POST['nombre'] ?? '',
        $_POST['email'] ?? '',
        $_POST['telefono'] ?? '',
        $_POST['fecha'] ?? '',
        $_POST['hora'] ?? '',
        $_POST['invitados'] ?? ''
    );

    if ($result['success']) {
        header("Location: exito.php");
        exit();
    } else {
        // Redirigir a la página de error con el mensaje
        $_SESSION['error'] = $result['message'];
        header("Location: reserva.php");
        exit();
    }
} else {
    header("Location: reserva.php");
    exit();
}
?>
