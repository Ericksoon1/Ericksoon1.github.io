<?php
$host = 'localhost';
$usuario = 'root'; // Usuario de la base de datos
$contraseña = '';  // Contraseña del usuario
$base_de_datos = 'videojuegos_db'; // Nombre de la base de datos
 
// Crear la conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);
 
// Verificar si la conexión es exitosa
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}
?>
 