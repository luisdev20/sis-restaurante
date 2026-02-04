<?php
/**
 * Controlador de Reservas
 */

class ReservaController
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /**
     * Procesar petición POST del formulario
     */
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=reserva");
            exit();
        }

        $result = $this->guardar(
            $_POST['nombre'] ?? '',
            $_POST['email'] ?? '',
            $_POST['telefono'] ?? '',
            $_POST['fecha'] ?? '',
            $_POST['hora'] ?? '',
            $_POST['invitados'] ?? ''
        );

        if ($result['success']) {
            header("Location: index.php?page=exito");
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: index.php?page=reserva");
            exit();
        }
    }

    /**
     * Guardar reserva en la base de datos
     */
    public function guardar($nombre, $email, $telefono, $fecha, $hora, $invitados)
    {
        // Validar datos
        if (empty($nombre) || empty($email) || empty($telefono) || empty($fecha) || empty($hora) || empty($invitados)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
        }

        $sql = "INSERT INTO reservas 
                (nombre, email, telefono, fecha, hora, invitados)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        // Vincular parámetros
        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
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
?>