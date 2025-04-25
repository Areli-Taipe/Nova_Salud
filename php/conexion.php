<?php
require_once 'config.php';

function conectarDB() {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Establecer conjunto de caracteres utf8
    $conexion->set_charset("utf8");
    
    return $conexion;
}
?>