<?php

class ReservaController
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=reserva");
            exit();
        }

        $result = $this->guardar(
            $_POST['nombre']    ?? '',
            $_POST['email']     ?? '',
            $_POST['telefono']  ?? '',
            $_POST['fecha']     ?? '',
            $_POST['hora']      ?? '',
            $_POST['invitados'] ?? ''
        );

        if ($result['success']) {
            header("Location: index.php?page=exito_reserva");
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: index.php?page=reserva");
            exit();
        }
    }

    public function guardar($nombre, $email, $telefono, $fecha, $hora, $invitados)
    {
        require_once __DIR__ . '/../models/Reserva.php';

        $reserva           = new Reserva($this->conexion);
        $reserva->nombre   = $nombre;
        $reserva->email    = $email;
        $reserva->telefono = $telefono;
        $reserva->fecha    = $fecha;
        $reserva->hora     = $hora;
        $reserva->invitados = $invitados;

        return $reserva->save();
    }

    // Cambiar el estado de una reserva desde el panel admin
    public function cambiarEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin-reservas");
            exit();
        }

        $id           = $_POST['id']           ?? 0;
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        // Validar que el estado sea válido
        $estados_validos = ['pendiente', 'confirmada', 'cancelada'];

        if (!in_array($nuevo_estado, $estados_validos)) {
            $_SESSION['error'] = 'Estado no válido';
            header("Location: index.php?page=admin-reservas");
            exit();
        }

        require_once __DIR__ . '/../models/Reserva.php';

        $reserva     = new Reserva($this->conexion);
        $reserva->id = $id;

        $result = $reserva->updateEstado($nuevo_estado);

        if ($result['success']) {
            $_SESSION['success'] = 'Estado de reserva actualizado correctamente';
        } else {
            $_SESSION['error'] = $result['message'];
        }

        header("Location: index.php?page=admin-reservas");
        exit();
    }
}
?>