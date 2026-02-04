<?php
/**
 * Configuración de base de datos
 * Lee credenciales desde variables de entorno (.env)
 */

// Cargar variables de entorno
$env_file = dirname(__DIR__, 2) . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Configuración de conexión
$server = $_ENV['DB_SERVER'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'restaurante_brasabros_db';

// Crear conexión
$conexion = mysqli_connect($server, $username, $password, $database);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Configurar charset UTF-8
mysqli_set_charset($conexion, "utf8mb4");

?>