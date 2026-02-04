<?php
/**
 * Controlador de Delivery
 */

class DeliveryController
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
            $_SESSION['success'] = $result['message'];
            header("Location: index.php?page=delivery");
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header("Location: index.php?page=delivery");
            exit();
        }
    }

    /**
     * Guardar pedido de delivery
     */
    public function guardar($nombre, $telefono, $direccion, $referencia, $pago, $producto)
    {
        // Validar datos
        if (empty($nombre) || empty($telefono) || empty($direccion) || empty($producto)) {
            return ['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados'];
        }

        $sql = "INSERT INTO pedidos_delivery 
                (nombre, telefono, direccion, referencia, metodo_pago, producto, fecha_pedido)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssss",
            $nombre,
            $telefono,
            $direccion,
            $referencia,
            $pago,
            $producto
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Pedido registrado correctamente. Nos comunicaremos contigo pronto.'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar el pedido: ' . mysqli_error($this->conexion)];
        }
    }
}
?>