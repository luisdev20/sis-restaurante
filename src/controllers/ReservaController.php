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

    public function guardar($nombre, $email, $telefono, $fecha, $hora, $invitados)
    {
        require_once __DIR__ . '/../models/Reserva.php';

        $reserva = new Reserva($this->conexion);
        $reserva->nombre = $nombre;
        $reserva->email = $email;
        $reserva->telefono = $telefono;
        $reserva->fecha = $fecha;
        $reserva->hora = $hora;
        $reserva->invitados = $invitados;

        return $reserva->save();
    }
}
?>