<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$conexion = conectarDB();
$respuesta = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $conexion->real_escape_string($_POST['correo']);
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $contrasena = $conexion->real_escape_string($_POST['contrasena']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $edad = (int)$_POST['edad'];

    if (empty($correo) || empty($usuario) || empty($contrasena)) {
        $respuesta['error'] = true;
        $respuesta['mensaje'] = "Todos los campos son obligatorios";
    } else {
        // Verificar si ya existe el correo o el usuario
        $sql_check = "SELECT * FROM registros WHERE correo = '$correo' OR usuario = '$usuario'";
        $existe = $conexion->query($sql_check);

        if ($existe->num_rows > 0) {
            $respuesta['error'] = true;
            $respuesta['mensaje'] = "El correo o usuario ya está registrado";
        } else {
            $sql = "INSERT INTO registros (correo, usuario, contrasena, telefono, direccion, edad)
                    VALUES ('$correo', '$usuario', '$contrasena', '$telefono', '$direccion', $edad)";

            if ($conexion->query($sql)) {
                $respuesta['error'] = false;
                $respuesta['mensaje'] = "Usuario registrado con éxito";
                $respuesta['id'] = $conexion->insert_id;
            } else {
                $respuesta['error'] = true;
                $respuesta['mensaje'] = "Error al registrar: " . $conexion->error;
            }
        }
    }
} else {
    $respuesta['error'] = true;
    $respuesta['mensaje'] = "Método no válido";
}

echo json_encode($respuesta);
$conexion->close();
?>
