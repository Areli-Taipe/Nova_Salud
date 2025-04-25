<?php
require_once 'conexion.php';
header('Content-Type: application/json');

$conexion = conectarDB();
$id = (int)$_POST['id'];
$respuesta = [];

$sql = "DELETE FROM registros WHERE id = $id";
if ($conexion->query($sql)) {
    $respuesta['error'] = false;
    $respuesta['mensaje'] = "Usuario eliminado";
} else {
    $respuesta['error'] = true;
    $respuesta['mensaje'] = "Error al eliminar: " . $conexion->error;
}

echo json_encode($respuesta);
$conexion->close();
?>