<?php
require_once 'conexion.php';

$conexion = conectarDB();

$sql = "TRUNCATE TABLE registros";

if ($conexion->query($sql)) {
    echo "✅ Tabla vaciada con éxito";
} else {
    echo "❌ Error al vaciar la tabla: " . $conexion->error;
}

$conexion->close();
?>
<!-- VACIAR TABLA:
http://localhost/Nova%20Salud/php/vaciarTabla.php
-->
 