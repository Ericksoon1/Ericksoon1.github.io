<?php
$serverName = 'servidoriranomas.database.windows.net';  
$connectionOptions = array(
    'Database' => 'videojuegos_db',  
    'Uid' => 'adminsql',  
    'PWD' => 'junioRyzen3200$'  
);

// Establecer la conexión con SQL Server
$conexion = sqlsrv_connect($serverName, $connectionOptions);

// Verificar si la conexión fue exitosa
if ($conexion === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
