<?php

class Delivery
{
    private $conexion;

    public $id;
    public $nombre;
    public $telefono;
    public $direccion;
    public $referencia;
    public $metodo_pago;
    public $producto;
    public $fecha_pedido;
    public $estado;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->estado = 'pendiente';
    }

    public function save()
    {
        if (!$this->validate()) {
            return ['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados'];
        }

        $sql = "INSERT INTO pedidos_delivery 
                (nombre, telefono, direccion, referencia, metodo_pago, producto, fecha_pedido, estado)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssssss",
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->referencia,
            $this->metodo_pago,
            $this->producto,
            $this->estado
        );

        if (mysqli_stmt_execute($stmt)) {
            $this->id = mysqli_insert_id($this->conexion);
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Pedido registrado correctamente. Nos comunicaremos contigo pronto.'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar el pedido: ' . mysqli_error($this->conexion)];
        }
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM pedidos_delivery WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($data) {
            $this->id = $data['id'];
            $this->nombre = $data['nombre'];
            $this->telefono = $data['telefono'];
            $this->direccion = $data['direccion'];
            $this->referencia = $data['referencia'];
            $this->metodo_pago = $data['metodo_pago'];
            $this->producto = $data['producto'];
            $this->fecha_pedido = $data['fecha_pedido'];
            $this->estado = $data['estado'];
            return $this;
        }

        return null;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM pedidos_delivery ORDER BY fecha_pedido DESC";
        $result = mysqli_query($this->conexion, $sql);

        if (!$result) {
            return [];
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function updateEstado($nuevoEstado)
    {
        if (!$this->id) {
            return ['success' => false, 'message' => 'ID no especificado'];
        }

        $sql = "UPDATE pedidos_delivery SET estado = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta'];
        }

        mysqli_stmt_bind_param($stmt, "si", $nuevoEstado, $this->id);

        if (mysqli_stmt_execute($stmt)) {
            $this->estado = $nuevoEstado;
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Estado actualizado'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar'];
        }
    }

    public function delete()
    {
        if (!$this->id) {
            return ['success' => false, 'message' => 'ID no especificado'];
        }

        $sql = "DELETE FROM pedidos_delivery WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta'];
        }

        mysqli_stmt_bind_param($stmt, "i", $this->id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Pedido eliminado'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar'];
        }
    }

    private function validate()
    {
        return !empty($this->nombre) &&
            !empty($this->telefono) &&
            !empty($this->direccion) &&
            !empty($this->producto);
    }
}
?>