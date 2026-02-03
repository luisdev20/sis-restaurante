<?php
include("conexion.php");

$nombre   = $_POST['nombre'];
$email    = $_POST['email'];
$telefono = $_POST['telefono'];
$fecha    = $_POST['fecha'];
$hora     = $_POST['hora'];
$invitados= $_POST['invitados'];

$sql = "INSERT INTO reservas 
(nombre, email, telefono, fecha, hora, invitados)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ssissi",
    $nombre,
    $email,
    $telefono,
    $fecha,
    $hora,
    $invitados
);

if(mysqli_stmt_execute($stmt)){
    echo "Reserva registrada con exito";
}else{
    echo "Error en la reserva: " . mysqli_error($conexion);
}

?>
