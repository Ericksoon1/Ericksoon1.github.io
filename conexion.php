<?php
$serverName = 'servidoriranomas.database.windows.net';  
$connectionOptions = array(
    'Database' => 'videojuegos_db',  
    'Uid' => 'adminsql',  
    'PWD' => 'junioRyzen3200$'  
);


$conexion = sqlsrv_connect($serverName, $connectionOptions);


if ($conexion === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
