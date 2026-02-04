<?php

class Reserva
{
    private $conexion;

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $fecha;
    public $hora;
    public $invitados;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function save()
    {
        if (!$this->validate()) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
        }

        $sql = "INSERT INTO reservas (nombre, email, telefono, fecha, hora, invitados)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $this->nombre,
            $this->email,
            $this->telefono,
            $this->fecha,
            $this->hora,
            $this->invitados
        );

        if (mysqli_stmt_execute($stmt)) {
            $this->id = mysqli_insert_id($this->conexion);
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Reserva guardada correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al guardar la reserva: ' . mysqli_error($this->conexion)];
        }
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM reservas WHERE id = ?";
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
            $this->email = $data['email'];
            $this->telefono = $data['telefono'];
            $this->fecha = $data['fecha'];
            $this->hora = $data['hora'];
            $this->invitados = $data['invitados'];
            return $this;
        }

        return null;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM reservas ORDER BY fecha DESC, hora DESC";
        $result = mysqli_query($this->conexion, $sql);

        if (!$result) {
            return [];
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function delete()
    {
        if (!$this->id) {
            return ['success' => false, 'message' => 'ID no especificado'];
        }

        $sql = "DELETE FROM reservas WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta'];
        }

        mysqli_stmt_bind_param($stmt, "i", $this->id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Reserva eliminada'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar'];
        }
    }

    private function validate()
    {
        return !empty($this->nombre) &&
            !empty($this->email) &&
            !empty($this->telefono) &&
            !empty($this->fecha) &&
            !empty($this->hora) &&
            !empty($this->invitados);
    }
}
?>