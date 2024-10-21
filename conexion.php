<?php
$host = 'servidoriranomas.database.windows.net';  
$usuario = 'adminsql';  
$contraseña = 'junioRyzen3200$';  
$base_de_datos = 'videojuegos_db';  


$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);


if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}
?>
