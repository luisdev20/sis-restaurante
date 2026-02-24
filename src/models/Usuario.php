<?php

class Usuario
{
    private $conexion;

    public $id;
    public $nombre_completo;
    public $email;
    public $password;
    public $rol;
    public $created_at;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->rol = 'cliente';
    }

    public function registrar()
    {
        if (!$this->validate()) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
        }

        $sql  = "INSERT INTO usuarios (nombre_completo, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
        }

        mysqli_stmt_bind_param($stmt, "ssss", $this->nombre_completo, $this->email, $this->password, $this->rol);

        if (mysqli_stmt_execute($stmt)) {
            $this->id = mysqli_insert_id($this->conexion);
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Usuario registrado con éxito'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar: ' . mysqli_error($this->conexion)];
        }
    }

    public function autenticar($email, $password)
    {
        $sql  = "SELECT * FROM usuarios WHERE email = ? AND password = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) return null;

        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data   = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($data) {
            $this->id              = $data['id'];
            $this->nombre_completo = $data['nombre_completo'];
            $this->rol             = $data['rol'];
            return $this;
        }
        return null;
    }

    // Traer todos los usuarios
    public function findAll()
    {
        $sql    = "SELECT id, nombre_completo, email, rol, created_at FROM usuarios ORDER BY id ASC";
        $result = mysqli_query($this->conexion, $sql);

        if (!$result) return [];

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Actualizar el rol de un usuario
    public function updateRol($nuevo_rol)
    {
        if (!$this->id) {
            return ['success' => false, 'message' => 'ID no especificado'];
        }

        $sql  = "UPDATE usuarios SET rol = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta'];
        }

        mysqli_stmt_bind_param($stmt, "si", $nuevo_rol, $this->id);

        if (mysqli_stmt_execute($stmt)) {
            $this->rol = $nuevo_rol;
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Rol actualizado correctamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar rol'];
        }
    }

    // Eliminar un usuario
    public function delete()
    {
        if (!$this->id) {
            return ['success' => false, 'message' => 'ID no especificado'];
        }

        $sql  = "DELETE FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error en la consulta'];
        }

        mysqli_stmt_bind_param($stmt, "i", $this->id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Usuario eliminado'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar'];
        }
    }

    private function validate()
    {
        return !empty($this->nombre_completo) && !empty($this->email) && !empty($this->password);
    }
}
?>