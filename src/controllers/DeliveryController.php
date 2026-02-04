<?php

class DeliveryController
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=delivery");
            exit();
        }

        $result = $this->guardar(
            $_POST['nombre'] ?? '',
            $_POST['telefono'] ?? '',
            $_POST['direccion'] ?? '',
            $_POST['referencia'] ?? '',
            $_POST['pago'] ?? 'efectivo',
            $_POST['producto'] ?? ''
        );

        if ($result['success']) {
            header("Location: index.php?page=exito_delivery");
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: index.php?page=delivery");
            exit();
        }
    }

    public function guardar($nombre, $telefono, $direccion, $referencia, $pago, $producto)
    {
        require_once __DIR__ . '/../models/Delivery.php';

        $delivery = new Delivery($this->conexion);
        $delivery->nombre = $nombre;
        $delivery->telefono = $telefono;
        $delivery->direccion = $direccion;
        $delivery->referencia = $referencia;
        $delivery->metodo_pago = $pago;
        $delivery->producto = $producto;

        return $delivery->save();
    }
}
?>