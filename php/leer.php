<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conexion = conectarDB();
$respuesta = array();

$sql = "SELECT id, correo, usuario, telefono, direccion, edad FROM registros ORDER BY id ASC";
$resultado = $conexion->query($sql);

if ($resultado) {
    $usuarios = array();
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila;
    }
    $respuesta['error'] = false;
    $respuesta['usuarios'] = $usuarios;
} else {
    $respuesta['error'] = true;
    $respuesta['mensaje'] = "Error al leer usuarios: " . $conexion->error;
}

echo json_encode($respuesta);
$conexion->close();
?>
