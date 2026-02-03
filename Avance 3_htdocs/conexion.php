<?php

$server = "localhost";
$username = "root";
$password = "superadministrador";
$database = "restaurante_brasabros_db";
$conexion = mysqli_connect($server, $username, $password, $database);
if ($conexion -> connect_error) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
        echo "Conexión exitosa";
}

?>
