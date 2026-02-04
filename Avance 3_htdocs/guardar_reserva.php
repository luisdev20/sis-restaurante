<?php
include("conexion.php");

$nombre    = $_POST['nombre'];
$email     = $_POST['email'];
$telefono  = $_POST['telefono'];
$fecha     = $_POST['fecha'];
$hora      = $_POST['hora'];
$invitados = $_POST['invitados'];

$sql = "INSERT INTO reservas 
(nombre, email, telefono, fecha, hora, invitados)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $sql);

// 5 strings y 1 entero
mysqli_stmt_bind_param($stmt, "sssssi",
    $nombre,
    $email,
    $telefono,
    $fecha,
    $hora,
    $invitados
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: exito.html");
    exit();
} else {
    header("Location: error.html");
    exit();
}
?>
