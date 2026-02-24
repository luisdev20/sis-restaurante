<?php
class AuthController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=login");
            exit();
        }

        $email = trim($_POST['email'] ?? '');
        $pass  = trim($_POST['password'] ?? '');

        // 1. VALIDACIÓN DEL ADMIN 
        if ($email === 'admin@brasabros.com' && $pass === 'admin123') {
            $_SESSION['usuario'] = [
                'nombre_completo' => 'Admin Principal',
                'email'           => $email,
                'rol'             => 'admin'
            ];
            header("Location: index.php?page=admin-dashboard");
            exit();
        }

        // 2. BUSCAR EN BASE DE DATOS 
        $stmt = mysqli_prepare($this->conexion, "SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

           
            if ($pass === $user['password']) {
                $_SESSION['usuario'] = $user;

                if ($user['rol'] === 'admin') {
                    header("Location: index.php?page=admin-dashboard");
                } else {
                    header("Location: index.php?page=home");
                }
                exit();
            }
        }

       
        header("Location: index.php?page=login&error=1");
        exit();
    }

    // Método para proteger rutas de admin
    public static function requireAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: index.php?page=login&error=2");
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit();
    }
}