<?php
class RegistroController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=login");
            exit();
        }

       
        $nombre = $_POST['nombre_completo'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';

      
        $sql = "INSERT INTO usuarios (nombre_completo, email, password, rol) 
                VALUES ('$nombre', '$email', '$pass', 'cliente')";

        if (mysqli_query($this->conexion, $sql)) {
            header("Location: index.php?page=login&registrado=1");
        } else {
            header("Location: index.php?page=login&error=1");
        }
        exit();
    }
}
?>