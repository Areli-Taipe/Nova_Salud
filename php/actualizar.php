<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conexion = conectarDB();
$respuesta = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $correo = $conexion->real_escape_string($_POST['correo']);
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $edad = (int)$_POST['edad'];

    $sql = "UPDATE registros SET 
                correo = '$correo',
                usuario = '$usuario',
                telefono = '$telefono',
                direccion = '$direccion',
                edad = $edad
            WHERE id = $id";

    if ($conexion->query($sql)) {
        $respuesta['error'] = false;
        $respuesta['mensaje'] = "Usuario actualizado correctamente";
    } else {
        $respuesta['error'] = true;
        $respuesta['mensaje'] = "Error al actualizar: " . $conexion->error;
    }
} else {
    $respuesta['error'] = true;
    $respuesta['mensaje'] = "Método no permitido";
}

echo json_encode($respuesta);
$conexion->close();
?>