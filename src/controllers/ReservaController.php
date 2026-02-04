<?php
/**
 * Controlador de Reservas
 */

require_once dirname(__DIR__) . '/config/conexion.php';

class ReservaController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function guardar($nombre, $email, $telefono, $fecha, $hora, $invitados) {
        $sql = "INSERT INTO reservas 
                (nombre, email, telefono, fecha, hora, invitados)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        // Validar datos
        if (empty($nombre) || empty($email) || empty($telefono) || empty($fecha) || empty($hora) || empty($invitados)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
        }

        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssssi",
            $nombre,
            $email,
            $telefono,
            $fecha,
            $hora,
            $invitados
        );

        // Ejecutar
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Reserva guardada correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar la reserva: ' . mysqli_error($this->conexion)];
        }
    }
}

// Procesar formulario POST
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
        header("Location: ../views/exito.php");
        exit();
    } else {
        // Mostrar error (puedes mejorar esto con una vista de error)
        die("Error: " . $result['message']);
    }
}
?>
